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

       // $datetoday=Carbon::now();

        $contar=Persona::where('corte','<=',Carbon::now()->format('Y-m-d'))->where('corte','>','2005-01-01');
       // $contar2=$contar->where('corte',);
        /* ->whereHas('deudas', function ($query) {
            $query->latest('id')->first();
        })->get();

        $lastdeuda= $contar; */
        /* $todou=Dudas::last
        $todou=Persona::with('deudas')->last('deudas','fechas')->get();
        $lastd=$todou;
        $lastdeuda=$lastd; */

        return Inertia::render("Admin/Cortes/Index", [      
           
            'contacts' => $contar->when(Request::input('search'), function ($query, $search)
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
                                        'corte'=>$contact->corte,
                                        'reconection'=>$contact->reconection,
                                        'direccion' => $contact->direccion,
                                        
                                                                                        
                                        ];
                                    
                        }),

             'filters' => Request::only(['search', 'perPage']),
             //'lastdeudass'=>$lastdeuda,
            
        ]);
    }
    /* public function usePDF(){

        $now = Carbon::now()->format('Y-M-d');
        $pdf = PDF::loadView('libro.pdf', compact('data'));
        return $pdf->stream();
    } */
}
