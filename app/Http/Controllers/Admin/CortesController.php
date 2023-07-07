<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;

use Inertia\Inertia;
use App\Models\Deuda;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class CortesController extends Controller
{
    public function index()
    {
         
        $perPage = Request::input('perPage')? : 5;
        $contar=Persona::where('corte','!=',null)->where('corte','<=',Carbon::now()->format('Y-m-d'))->where('reconection',true);

        return Inertia::render("Admin/Cortes/Index", [      
           
            'contacts' => Persona::query()->when(request()->input('search'), function ($query, $search) {
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
                                        'corte'=>$contact->corte,
                                        'reconection'=>$contact->reconection,
                                        'direccion' => $contact->direccion,
                                        
                                                                                        
                                        ];
                                    
                        }),

             'filters' => Request::only(['search', 'perPage']),
             //'lastdeudass'=>$lastdeuda,
            
        ]);
    }
    public function usePDF(){
        
        
        $contacts = Persona::where('reconection','=',1)->get();

        $pdf = PDF::loadView('libro.cortes-pdf', compact('contacts'));

        /* return $contacts3; */
        return $pdf->stream();
    }
}
