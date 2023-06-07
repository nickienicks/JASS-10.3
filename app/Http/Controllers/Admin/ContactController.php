<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Deuda;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\PDF;

class ContactController extends Controller
{

     public function index()
    {
        $all1= Persona::get()->count();
         $perPage = Request::input('perPage')? : 5;
        
        
        return Inertia::render("Admin/Users/Index", [      
           
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
                                       'direccion' => $contact->direccion,
                                                                                      
                                    ];
                        }),

             'filters' => Request::only(['search', 'perPage']),
             'todos'=>$all1,
            
        ]);
        
    }

    
     public function create()
    {
        $persona = Persona::all();
        return Inertia::render('Admin/Users/Create', [
            'persona' => $persona,
        ]);
    }

    public function validateForm(){
        Request::validate([
            'firstname' => "required",
            'lastname' => "required",   
            'dni' => "required|numeric|digits:8",
            'direction' => "required",
            'zona' => "required",
        ]);

    }
        public function store()
    {
         Request::validate([
            'firstname' => "required",
            'lastname' => "required",   
            'dni' => "required|numeric|digits:8",
            'direction' => "required",
            'zona' => "required",
        ]);

       Persona::create([
            'first_name' => Request::input('firstname'),
            'last_name' => Request::input('lastname'),
            'dni' => Request::input('dni'),
            'corte'=>'2001-01-01',
            'reconection'=>false,
            'direccion' => Request::input('direction'),
            'zona' => Request::input('zona'),
            'user_id' => auth()->id(),
        ]);
  
        // return Redirect::route("admin.contact.index")->with('flash.banner', 'Exito!! Usuario Creado');
        return Redirect::route("admin.contacts.show")->with('flash.banner', 'Exito!! Usuario Creado');
    }

      public function edit(Persona $persona)
    {
        return Inertia::render('Admin/Users/Edit', [
              'persona' => $persona,
        ]);
    }
    

    public function update(Persona $persona)
    {
         Request::validate([
                'firstname' => "required",
                'lastname' => "required",  
                'dni' => "required",
                'direccion' => "required",
                'medidor_id' => "required"
               
        ]);


      $persona->update([
            'first_name' => Request::input('firstname'),
            'last_name' => Request::input('lastname'),
            
            'dni' => Request::input('dni'),
            'direccion' => Request::input('direccion'),
            'medidor_id' => Request::input('medidor_id'),
            'user_id' => auth()->id(),
         
         ]);
 

           return Redirect::route('admin.contacts.index')->with('flash.banner', 'Exito!! Usuario Actualizado');
    }


       public function destroy(Persona $persona)
    {
        $persona->delete();

         return Redirect::route('admin.contacts.index')->with('flash.banner', 'Usuario Eliminado.')->with('flash.bannerStyle', 'danger');
    }

    public function storedeudas()
    {
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
        return Redirect::route("admin.contacts.show")->with('flash.banner', 'Deuda Asignada');
    }
    

    public function show()
    {

        $persona = Persona::latest('id')->first();
        $deudass= DB::table('deudas')->where('persona_id',$persona->id)->latest('id')->first();
        return Inertia::render('Admin/Users/UserDeuda', [
            'persona' => $persona,
            'deudass'=>$deudass,
        ]);
    }
    public function usePDF(Persona $persona){

        $now = Carbon::now()->format('Y-M-d');
        $deuda = Deuda::latest('id')->first();

        $contacts = Persona::whereHas('deudas', function($query) {
            $query->where('monto','>','0')->orderBy('fecha');
        })->get();
           
        $final = Persona::where('id',$persona->id)->with('deudas')->get();
        $pdf = PDF::loadView('libro.pdf', compact('contacts', 'deuda', 'final','now'));
        return $pdf->stream();
    }
}
