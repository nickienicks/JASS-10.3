<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Deuda extends Model
{

    protected $guarded = ['id'];
    use HasFactory;
    
    public function persona(){
        return $this->belongsTo('App\Models\Persona');
    }

    public function pagos(){
        return $this->hasMany('App\Models\Pago');
    }
    protected static function booted(){
        static::created(function($deuda){
            
            if($deuda->type == false){

            $idper= $deuda->persona_id;
            $persona1= Persona::where('id',$idper);
            /* $persona1->update(['corte'=>true,]);  */

            $ults = Deuda::all()->where('persona_id',$idper)->where('monto',true)->where('type',false);
            $counts=count($ults);
            if($counts >= 1 ){
               $newformat=Carbon::parse($deuda->fecha);
               $newformat2=$newformat->addWeeks(2);
               $newformat3=$newformat2->modify('last day of this month');
               
                /* $newdate=$deuda->fecha;
                $clones= new DateTime($newdate);
                $newdate->addWeeks(1); */

               // $days= date('d-m-Y', $deuda->fecha->addWeek());
                $persona1->update(['corte'=>$newformat2]); 
            }
        }

        });
    }
}
