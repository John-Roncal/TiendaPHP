@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard de Ventas</h1>

    <form method="GET" action="/dashboard">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>
            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total de Ventas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalVentas }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Importe Total</div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($importeTotal, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Ganancia Total</div>
                <div class="card-body">
                    <h5 class="card-title">${{ number_format($gananciaTotal, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top 5 Productos Más Vendidos</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topProductos as $producto)
                            <li class="list-group-item">{{ $producto->nombre }} - Vendidos: {{ $producto->total_vendido }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Productos con Stock Bajo</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($stockBajo as $producto)
                            <li class="list-group-item">{{ $producto->nombre }} - Stock: {{ $producto->stock }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pico de Días con Más Ventas</div>
                <div class="card-body">
                    <canvas id="ventasDiariasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('ventasDiariasChart').getContext('2d');
        const ventasDiariasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ventasDiarias->pluck('dia')) !!},
                datasets: [{
                    label: 'Ventas por Día',
                    data: {!! json_encode($ventasDiarias->pluck('total_ventas')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
