<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deuda;
use App\Models\Persona;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeudasController extends Controller
{
    public function index()
    {
         $perPage = Request::input('perPage')? : 5;

        return Inertia::render("Admin/Deudas/Index", [
              'contacts' => Persona::query()->when(Request::input('search'), function ($query, $search)
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


    public function create(Persona $persona)
    {
        
        $final = $persona->deudas->last();
        
        
        return Inertia::render("Admin/Deudas/Create", [
            'persona' => $persona,
            'deudas' => $persona->deuda,
            'final' => $final ,
        ]);
    }

      public function store(Persona $persona)
    {       
        
       /*  $persona=Persona::where('id',$deuda->persona_id)->get(); */

          Request::validate([
           'fecha' => 'required',
           'monto' => "required",
           'medida_ant' => "required",
           'medida_act' => "required",
        ]);

        

            Deuda::create([
           'fecha'=> Request::input('fecha'),  
           'monto'=> Request::input('monto'),
           'type'=>false,
           'medida_ant'=> Request::input('medida_ant'),
           'medida_act'=> Request::input('medida_act'),
           'persona_id' => Request::input('persona_id'),
        //    'user_id' => auth()->id(),
           
        ]);

        return Redirect::route("admin.deudas.create", $persona->id)->with('flash.banner', 'Deuda Asignada');

    }public function edit(Persona $persona, Deuda $deuda)
    {
          $final = $persona->deudas->last();
          return Inertia::render("Admin/Deudas/Edit", [
            'persona' => $persona,
            'deuda' => $deuda,
           'final' => $final ,
        ]);
    }

       public function update(Persona $persona, Deuda $deuda)
    {
         Request::validate([
                'fecha' => "required",
                'monto' => "required",  
                'medida_act' => "required",
                'medida_ant' => "required",
        ]);


      $deuda->update([
            'fecha' => Request::input('fecha'),
            'monto' => Request::input('monto'),    
            'medida_ant' => Request::input('medida_ant'), 
            'medida_act' => Request::input('medida_act'),
            'persona_id' => Request::input('persona_id'),
         ]);
 

           return Redirect::route('admin.deudas.view', $persona)->with('flash.banner', 'Exito!! Deuda Actualizada');
    }




    public function view(Persona $persona)
    {
        $deudass= Deuda::where('persona_id',$persona->id)->where('monto','>','0')->orderBy('fecha')->get();
       
        return Inertia::render("Admin/Deudas/View", [
            'persona' => $persona,
            'deudas' => $deudass,
            'pagos' => $persona->pagos,
            
        ]);
    }


    public function usePDF(){
        
        $now = Carbon::now()->format('Y-M-d');
        $deuda = Deuda::latest('id')->first();
       /*  $contacts = Persona::with('deudas')->get(); */
        $contacts = Persona::whereHas('deudas', function($query) {
            $query->where('monto','>','0')->orderBy('fecha');
        })->get();

        $pdf = PDF::loadView('libro.pdf', compact('contacts', 'deuda','now'));

        /* return $contacts3; */
        return $pdf->stream();
        
    }
}
