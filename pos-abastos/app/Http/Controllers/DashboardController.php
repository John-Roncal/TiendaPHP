<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        $query = DB::table('ventas');

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $ventas = $query->get();

        $totalVentas = $ventas->count();
        $importeTotal = $ventas->sum('total');
        $gananciaTotal = $importeTotal * 0.9;

        $topProductos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total_vendido'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        $stockBajo = DB::table('productos')
            ->where('stock', '<', 10)
            ->get();

        $ventasDiarias = DB::table('ventas')
            ->select(DB::raw('DATE(fecha) as dia'), DB::raw('COUNT(*) as total_ventas'))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return view('dashboard', compact(
            'totalVentas',
            'importeTotal',
            'gananciaTotal',
            'topProductos',
            'stockBajo',
            'ventasDiarias'
        ));
    }
}
