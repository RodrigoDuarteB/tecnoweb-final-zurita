<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoBienStoreRequest;
use App\Http\Requests\TipoBienUpdateRequest;
use App\Models\TipoBien;
use Illuminate\Http\Request;

class TipoBienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(TipoBienStoreRequest $request)
    {
        $tipoBien = TipoBien::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoBien $tipoBien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoBien $tipoBien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoBienUpdateRequest $request, TipoBien $tipoBien)
    {
        $tipoBien->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoBien $tipoBien)
    {
        //
    }
}
