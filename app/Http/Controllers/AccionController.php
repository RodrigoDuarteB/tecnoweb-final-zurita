<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccionController extends Controller
{
    /**
     * Listar todas las acciones.
     */
    public function index()
    {
        $acciones = Accion::with('menu')->orderBy('id')->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Accion/Index', compact('acciones'));
    }

    /**
     * Mostrar el formulario para crear una nueva acción.
     */
    public function create()
    {
        $menus = Menu::all(); // Para seleccionar un menú asociado.
        return Inertia::render('Accion/Create', compact('menus'));
    }

    /**
     * Guardar una nueva acción.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'es_menu' => 'required|boolean',
            'url' => 'nullable|string|max:500',
            'estado' => 'required|boolean',
            'menu_id' => 'required|exists:menu,id',
        ]);

        Accion::create($validated);
        return redirect()->route('accion.index')->with('success', 'Acción creada con éxito.');
    }

    /**
     * Mostrar 
     */
    public function show(Accion $accion)
    {
        $accion->load('menu'); // Cargar relación con el menú.
        return Inertia::render('Accion/Show', compact('accion'));
    }

    /**
     * Mostrar 
     */
    public function edit(Accion $accion)
    {
        $menus = Menu::all();
        return Inertia::render('Accion/Edit', compact('accion', 'menus'));
    }

    /**
     * Actualizar 
     */
    public function update(Request $request, Accion $accion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'es_menu' => 'required|boolean',
            'url' => 'nullable|string|max:500',
            'estado' => 'required|boolean',
            'menu_id' => 'required|exists:menu,id',
        ]);

        $accion->update($validated);
        return redirect()->route('accion.index')->with('success', 'Acción actualizada con éxito.');
    }

    /**
     * Eliminar
     */
    public function destroy(Accion $accion)
    {
        $accion->delete();
        return redirect()->route('accion.index')->with('success', 'Acción eliminada con éxito.');
    }
}
