<?php

namespace App\Http\Controllers;

use App\Http\Requests\DescuentoStoreRequest;
use App\Http\Requests\DescuentoUpdateRequest;
use App\Models\Descuento;
use App\Models\Servicio;
use DB;
use Exception;
use Inertia\Inertia;

class DescuentoController extends Controller
{

    public function index()
    {
        $items = Descuento::activos()->get();
        return Inertia::render('Descuento/Index', compact('items'));
    }


    public function create()
    {
        $servicios = Servicio::activos()->get();
        return Inertia::render('Descuento/Create', compact('servicios'));
    }


    public function store(DescuentoStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $descuento = Descuento::create($request->except('servicios'));

            $descuento->servicios()->sync($request->servicios);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Descuento creado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('descuento.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al crear el Descuento!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('descuento.index');
        }
    }


    public function show(Descuento $descuento)
    {
        $descuento->load('servicios');
        $esVer = true;
        return Inertia::render('Descuento/Create', compact('descuento', 'esVer'));
    }


    public function edit(Descuento $descuento)
    {
        $descuento->load('servicios');
        $servicios = Servicio::activos()->get();
        return Inertia::render('Descuento/Create', compact('descuento', 'servicios'));
    }


    public function update(DescuentoUpdateRequest $request, Descuento $descuento)
    {
        DB::beginTransaction();
        try {
            $descuento->update($request->except('servicios'));
            $descuento->servicios()->sync($request->servicios);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Descuento modificado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('descuento.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al modificar el Descuento!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('descuento.index');
        }
    }


    public function destroy(Descuento $descuento)
    {
        DB::beginTransaction();
        try {
            $descuento->update([
                'estado' => 'Inactivo'
            ]);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Descuento eliminado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('descuento.index');
        } catch(Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al eliminar el descuento!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('descuento.index');
        }
    }
}
