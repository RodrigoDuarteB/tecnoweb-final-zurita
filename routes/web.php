<?php

use App\Http\Controllers\BienController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PoliticaController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TipoBienController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('configuracion', ConfiguracionController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('rol', RolController::class);
    Route::resource('servicio', ServicioController::class);
    Route::resource('reclamo', ReclamoController::class);
    Route::resource('politica', PoliticaController::class);
    Route::resource('descuento', DescuentoController::class);
    Route::resource('pago', PagoController::class);
    Route::resource('tipoBien', TipoBienController::class);
    Route::resource('bien', BienController::class);
    Route::get('pago/{pago}/confirmar', [PagoController::class, 'confirmar'])->name('pago.confirmar');
    Route::get('reportes', [ReporteController::class, 'index'])->name('reporte.index');
    Route::get('reporte/pagosPorCliente', [ReporteController::class, 'pagosCliente'])->name('reporte.pagosPorCliente');
    Route::get('reporte/pagosPorServicio', [ReporteController::class, 'pagosServicio'])->name('reporte.pagosPorServicio');
    Route::get('reporte/totalPagos', [ReporteController::class, 'total'])->name('reporte.totalPagos');
});
