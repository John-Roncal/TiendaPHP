<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['fecha', 'total'];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}