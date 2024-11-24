<?php

namespace App\Http\Controllers;

use App\Models\Politica;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PoliticaController extends Controller
{
    
    public function index()
    {
        $politicas = Politica::orderBy('id')->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Politica/Index', compact('politicas'));
    }

 
    public function create()
    {
        return Inertia::render('Politica/Create');
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'estado' => 'required|boolean',
        ]);

        Politica::create($validated);
        return redirect()->route('politica.index')->with('success', 'Política creada con éxito.');
    }

   
    public function show(Politica $politica)
    {
        return Inertia::render('Politica/Show', compact('politica'));
    }

    
    public function edit(Politica $politica)
    {
        return Inertia::render('Politica/Edit', compact('politica'));
    }

 
    public function update(Request $request, Politica $politica)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'estado' => 'required|boolean',
        ]);

        $politica->update($validated);
        return redirect()->route('politica.index')->with('success', 'Política actualizada con éxito.');
    }

   
    public function destroy(Politica $politica)
    {
        $politica->delete();
        return redirect()->route('politica.index')->with('success', 'Política eliminada con éxito.');
    }
}
