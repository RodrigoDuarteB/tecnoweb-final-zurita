<?php

namespace App\Http\Controllers;

use App\Models\Reclamo;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class ReclamoController extends Controller
{
    /**
     * Listar todos los reclamos.
     */
    public function index()
    {
        $items = Reclamo::with('cliente')->get(); 

        return Inertia::render('Reclamo/Index', compact('items'));
    }

    /**
     *
     */
    public function create()
    {
        return Inertia::render('Reclamo/Create');
    }


    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'reclamo' => 'required|string|max:500'
        ]);

        // Obtener el cliente del usuario autenticado correctamente
        $cliente = auth()->user()->cliente;  // No necesitas paréntesis, ya que 'cliente' es una relación

        // Verificar que el cliente exista
        if (!$cliente) {
            return redirect()->route('reclamo.index')->with('error', 'No se encontró un cliente asociado al usuario.');
        }

        // Crear el reclamo y asociarlo al cliente
        Reclamo::create([
            'reclamo' => $validated['reclamo'],  // Asignar el reclamo
            'cliente_id' => $cliente->id,        // Asignar el cliente al reclamo
        ]);

        // Redirigir con éxito
        return redirect()->route('reclamo.index')->with('success', 'Reclamo creado con éxito.');
    }


    /**
     * Mostrar un reclamo específico.
     */
    public function show(Reclamo $reclamo)
    {
        $reclamo->load('cliente'); // Cargar
        $esVer = true;
        return Inertia::render('Reclamo/Create', compact('reclamo','esVer'));
    }


    public function edit(Reclamo $reclamo)
    {
        $clientes = Cliente::all();
        return Inertia::render('Reclamo/Create', compact('reclamo'));
    }

    public function update(Request $request, Reclamo $reclamo)
    {
        $validated = $request->validate([
            'reclamo' => 'required|string|max:500',
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
