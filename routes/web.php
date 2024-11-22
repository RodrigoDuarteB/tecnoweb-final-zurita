<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RolController;

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
});
