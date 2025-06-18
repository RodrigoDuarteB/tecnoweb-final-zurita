<?php

namespace App\Http\Controllers;

use App\Http\Requests\BienStoreRequest;
use App\Http\Requests\BienUpdateRequest;
use App\Models\Bien;
use App\Models\TipoBien;
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
        return Inertia::render('Bien/Create', [
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BienStoreRequest $request)
    {
        Bien::create([
            ...$request->all(),
            'cliente_id' => $request->user()->cliente->id,
            'valor_referencial' => round($request->valor_referencial, 2)
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Bien creado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('bien.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bien $bien)
    {
         return Inertia::render('Bien/Create', [
            'item' => $bien,
            'esVer' => true,
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bien $bien)
    {
        return Inertia::render('Bien/Create', [
            'item' => $bien,
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BienUpdateRequest $request, Bien $bien)
    {
        $bien->update([
            ...$request->all(),
            'valor_referencial' => round($request->valor_referencial, 2)
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Bien actualizado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('bien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bien $bien)
    {
        $bien->eliminar();
        $bien->obligaciones()
        ->where('estado', 'Pendiente')
        ->update([
            'estado' => 'Cancelada'
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Bien eliminado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('bien.index');
    }
}
