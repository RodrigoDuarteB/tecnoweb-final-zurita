<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolStoreRequest;
use App\Http\Requests\RolUpdateRequest;
use App\Models\Menu;
use App\Models\Rol;
use DB;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Rol::activos()->get();
        return Inertia::render('Rol/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::activos()
        ->with(['acciones'])
        ->get();
        return Inertia::render('Rol/Create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $rol = Rol::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'listable' => $request->listable,
                'editable' => $request->editable,
            ]);
            $rol->acciones()->sync($request->permisos);
            DB::commit();
            return redirect()->route('rol.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('rol.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        $rol->load(['acciones']);
        $menus = Menu::activos()
        ->with(['acciones'])
        ->get();
        $esVer = true;
        return Inertia::render('Rol/Create', compact('rol', 'menus', 'esVer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        $rol->load(['acciones']);
        $menus = Menu::activos()
        ->with(['acciones'])
        ->get();
        return Inertia::render('Rol/Create', compact('rol', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RolUpdateRequest $request, Rol $rol)
    {
        DB::beginTransaction();
        try {
            $rol->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'listable' => $request->listable,
                'editable' => $request->editable
            ]);
            $rol->acciones()->sync($request->permisos);
            DB::commit();
            return redirect()->route('rol.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('rol.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        DB::beginTransaction();
        try {
            $rol->update([
                'estado' => 'Inactivo'
            ]);
            DB::commit();
            return redirect()->route('rol.index');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('rol.index')
                ->with('error', 'Hubo un error al guardar el rol: '. $e->getMessage());
        }
    }
}
