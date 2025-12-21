<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\Cuota;
use App\Models\SavingsAccount;
use App\Models\GastoAdministrativo;
use App\Models\CierreAnual;
use Illuminate\Http\Request;

class ExcedenteController extends Controller
{
    public function informe(Request $request)
    {
        $anio = $request->anio ?? date('Y');

        // 1. INGRESOS Y GASTOS TOTALES
        $ingresosBrutos = Cuota::whereYear('fecha_vencimiento', $anio)
            ->whereIn('estado', ['pagado', 'pagada'])
            ->sum('interes');

        $gastosTotales = GastoAdministrativo::whereYear('fecha', $anio)->sum('monto');

        // 2. LÓGICA PARA EL GRÁFICO MENSUAL
        $mensual_ingresos = [];
        $mensual_gastos = [];
        for ($m = 1; $m <= 12; $m++) {
            $mensual_ingresos[] = Cuota::whereYear('fecha_vencimiento', $anio)
                ->whereMonth('fecha_vencimiento', $m)
                ->whereIn('estado', ['pagado', 'pagada'])
                ->sum('interes');

            $mensual_gastos[] = GastoAdministrativo::whereYear('fecha', $anio)
                ->whereMonth('fecha', $m)
                ->sum('monto');
        }

        // 3. RETENCIONES LEGALES
        $excedentePrevio = $ingresosBrutos - $gastosTotales;
        $excedenteBase = $excedentePrevio > 0 ? $excedentePrevio : 0;

        $ret_educacion = $excedenteBase * 0.05;
        $ret_legal = $excedenteBase * 0.10;
        $ret_incobrables = $ingresosBrutos * 0.01;

        $excedenteNetoADistribuir = $excedenteBase - ($ret_educacion + $ret_legal + $ret_incobrables);
        if($excedenteNetoADistribuir < 0) $excedenteNetoADistribuir = 0;

        // 4. LÓGICA 50-50
        $fondoPatrocinio = $excedenteNetoADistribuir * 0.50;
        $fondoCapitalizacion = $excedenteNetoADistribuir * 0.50;

        $factorPatrocinio = $ingresosBrutos > 0 ? ($fondoPatrocinio / $ingresosBrutos) : 0;

        // --- LÓGICA DE PERMANENCIA (SOLO SOCIOS CON AHORRO EN DICIEMBRE) ---
        $socios = Socio::with('user')
            ->withSum('cuentas as ahorro_total_real', 'balance')
            ->where('activo', true)
            ->whereHas('cuentas.transactions', function ($query) use ($anio) {
                $query->whereYear('date', $anio)
                      ->whereMonth('date', 12)
                      ->whereIn('type', ['deposit', 'interest', 'deposito']);
            })
            ->get();

        // Sumamos el total de ahorros solo de los socios que calificaron (los que están en diciembre)
        $totalAhorrosGeneral = $socios->sum('ahorro_total_real') ?: 0;

        // Calculamos el factor de capitalización basado en el ahorro de los socios calificados
        $factorCapitalizacion = $totalAhorrosGeneral > 0 ? ($fondoCapitalizacion / $totalAhorrosGeneral) : 0;

        $reporte = [];
        foreach ($socios as $socio) {
            // Intereses pagados por el socio en el año
            $interesesSocio = Cuota::whereHas('prestamo', fn($q) => $q->where('socio_id', $socio->id))
                ->whereYear('fecha_vencimiento', $anio)
                ->whereIn('estado', ['pagado', 'pagada'])
                ->sum('interes');

            // Obtenemos el balance real
            $ahorroRealSocio = (float) ($socio->ahorro_total_real ?? 0);

            $monto_pat = $interesesSocio * $factorPatrocinio;
            $monto_cap = $ahorroRealSocio * $factorCapitalizacion;

            $reporte[] = [
                'nombre' => $socio->user->name ?? 'Socio sin usuario',
                'cedula' => $socio->user->cedula ?? 'N/A',
                'base_intereses' => $interesesSocio,
                'base_ahorros' => $ahorroRealSocio,
                'monto_pat' => $monto_pat,
                'monto_cap' => $monto_cap,
                'total_socio' => $monto_pat + $monto_cap
            ];
        }

        return view('admin.excedentes.informe', compact(
            'reporte', 'anio', 'ingresosBrutos', 'gastosTotales',
            'ret_educacion', 'ret_legal', 'ret_incobrables',
            'excedenteNetoADistribuir', 'mensual_ingresos', 'mensual_gastos',
            'fondoPatrocinio', 'fondoCapitalizacion'
        ));
    }

    public function gastosIndex(Request $request)
    {
        $anio = $request->anio ?? date('Y');
        $gastos = GastoAdministrativo::whereYear('fecha', $anio)->orderBy('fecha', 'desc')->get();
        $categorias = GastoAdministrativo::getCategorias();
        return view('admin.excedentes.gastos', compact('gastos', 'categorias', 'anio'));
    }

    public function gastosStore(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria' => 'required|string'
        ]);

        GastoAdministrativo::create($request->all());
        return back()->with('success', 'Gasto registrado correctamente');
    }

    public function gastosDestroy(GastoAdministrativo $gasto)
    {
        $gasto->delete();
        return back()->with('success', 'Gasto eliminado');
    }

    public function store(Request $request)
    {
        $request->validate(['anio' => 'required|integer']);

        if (CierreAnual::where('anio', $request->anio)->exists()) {
            return back()->with('error', 'El año ' . $request->anio . ' ya ha sido cerrado oficialmente.');
        }

        $ingresosBrutos = Cuota::whereYear('fecha_vencimiento', $request->anio)
            ->whereIn('estado', ['pagado', 'pagada'])
            ->sum('interes');

        $gastosTotales = GastoAdministrativo::whereYear('fecha', $request->anio)->sum('monto');

        $excedenteBruto = $ingresosBrutos - $gastosTotales;
        $excedenteBase = $excedenteBruto > 0 ? $excedenteBruto : 0;

        $ret_educacion = $excedenteBase * 0.05;
        $ret_legal = $excedenteBase * 0.10;
        $ret_incobrables = $ingresosBrutos * 0.01;

        $excedenteNeto = $excedenteBase - ($ret_educacion + $ret_legal + $ret_incobrables);
        if($excedenteNeto < 0) $excedenteNeto = 0;

        CierreAnual::create([
            'anio' => $request->anio,
            'excedente_bruto' => $excedenteBruto,
            'reserva_legal' => $ret_legal,
            'reserva_educacion' => $ret_educacion,
            'excedente_neto' => $excedenteNeto,
            'pct_capitalizacion' => 50,
            'pct_patrocinio' => 50,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Año fiscal ' . $request->anio . ' cerrado correctamente.');
    }
}
