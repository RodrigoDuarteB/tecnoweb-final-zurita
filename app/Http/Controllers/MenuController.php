<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuStoreRequest;
use App\Models\Menu;
use DB;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Menu::activos()->get();
        return Inertia::render('Menu/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Menu/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            $menu->acciones()->createMany($request->acciones);
            DB::commit();
            return redirect()->route('menu.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('menu.index')
                ->with('error', 'Hubo un error al guardar el menu: '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['acciones']);
        $esVer = true;
        return Inertia::render('Menu/Create', compact('menu', 'esVer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $menu->load(['acciones']);
        return Inertia::render('Menu/Create', compact('menu'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        DB::beginTransaction();
        try {
            $menu->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);
            $menu->acciones()->update($request->acciones);
            DB::commit();
            return redirect()->route('menu.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('menu.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        DB::beginTransaction();
        try {
            $menu->update([
                'estado' => 'Inactivo'
            ]);
            $menu->acciones()->update([
                'estado' => 'Inactivo'
            ]);
            DB::commit();
            return redirect()->route('menu.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('menu.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }
}
