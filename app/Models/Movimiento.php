<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $fillable = ['usuario_id', 'tipo', 'libro', 'fecha'];
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
