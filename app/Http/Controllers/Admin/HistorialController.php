<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class HistorialController extends Controller
{
     public function index()
    {
         $perPage = Request::input('perPage')? : 5;
        
      
        return Inertia::render("Admin/Historiales/Index", [      
           
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
                                       'direccion' => $contact->direccion,
                                                                                      
                                    ];
                        }),

             'filters' => Request::only(['search', 'perPage']),
            
        ]);
        
    }

    public function show(Persona $persona)
    {
        return Inertia::render("Admin/Historiales/Show", [
            'persona' => $persona,
            'deudas' => $persona->deudas,
            'pagos' => $persona->pagos,
        ]);
    }
}
