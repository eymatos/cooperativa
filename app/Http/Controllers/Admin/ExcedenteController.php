<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\Cuota;
use App\Models\SavingsAccount;
use App\Models\GastoAdministrativo;
use Illuminate\Http\Request;

class ExcedenteController extends Controller
{
    // Muestra el Informe Final (Estado de Situación y Distribución)
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
            // Ingresos por mes
            $mensual_ingresos[] = Cuota::whereYear('fecha_vencimiento', $anio)
                ->whereMonth('fecha_vencimiento', $m)
                ->whereIn('estado', ['pagado', 'pagada'])
                ->sum('interes');

            // Gastos por mes
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

        // 4. DISTRIBUCIÓN POR SOCIO
        $factorRetorno = $ingresosBrutos > 0 ? ($excedenteNetoADistribuir / $ingresosBrutos) : 0;

        $socios = Socio::with('user')->where('activo', true)->get();
        $reporte = [];

        foreach ($socios as $socio) {
            $interesesSocio = Cuota::whereHas('prestamo', fn($q) => $q->where('socio_id', $socio->id))
                ->whereYear('fecha_vencimiento', $anio)
                ->whereIn('estado', ['pagado', 'pagada'])
                ->sum('interes');

            $reporte[] = [
                'nombre' => $socio->user->name,
                'cedula' => $socio->user->cedula,
                'base_intereses' => $interesesSocio,
                'monto_pat' => $interesesSocio * $factorRetorno,
            ];
        }

        return view('admin.excedentes.informe', compact(
            'reporte', 'anio', 'ingresosBrutos', 'gastosTotales',
            'ret_educacion', 'ret_legal', 'ret_incobrables',
            'excedenteNetoADistribuir', 'mensual_ingresos', 'mensual_gastos'
        ));
    }

    // Métodos para gestionar Gastos
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
    // Validamos que no exista ya un cierre para ese año
    $request->validate(['anio' => 'required|integer']);

    if (\App\Models\CierreAnual::where('anio', $request->anio)->exists()) {
        return back()->with('error', 'El año ' . $request->anio . ' ya ha sido cerrado oficialmente.');
    }

    // Calculamos los datos finales (usando la misma lógica del informe)
    $ingresosBrutos = Cuota::whereYear('fecha_vencimiento', $request->anio)
        ->whereIn('estado', ['pagado', 'pagada'])
        ->sum('interes');

    $gastosTotales = GastoAdministrativo::whereYear('fecha', $request->anio)->sum('monto');
    $excedentePrevio = ($ingresosBrutos - $gastosTotales) > 0 ? ($ingresosBrutos - $gastosTotales) : 0;

    $ret_educacion = $excedenteBase * 0.05;
    $ret_legal = $excedenteBase * 0.10;
    $excedenteNeto = $excedenteBase - ($ret_educacion + $ret_legal + ($ingresosBrutos * 0.01));

    // Guardamos el cierre oficial
    \App\Models\CierreAnual::create([
        'anio' => $request->anio,
        'excedente_bruto' => $ingresosBrutos - $gastosTotales,
        'reserva_legal' => $ret_legal,
        'reserva_educacion' => $ret_educacion,
        'excedente_neto' => $excedenteNeto,
        'pct_capitalizacion' => 0, // No lo estamos usando por ahora
        'pct_patrocinio' => $ingresosBrutos > 0 ? ($excedenteNeto / $ingresosBrutos * 100) : 0,
        'user_id' => auth()->id(),
    ]);

    return back()->with('success', 'Año fiscal ' . $request->anio . ' cerrado correctamente.');
}
}
