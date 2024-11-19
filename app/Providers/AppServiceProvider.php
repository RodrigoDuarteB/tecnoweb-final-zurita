<?php

namespace App\Providers;

use App\Models\ContadorPagina;
use Carbon\Carbon;
use Inertia\Inertia;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $ahora = Carbon::now();
        $mañana = Carbon::createFromTimeString('06:00');
        $tarde = Carbon::createFromTimeString('14:00');
        $noche = Carbon::createFromTimeString('18:30');
        $styles = [
            'background' => 'noche',
            'contornos' => 'contornos-noche',
            'titulo' => 'titulo-noche',
            'iconos' => 'iconos-noche',
            'fondo' => 'fondo-noche',
            'textos' => 'textos-noche'
        ];
        if($ahora->isBetween($mañana, $tarde)){
            $styles = [
                'background' => "mañana",
                'contornos' => 'contornos-mañana',
                'textos' => 'textos-mañana',
                'titulo' => 'titulo-mañana',
                'fondo' => 'fondo-mañana',
                'iconos' => 'iconos-mañana',
            ];
        }
        if($ahora->isBetween($tarde, $noche)) {
            $styles = [
                'background' => "tarde",
                'contornos' => 'contornos-tarde',
                'textos' => 'textos-tarde',
                'titulo' => 'titulo-tarde',
                'fondo' => 'fondo-tarde',
                'iconos' => 'iconos-tarde',
            ];
        }
        Inertia::share([
            'styles' => $styles,
            //'conteoPagina' => ContadorPagina::contar()
        ]);
    }
}
