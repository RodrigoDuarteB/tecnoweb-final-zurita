<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario; // Para cargar la lista de usuarios.
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteController extends Controller
{
 
    public function index()
    {
        $clientes = Cliente::with('usuario') 
            ->orderBy('id', 'desc')
            ->paginate(10); // Paginación.

        return Inertia::render('Cliente/Index', compact('clientes'));
    }


    public function create()
    {
        $usuarios = Usuario::all(); 

        return Inertia::render('Cliente/Create', compact('usuarios'));
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estado' => 'required|string|max:255',
            'carnet_identidad' => 'required|string|max:20|unique:cliente,carnet_identidad',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        Cliente::create($validated);

        return redirect()->route('cliente.index')->with('success', 'Cliente creado con éxito.');
    }

  
    public function show(Cliente $cliente)
    {
        $cliente->load('usuario'); 
        return Inertia::render('Cliente/Show', compact('cliente'));
    }

    /**
     
     */
    public function edit(Cliente $cliente)
    {
        $usuarios = Usuario::all(); 
        return Inertia::render('Cliente/Edit', compact('cliente', 'usuarios'));
    }

    /**
     * 
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'estado' => 'required|string|max:255',
            'carnet_identidad' => 'required|string|max:20|unique:cliente,carnet_identidad,' . $cliente->id,
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $cliente->update($validated);

        return redirect()->route('cliente.index')->with('success', 'Cliente actualizado con éxito.');
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('cliente.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
