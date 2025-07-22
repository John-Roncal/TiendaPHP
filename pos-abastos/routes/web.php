<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;

// Vista de ventas
Route::get('/', function () {
    return view('venta');
});

Route::get('/venta', function () {
    return view('venta');
});

// Ruta para el dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// Rutas para productos (rutas fijas primero)
Route::get('/productos/crear', [ProductoController::class, 'create']);
Route::get('/productos/{id}/editar', [ProductoController::class, 'edit']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::get('/productos', [ProductoController::class, 'indexBlade']);
Route::get('/productos/{id}', [ProductoController::class, 'show']); // esta debe ir al final

// Rutas para categorías (igual: fijas primero)
Route::get('/categorias/crear', [CategoriaController::class, 'create']);
Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::get('/categorias', [CategoriaController::class, 'indexBlade']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']); // esta al final también

// Registro de ventas
Route::post('/ventas/registrar', [VentaController::class, 'registrar']);