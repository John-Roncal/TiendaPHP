<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return Categoria::all();
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        Categoria::create($request->all());
        return redirect('/categorias')->with('success', 'Categoría creada correctamente');
    }

    public function show($id)
    {
        return Categoria::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return redirect('/categorias')->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy($id)
    {
        Categoria::destroy($id);
        return redirect('/categorias')->with('success', 'Categoría eliminada correctamente');
    }

    public function indexBlade()
{
    $categorias = Categoria::all();
    return view('categorias.index', compact('categorias'));
}

public function create()
{
    return view('categorias.create');
}

public function edit($id)
{
    $categoria = Categoria::findOrFail($id);
    return view('categorias.edit', compact('categoria'));
}

}