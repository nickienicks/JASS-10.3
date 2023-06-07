<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deuda;
use App\Models\Pago;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\PDF;

class PagosController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage')? : 5;
        return Inertia::render("Admin/Pagos/Index", [
             'personas' => Persona::query()->when(Request::input('search'), function ($query, $search)
                                {
                                    $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%") ;
                                })
                                ->latest('id')
                                ->paginate($perPage)
                                ->withQueryString()
                                ->through(function($contact){
                                    return [
                                       'id' => $contact->id,
                                       'first_name' => $contact->first_name,
                                       'last_name' => $contact->last_name,
                                       'dni' => $contact->dni,                       
                                    ];
                        }),

             'filters' => Request::only(['search', 'perPage']),
        ]);
    }

    public function create(Persona $persona, Deuda $deuda)
    {
        $now = Carbon::now()->format('Y-m-d');
        return Redirect::route("admin.pagos.update",[$persona, $deuda]);
        /* return Inertia::render("Admin/Pagos/Create", [
            'persona' => $persona,      
            'deuda' => $deuda,
            'now' => $now,
        ]); */
    }

      public function store(Persona $persona, Deuda $deuda)
    {
        $now = Carbon::now()->format('Y-m-d');
          Request::validate([
           'fecha' => 'required',
           'monto' => "required",
          
        ]);

          Pago::create([
           'fecha'=> $now,  
           'monto'=> $deuda->monto,
          
           'persona_id' =>$deuda->persona_id,
           'deuda_id' => $deuda->deuda_id,
        //    'user_id' => auth()->id(),
           
        ]);

        return Redirect::route("admin.pagos.edit", [$persona, $deuda])->with('flash.banner', 'Confirma el pago porfavor');
        // return Redirect::back()->with('flash.banner', 'Confirma el pago porfavor');

    }

        public function edit(Persona $persona, Deuda $deuda)
    {
        $pago=0;
        /* $pago = Pago::latest('id')->first(); */
        return Inertia::render('Admin/Pagos/Edit', [
              'persona' => $persona,
              'deuda' => $deuda,
              'pago' => $pago,
        ]);
    }


     public function update(Persona $persona, Deuda $deuda)
    {
        $now = Carbon::now()->format('Y-m-d');
        $es= $deuda->monto;
        $deuda->update([
          
            'fecha'=> $now,  
            'monto'=> 0,
           'medida_ant'=> $deuda->medida_ant,
           'medida_act'=> $deuda->medida_act,
           'persona_id' => $persona->id,
           'user_id' => auth()->id(),
         ]);
        Pago::create([
            'fecha'=> $now,  
            'monto'=> $es,
           
            'persona_id' =>$deuda->persona_id,
            'deuda_id' => $deuda->id,
         //    'user_id' => auth()->id(),
            
         ]);

      

    
          return Redirect::route("admin.pagos.view",[$persona->id])->with('flash.banner', 'Pago Realizado');
    }


    public function pagoedit(Persona $persona, Deuda $deuda)
    {
        $pago = Pago::latest('id')->first();
          return Inertia::render("Admin/Pagos/PagoEdit", [
            'persona' => $persona,
            'deuda' => $deuda,
            'pago' => $pago,
        ]);
    }

    public function pagoupdate(Persona $persona, Deuda $deuda)
    {
       $pago = Pago::latest('id')->first(); 
       $pago->update([
           'fecha'=> Request::input('fecha'),  
           'monto'=> Request::input('monto'),
           'persona_id'=> Request::input('persona_id'),
           'deuda_id'=> Request::input('deuda_id'),
         ]);

         return Redirect::route("admin.pagos.edit", [$persona, $deuda])->with('flash.banner', 'Actualizado!!...Confirma el pago porfavor');
    }


    public function view(Persona $persona)
    {
        $deudass= Deuda::where('persona_id',$persona->id)->orderBy('fecha')->get();
        // $suma = Deuda::sum(intval('monto'    ))->groupBy('fecha')->get();
        $suma = $persona->deudas->sum('monto');
        return Inertia::render("Admin/Pagos/View", [
            'persona' => $persona,
            'deudas' => $deudass,
            'suma' => $suma,
        ]);
    }
    public function usePDF(Persona $persona){
        
        $now = Carbon::now()->format('Y-M-d');
        $deuda = Deuda::latest('id')->first();
        $contacts= Persona::where('id',$persona->id)->with(['deudas' => function($query) {
            $query->where('monto','>','0')->orderBy('fecha');
        }])->get();
     
        $final = Persona::where('id',$persona->id)->with('deudas')->get();
        $pdf = PDF::loadView('libro.pdf', compact('contacts', 'deuda', 'final','now'));
        return $pdf->stream();
    }


  
}
