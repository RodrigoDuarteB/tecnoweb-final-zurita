<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Listar todos los menús.
     */
    public function index()
    {
        $menus = Menu::orderBy('id')->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Menu/Index', compact('menus'));
    }

    /**
     * Mostrar el formulario para crear un nuevo menú.
     */
    public function create()
    {
        return Inertia::render('Menu/Create');
    }

    /**
     * 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'required|boolean',
        ]);

        Menu::create($validated);
        return redirect()->route('menu.index')->with('success', 'Menú creado con éxito.');
    }

    /**
     * 
     */
    public function show(Menu $menu)
    {
        return Inertia::render('Menu/Show', compact('menu'));
    }

    
    public function edit(Menu $menu)
    {
        return Inertia::render('Menu/Edit', compact('menu'));
    }

    /**
     * Actualizar 
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'required|boolean',
        ]);

        $menu->update($validated);
        return redirect()->route('menu.index')->with('success', 'Menú actualizado con éxito.');
    }

    /**
     * Eliminar 
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menú eliminado con éxito.');
    }
}
