<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ServicioController extends Controller
{

    public function index()
    {

        $servicios = Servicio::with('usuario')
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));

        return Inertia::render('Servicio/Index', compact('servicios'));
    }


    public function create()
    {
        return Inertia::render('Servicio/Create');
    }


    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);


        Servicio::create([
            ...$validated,
            'usuario_id' => Auth::user()->id
        ]);


        return redirect()->route('servicio.index')->with('success', 'Servicio creado con éxito.');
    }

    public function show(Servicio $servicio)
    {

        $servicio->load(['usuario', 'servicioDescuentos', 'servicioPagos']);

        return Inertia::render('Servicio/Show', compact('servicio'));
    }


    public function edit(Servicio $servicio)
    {
        $usuarios = User::all();

        return Inertia::render('Servicio/Edit', compact('servicio', 'usuarios'));
    }


    public function update(Request $request, Servicio $servicio)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'usuario_id' => 'required|exists:users,id'
        ]);


        $servicio->update($validated);

        return redirect()->route('servicio.index')->with('success', 'Servicio actualizado con éxito.');
    }


    public function destroy(Servicio $servicio)
    {

        $servicio->delete();


        return redirect()->route('servicio.index')->with('success', 'Servicio eliminado con éxito.');
    }
}
