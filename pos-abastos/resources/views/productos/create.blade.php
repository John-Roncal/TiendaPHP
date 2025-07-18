@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuevo Producto</h2>
    <form method="POST" action="/productos">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Código de barras</label>
            <input name="codigo_barras" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input name="precio" type="number" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input name="stock" type="number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria_id" class="form-control" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="/productos" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection