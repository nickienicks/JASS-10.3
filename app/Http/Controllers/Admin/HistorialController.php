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
           
            'personas' => Persona::query()->when(request()->input('search'), function ($query, $search) {
                $searchTerms = explode(' ', $search);
                $query->where(function ($subquery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $subquery->where(function ($subsubquery) use ($term) {
                            $subsubquery->where('first_name', 'like', "%{$term}%")
                                ->orWhere('last_name', 'like', "%{$term}%");
                        });
                    }
                });
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
