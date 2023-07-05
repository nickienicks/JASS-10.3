<?php
namespace App\Listeners;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Carbon\Carbon;
use App\Models\Deuda;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;

class SuccessfulLogin
{   
    public function __construct()
    {
    }
    public function handle(Login $event):void
    {
        /* $personas = Persona::whereDoesntHave('deudas', function ($query) {
            $query->where('type', 2)
                  ->where('monto', '>', 0);
        })->get();
        foreach ($personas as $persona) {
            
                $persona->corte = null;
                $persona->save();
           
        } */
       /*  $personas = Persona::whereDoesntHave('deudas', function ($query) {
            $query->where('type', 2)
                  ->where('monto', '>', 0);
        })->get();
        
        foreach ($personas as $persona) {
            $ultimaDeuda = Deuda::where('persona_id', $persona->id)
                ->orderBy('fecha', 'desc')
                ->first();
        
            if ($ultimaDeuda) {
                $persona->corte = $ultimaDeuda->fecha;
                $persona->save();
            }
        } */
        
         $today1=Carbon::today();
        $prueba=DB::table('personas')->where('corte','!=',null )->get();
        
        if(sizeof($prueba) > 0){

            foreach ($prueba as $prue) {
                $dui=DB::table('deudas')->where('persona_id',$prue->id)->where('type',2)->where('monto','!=',0)->get();
                $count_deu = DB::table('deudas')->where('persona_id',$prue->id)->where('type',1)->where('monto','>',0)->get();
                $c_count_deu= count($count_deu);
                $cdui=count($dui);
                if($cdui == 0 && $c_count_deu >= 3){
                    Deuda::create([
                        'fecha'=> $today1,  
                       'monto'=> 30,
                       'type'=>2,
                       'medida_ant'=> 0,
                       'medida_act'=> 0,
                       'persona_id' => $prue->id,
                       
                    ]);

                    $idd_l= $prue->id;
                    $fecha_corte=Carbon::parse( $prue->corte);
                    $fechaa1=$fecha_corte->firstOfMonth()->day(20);
                    $perso_idd= Persona::find($idd_l);

                    if($perso_idd){
                        $perso_idd->corte=$fechaa1;
                        $perso_idd->reconection=true;
                        $perso_idd->save();
                        
                    }
                }
            }
        } 
    }  
}