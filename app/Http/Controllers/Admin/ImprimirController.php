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

class ImprimirController extends Controller
{
    public function index(){

        return Inertia::render("Admin/Imprimir/Index", [
           
            
        ]);
    }
    public function pdf($zonas){
        $now = Carbon::now()->format('Y-M-d');
        $deuda = Deuda::latest('id')->first();
     
       /*  $contacts = Persona::with('deudas')->get(); */
        $contacts= Persona::where('zona',$zonas)->with(['deudas' => function($query) {
            $query->where('monto','>','0')    
            ->orderBy('fecha');
        }])->get();
        $pdf = PDF::loadView('libro.pdf', compact('contacts', 'deuda','now'));

        /* return $contacts3; */
        return $pdf->stream();

    }
    
}
