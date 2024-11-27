<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
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
            session()->flash('jetstream.flash', [
                'banner' => 'Menú creado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('menu.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al crear el menú!',
                'bannerStyle' => 'error'
            ]);
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
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        DB::beginTransaction();
        try {
            $menu->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);
            foreach($request->acciones as $accion) {
                $menu->acciones()->updateOrCreate(['id' => $accion['id']], $accion);
            }
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Menú editado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('menu.index');
        } catch(Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al editar el menú!',
                'bannerStyle' => 'error'
            ]);
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
            session()->flash('jetstream.flash', [
                'banner' => 'Menú eliminado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('menu.index');
        } catch(Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al eliminar el menú!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('menu.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }

    public function buscar(Request $request) {
        $menus = Menu::activos()
        ->with('acciones')
        ->whereRaw("LOWER(nombre) LIKE '%?%'", [strtolower($request->termino)])
        ->get();
        return response()->json($menus);
    }
}
