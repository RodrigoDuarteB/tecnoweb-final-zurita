<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DescuentoController extends Controller
{
    
    public function index()
    {
        $descuentos = Descuento::with('servicioDescuentos') 
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));
        
        return Inertia::render('Descuento/Index', compact('descuentos'));
    }

    
    public function create()
    {
        $usuarios = User::all(); 
        return Inertia::render('Descuento/Create', compact('usuarios'));
    }

 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'monto' => 'nullable|numeric|min:0',
            'porcentaje' => 'nullable|numeric|min:0|max:100',
            'estado' => 'required|boolean',
            'usuario_id' => 'required|exists:usuarios,id', 
            'fecha_inicio' => 'nullable|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'activo' => 'required|boolean',
        ]);

        Descuento::create($validated);
        return redirect()->route('descuento.index')->with('success', 'Descuento creado con éxito.');
    }

   
    public function show(Descuento $descuento)
    {
        $descuento->load('servicioDescuentos'); 
        return Inertia::render('Descuento/Show', compact('descuento'));
    }

  
    public function edit(Descuento $descuento)
    {
        $usuarios = User::all(); 
        return Inertia::render('Descuento/Edit', compact('descuento', 'usuarios'));
    }

    
    public function update(Request $request, Descuento $descuento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'monto' => 'nullable|numeric|min:0',
            'porcentaje' => 'nullable|numeric|min:0|max:100',
            'estado' => 'required|boolean',
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha_inicio' => 'nullable|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'activo' => 'required|boolean',
        ]);

        $descuento->update($validated);
        return redirect()->route('descuento.index')->with('success', 'Descuento actualizado con éxito.');
    }

   
    public function destroy(Descuento $descuento)
    {
        $descuento->delete();
        return redirect()->route('descuento.index')->with('success', 'Descuento eliminado con éxito.');
    }
}
