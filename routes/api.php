<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ServicioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('servicio/buscar', [ServicioController::class, 'buscar'])->name('servicio.buscar');
Route::get('reporte/pagosPorCliente', [ReporteController::class, 'pagosPorCliente']);
Route::get('reporte/pagosPorServicio', [ReporteController::class, 'pagosPorServicio']);
Route::get('reporte/totalPagosYDescuentos', [ReporteController::class, 'totalPagosYDescuentos']);
Route::get('menu/buscar', [MenuController::class, 'buscar'])->name('menu.buscar');
