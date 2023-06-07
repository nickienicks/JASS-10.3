<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deuda;
use App\Models\Persona;
use App\Models\Reciboingreso;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;
use Illuminate\Support\Collection;

class ReciboingresosController extends Controller
{
    public  function store(Persona $persona)
    {
        $suma3 = $persona->deudas->sum('monto');
        /* $deudass= Persona::where('id',$persona->id)->deudas->where('monto','!=','0'); */
        $deudass = DB::table('deudas')->where('persona_id', $persona->id)->where('monto','>',0)->orderBy('fecha')->get();
        /* $deudass= $persona->deudas;
        $deudass= $deudass->where('monto',true)->toArray(); */
       
        /* $arrus = json_decode($deudass[0]); */
        /* $deudass=(object)$deudass; */

        Request::validate([
            'fecha' => 'required',
            'monto' => "required|integer|max:$suma3",
           
         ]);

        $vari=Request::input('monto');
        $i=0;
        while($vari > 0){
            
                if($vari >= $deudass[$i]->monto){
                    Deuda::where('id',$deudass[$i]->id)->update([
                        'monto' => 0,    
                    ]);
                    $vari=$vari-$deudass[$i]->monto;
                    $i++;
                }elseif($vari < $deudass[$i]->monto){
                    $restau=($deudass[$i]->monto) - $vari;
                    Deuda::where('id',$deudass[$i]->id)->update([
                        'monto' => $restau,    
                    ]);
                    $vari=0;
                    $i++;
                }
            
        }
        

        Pago::create([
            'fecha'=> Request::input('fecha'),  
            'monto'=> Request::input('monto'),
           
            'persona_id' => $persona->id,
            'deuda_id' =>$deudass[0]->id,
         ]);

         $paug=Pago::latest('id')->first();

        Reciboingreso::create([
            'fecha'=> Request::input('fecha'),  
            'monto'=> Request::input('monto'),

            'persona_id' => $persona->id,
            'pago_id' =>$paug->id,
        ]);
        
        //return $deudass.$deudass[0]->id . $paug->id;

        return Redirect::route('admin.pagos.view',$persona)->with('flash.banner', 'Boleta Guardada && Pago Realizado');
    }
}
