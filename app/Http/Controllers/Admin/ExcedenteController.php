<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\Cuota;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\GastoAdministrativo;
use App\Models\CierreAnual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExcedenteController extends Controller
{
    /**
     * Genera el informe de excedentes basado en la actividad anual.
     * Toma en cuenta el balance histórico (Saldo inicial + depósitos del año)
     * de solo Ahorros Normales (ID 1).
     */
    public function informe(Request $request)
    {
        $anio = $request->anio ?? date('Y');

        $inicioAnio = $anio . '-01-01';
        $finAnio = $anio . '-12-31';

        // 1. INGRESOS Y GASTOS TOTALES
        $ingresosBrutos = Cuota::whereDate('fecha_vencimiento', '>=', $inicioAnio)
            ->whereDate('fecha_vencimiento', '<=', $finAnio)
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

        // --- LÓGICA DE PERMANENCIA (BALANCE HISTÓRICO REAL) ---
        // Obtenemos socios que tengan o hayan tenido cuenta Normal (saving_type_id = 1)
        $socios = Socio::with('user')
            ->whereHas('cuentas', function ($q) {
                $q->where('saving_type_id', 1);
            })
            ->get();

        $reporte = [];
        $totalAhorrosGeneralCalculado = 0;

        foreach ($socios as $socio) {
            // PASO A: Calcular el balance que traía el socio ANTES del inicio del año fiscal
            $balanceAnterior = SavingsTransaction::whereHas('account', function($q) use ($socio) {
                    $q->where('socio_id', $socio->id)->where('saving_type_id', 1);
                })
                ->whereDate('date', '<', $inicioAnio)
                ->selectRaw("SUM(CASE WHEN type IN ('deposit', 'interest', 'deposito') THEN amount ELSE -amount END) as total")
                ->value('total') ?? 0;

            // PASO B: Calcular las ENTRADAS (depósitos) realizadas DENTRO del año fiscal
            $entradasAnio = SavingsTransaction::whereHas('account', function($q) use ($socio) {
                    $q->where('socio_id', $socio->id)->where('saving_type_id', 1);
                })
                ->whereYear('date', $anio)
                ->whereIn('type', ['deposit', 'interest', 'deposito'])
                ->sum('amount');

            // La base de excedente es el Balance Anterior + Entradas del Año
            // (Ignoramos los retiros/salidas para que si se retiró al final, su base sea la máxima ahorrada)
            $ahorroBaseCalculado = max($balanceAnterior + $entradasAnio, 0);

            $socio->ahorro_historico_base = $ahorroBaseCalculado;
            $totalAhorrosGeneralCalculado += $ahorroBaseCalculado;
        }

        $factorCapitalizacion = $totalAhorrosGeneralCalculado > 0 ? ($fondoCapitalizacion / $totalAhorrosGeneralCalculado) : 0;

        // 5. GENERAR REPORTE FINAL
        foreach ($socios as $socio) {
            $interesesSocio = Cuota::whereHas('prestamo', fn($q) => $q->where('socio_id', $socio->id))
                ->whereDate('fecha_vencimiento', '>=', $inicioAnio)
                ->whereDate('fecha_vencimiento', '<=', $finAnio)
                ->whereIn('estado', ['pagado', 'pagada'])
                ->sum('interes');

            $ahorroBaseSocio = (float) $socio->ahorro_historico_base;

            $monto_pat = $interesesSocio * $factorPatrocinio;
            $monto_cap = $ahorroBaseSocio * $factorCapitalizacion;

            if ($interesesSocio > 0 || $ahorroBaseSocio > 0) {
                $reporte[] = [
                    'nombre' => $socio->user->name ?? ($socio->nombres . ' ' . $socio->apellidos),
                    'cedula' => $socio->user->cedula ?? 'N/A',
                    'base_intereses' => $interesesSocio,
                    'base_ahorros' => $ahorroBaseSocio,
                    'monto_pat' => $monto_pat,
                    'monto_cap' => $monto_cap,
                    'total_socio' => $monto_pat + $monto_cap
                ];
            }
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

        $inicioAnio = $request->anio . '-01-01';
        $finAnio = $request->anio . '-12-31';

        $ingresosBrutos = Cuota::whereDate('fecha_vencimiento', '>=', $inicioAnio)
            ->whereDate('fecha_vencimiento', '<=', $finAnio)
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
