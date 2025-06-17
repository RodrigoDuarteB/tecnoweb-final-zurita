<?php

namespace App\Http\Controllers;

use App\Http\Requests\BienStoreRequest;
use App\Http\Requests\BienUpdateRequest;
use App\Models\Bien;
use Inertia\Inertia;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cliente = auth()->user()->cliente;
        $items = Bien::activos()
        ->with('cliente', 'tipoBien');
        if($cliente) {
            $items = $items->where('cliente_id', $cliente->id);
        }
        $items = $items->get();
        return Inertia::render('Bien/Index', compact('items'));
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
    public function store(BienStoreRequest $request)
    {
        $bien = Bien::create([
            'cliente_id' => $request->user()->cliente->id,
            'tipo_bien_id' => $request->tipo_bien_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor_referencial' => $request->valor_referencial,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bien $bien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bien $bien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BienUpdateRequest $request, Bien $bien)
    {
        $bien->update([
            'tipo_bien_id' => $request->tipo_bien_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor_referencial' => $request->valor_referencial,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bien $bien)
    {
        $bien->update([
            'estado' => 'Inactivo',
        ]);
    }
}
