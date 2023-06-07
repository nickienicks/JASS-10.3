<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reciboingreso extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function persona(){
        return $this->belongsTo('App\Models\Persona');
    }
    public function pago(){
        return $this->belongsTo('App\Models\Pago');
    }
}
