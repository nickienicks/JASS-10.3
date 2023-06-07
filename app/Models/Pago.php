<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{

    protected $guarded = ['id'];
    use HasFactory;

    public function reciboingresos(){
        return $this->hasMany('App\Models\Reciboingreso');
    }

    public function persona(){
        return $this->belongsTo('App\Models\Persona');
    }

    public function deuda(){
        return $this->belongsTo('App\Models\Deuda');
    }

    protected static function booted(){
        static::created(function($pago){

            $idper=$pago->persona_id;
            $persona1= Persona::where('id',$idper);
            /* $persona1->update(['corte'=>true,]); 

            $ults = Deuda::all()->where('persona_id',$idper)->where('monto',true);
            $counts=count($ults); */
          //  if($counts < 3 ){
                $persona1->update(['corte'=>'2001-01-01',]); 
           // }

        });
    }
    
}
