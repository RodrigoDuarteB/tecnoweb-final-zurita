<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoBienStoreRequest;
use App\Http\Requests\TipoBienUpdateRequest;
use App\Models\TipoBien;
use Inertia\Inertia;

class TipoBienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = TipoBien::activos()
        ->with('usuarioCreador')
        ->get();
        return Inertia::render('TipoBien/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoBien/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoBienStoreRequest $request)
    {
        TipoBien::create([
            ...$request->all(),
            'user_id' => auth()->user()->id
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Tipo Bien creado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('tipoBien.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoBien $tipoBien)
    {
        return Inertia::render('TipoBien/Create', [
            'item' => $tipoBien,
            'esVer' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoBien $tipoBien)
    {
        return Inertia::render('TipoBien/Create', [
            'item' => $tipoBien,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoBienUpdateRequest $request, TipoBien $tipoBien)
    {
        $tipoBien->update($request->all());
        session()->flash('jetstream.flash', [
            'banner' => 'Tipo Bien editado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('tipoBien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoBien $tipoBien)
    {
        $tipoBien->eliminar();
        session()->flash('jetstream.flash', [
            'banner' => 'Tipo Bien eliminado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('tipoBien.index');
    }
}
