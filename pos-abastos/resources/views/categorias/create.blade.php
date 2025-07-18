@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Categoría</h2>
    <form method="POST" action="/categorias">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input name="nombre" class="form-control" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="/categorias" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection