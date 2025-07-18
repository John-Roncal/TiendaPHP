<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return Producto::with('categoria')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo_barras' => 'required|string|unique:productos',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        return Producto::create($request->all());
    }

    public function show($id)
    {
        return Producto::with('categoria')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return $producto;
    }

    public function destroy($id)
    {
        return Producto::destroy($id);
    }

    public function indexBlade()
{
    $productos = Producto::with('categoria')->get();
    return view('productos.index', compact('productos'));
}

public function create()
{
    $categorias = Categoria::all();
    return view('productos.create', compact('categorias'));
}

public function edit($id)
{
    $producto = Producto::findOrFail($id);
    $categorias = Categoria::all();
    return view('productos.edit', compact('producto', 'categorias'));
}
}