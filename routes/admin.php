<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DeudasController;
use App\Http\Controllers\Admin\HistorialController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IngresosController;
use App\Http\Controllers\Admin\PagosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CortesController;
use App\Http\Controllers\Admin\ReciboingresosController;
use App\Http\Controllers\Admin\ImprimirController;
use App\Models\Reciboingreso;

Route::get("", [HomeController::class, "index"])->name("home");
//Usuarios
Route::resource('usuarios', ContactController::class, ['except' => [
    'edit', 'update', 'destroy', 'show'
]])->names('contacts');
Route::get('usuarios/{persona:id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('usuarios/{persona:id}', [ContactController::class, 'update'])->name('contacts.update');
Route::get('usuarios/show', [ContactController::class, 'show'])->name('contacts.show');
Route::post("usuarios/{persona:id}/storedeudas", [ContactController::class, "storedeudas"])->name("contacts.storedeudas");
Route::post("usuarios/{persona:id}/validateForm", [ContactController::class, "validateForm"])->name("contacts.validateForm");
Route::delete('usuarios/{persona:id}/destroy', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::get("usuarios/{persona:id}/pdf", [ContactController::class, "usePDF"])->name("contacts.pdf");
//Deudas
Route::get("deudas", [DeudasController::class, "index"])->name("deudas.index");
Route::get("deudas/{persona:id}/view", [DeudasController::class, "view"])->name("deudas.view");
Route::get("deudas/{persona:id}/create", [DeudasController::class, "create"])->name("deudas.create");
Route::get('deudas/{persona:id}/edit/{deuda:id}', [DeudasController::class, 'edit'])->name('deudas.edit');
Route::put('deudas/{persona:id}/update/{deuda:id}', [DeudasController::class, 'update'])->name('deudas.update');
Route::post("deudas/{persona:id}/store", [DeudasController::class, "store"])->name("deudas.store");
Route::get("deudas/pdf", [DeudasController::class, "usePDF"])->name("deudas.pdf");

//Pagos
Route::get("pagos", [PagosController::class, "index"])->name("pagos.index");
Route::get("pagos/{persona:id}/create/{deuda:id}", [PagosController::class, "create"])->name("pagos.create");
Route::post("pagos/{persona:id}/store/{deuda:id}", [PagosController::class, "store"])->name("pagos.store");

Route::get('pagos/{persona:id}/edit/{deuda:id}/edit', [PagosController::class, 'edit'])->name('pagos.edit');
Route::get("pagos/{persona:id}/pdf", [PagosController::class, "usePDF"])->name("pagos.pdf");

Route::get('pagos/{persona:id}/edit/{deuda:id}/pagoedit', [PagosController::class, 'pagoedit'])->name('pagos.pagoedit');
Route::put("pagos/{persona:id}/update/{deuda:id}/pagoedit", [PagosController::class, 'pagoupdate'])->name('pagos.pagoupdate');
Route::put("pagos/{persona:id}/update/{deuda:id}", [PagosController::class, 'update'])->name('pagos.update');
Route::get("pagos/{persona:id}/view", [PagosController::class, "view"])->name("pagos.view");
//facturas
Route::get("imprimir", [ImprimirController::class, "index"])->name("imprimir.index");
Route::get('imprimir/{zonas}/pdf', [ImprimirController::class, "pdf"])->name('imprimir.pdf');

//recibos

Route::post("pagorecibo/{persona:id}/store/{reciboingreso:monto}", [ReciboingresosController::class, "store"])->name("recibo.store");

//cortes
Route::get("cortes", [CortesController::class, "index"])->name("cortes.index");
Route::get("cortes/{data}/pdf",[CortesController::class, "usePDF"])->name("cortes.pdf");
//Historial
Route::get("historiales", [HistorialController::class, "index"])->name("historiales.index");
Route::get('historiales/{persona:id}/show', [HistorialController::class, 'show'])->name('historiales.show');

//Ingresos
Route::get("ingresos", [IngresosController::class, "index"])->name("ingresos.index");