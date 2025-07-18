@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Categorías</h2>
    <a href="/categorias/crear" class="btn btn-primary mb-3">Nueva Categoría</a>

    <table class="table table-bordered">
        <thead>
            <tr><th>Nombre</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($categorias as $cat)
                <tr>
                    <td>{{ $cat->nombre }}</td>
                    <td>
                        <a href="/categorias/{{ $cat->id }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <form method="POST" action="/categorias/{{ $cat->id }}" class="d-inline">
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