<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
     protected $guarded = ['id'];
    use HasFactory;
    
    public function deudas(){
        return $this->hasMany('App\Models\Deuda');
    }


    public function pagos(){
        return $this->hasMany('App\Models\Pago');
    }
    public function recibos(){
        return $this->hasMany('App\Models\Reciboingreso');
    }
}
