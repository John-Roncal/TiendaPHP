@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Categoría</h2>
    <form method="POST" action="/categorias/{{ $categoria->id }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input name="nombre" class="form-control" value="{{ $categoria->nombre }}" required>
        </div>
        <button class="btn btn-success">Actualizar</button>
        <a href="/categorias" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
