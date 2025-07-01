<?php

namespace App\Http\Controllers;

use App\Models\Obligacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ObligacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $es_admin = true;
        $cliente = auth()->user()->cliente;
        $items = Obligacion::with('bien.cliente.usuario', 'obligacionTipoBien');
        if($cliente) {
            $items = $items->where('cliente_id', $cliente->id);
            $es_admin = false;
        }
        $items = $items->get();
        return Inertia::render('Obligacion/Index', compact('items', 'es_admin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Obligacion $obligacion)
    {
        $obligacion->load('bien.cliente.usuario', 'obligacionTipoBien');
        return Inertia::render('Bien/Create', [
            'item' => $obligacion,
            'esVer' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obligacion $obligacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obligacion $obligacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obligacion $obligacion)
    {
        if($obligacion->estado != 'Pendiente') {
            session()->flash('jetstream.flash', [
                'banner' => 'No se puede eliminar una obligación que no este pendiente!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('obligacion.index');
        }
        $obligacion->eliminar('Cancelada');
        session()->flash('jetstream.flash', [
            'banner' => 'Obligación cancelada corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('obligacion.index');
    }
}
