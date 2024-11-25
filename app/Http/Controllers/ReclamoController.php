<?php

namespace App\Http\Controllers;

use App\Models\Reclamo;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReclamoController extends Controller
{
    /**
     * Listar todos los reclamos.
     */
    public function index()
    {
        $reclamos = Reclamo::with('cliente')->orderBy('id')->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Reclamo/Index', compact('reclamos'));
    }

    /**
     *
     */
    public function create()
    {
        return Inertia::render('Reclamo/Create');
    }

    /**
     * Guardar un nuevo reclamo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reclamo' => 'required|string|max:500'
        ]);

        Reclamo::create([
            ...$validated,
            'cliente_id' => auth()->user()->cliente()->id, // Asignar el cliente al reclamo.
        ]);
        return redirect()->route('reclamo.index')->with('success', 'Reclamo creado con éxito.');
    }

    /**
     * Mostrar un reclamo específico.
     */
    public function show(Reclamo $reclamo)
    {
        $reclamo->load('cliente'); // Cargar
        return Inertia::render('Reclamo/Show', compact('reclamo'));
    }


    public function edit(Reclamo $reclamo)
    {
        $clientes = Cliente::all();
        return Inertia::render('Reclamo/Edit', compact('reclamo', 'clientes'));
    }

    public function update(Request $request, Reclamo $reclamo)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:500',
            'estado' => 'required|in:pendiente,resuelto',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $reclamo->update($validated);
        return redirect()->route('reclamo.index')->with('success', 'Reclamo actualizado con éxito.');
    }


    public function destroy(Reclamo $reclamo)
    {
        $reclamo->delete();
        return redirect()->route('reclamo.index')->with('success', 'Reclamo eliminado con éxito.');
    }
}
