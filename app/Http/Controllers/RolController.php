<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolStoreRequest;
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
        $items = Rol::where('estado', 'Activo')->get();
        return Inertia::render('Rol/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::where('estado', 'Activo')
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
            $rol->permisos()->createMany($request->permisos);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $rol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        //
    }
}
