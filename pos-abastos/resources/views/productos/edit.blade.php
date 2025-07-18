@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Producto</h2>
    <form method="POST" action="/productos/{{ $producto->id }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Código de barras</label>
            <input name="codigo_barras" value="{{ $producto->codigo_barras }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input name="precio" type="number" step="0.01" value="{{ $producto->precio }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input name="stock" type="number" value="{{ $producto->stock }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria_id" class="form-control" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Actualizar</button>
        <a href="/productos" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection