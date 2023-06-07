<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IngresosController extends Controller
{
    public function index()
    {
        $perPage = Request::input('perPage')? : 5;
        DB::statement("SET lc_time_names = 'es_ES'");
        $suma = Pago::select(
            DB::raw('sum(monto) as sums'), 
            DB::raw("DATE_FORMAT(fecha,'%M %Y') as months")
         )
          ->groupBy('months')
          ->get();
      

        return Inertia::render("Admin/Ingresos/Index", [
             'pagos' => Pago::query()->when(Request::input('search'), function ($query, $search)
                                {
                                    $query->where('fecha', 'like', "%{$search}%");
                                    
                                })
                                ->latest('id')
                                ->paginate($perPage)
                                ->withQueryString()
                                ->through(function($pago){
                                    return [
                                       'id' => $pago->id,
                                       'fecha' => $pago->fecha,
                                       'monto' => $pago->monto,                      
                                    //    'suma' => $pago->
                                    ];
                        }),

            'sumatorias' => $suma,
            'filters' => Request::only(['search', 'perPage']),
        ]);
    }
}
