@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Productos</h2>
    <a href="/productos/crear" class="btn btn-primary mb-3">Nuevo Producto</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th><th>Código</th><th>Precio</th><th>Stock</th><th>Categoría</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
                <tr>
                    <td>{{ $prod->nombre }}</td>
                    <td>{{ $prod->codigo_barras }}</td>
                    <td>S/ {{ $prod->precio }}</td>
                    <td>{{ $prod->stock }}</td>
                    <td>{{ $prod->categoria->nombre }}</td>
                    <td>
                        <a href="/productos/{{ $prod->id }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <form method="POST" action="/productos/{{ $prod->id }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection