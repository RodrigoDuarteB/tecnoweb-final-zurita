<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoUpdateRequest;
use App\Models\Pago;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{
    //
    public function index()
    {
        $cliente = auth()->user()->cliente;
        $items = Pago::with('cliente.usuario')
        ->where('estado', '<>', 'Inactivo');

        if ($cliente) {
            $items = $items->where('cliente_id', $cliente->id);
        }
        $items = $items->get();
        return Inertia::render('Pago/Index', compact('items'));
    }

    /**
     *
     */
    public function create()
    {
        return Inertia::render('Pago/Create');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pago = Pago::create([
                'fecha_hora' => Carbon::now(),
                'cliente_id' => auth()->user()->cliente->id
            ]);

            $servicios = [];
            foreach ($request->servicios as $servicio) {
                $servicios[$servicio['servicio_id']] = $servicio;
            }

            $pago->servicios()->sync($servicios);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Pago creado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('pago.confirmar', [
                'pago' => $pago
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al crear el Pago!',
                'bannerStyle' => 'danger'
            ]);
            return redirect()->route('pago.index');
        }
    }

    /**
     * Mostrar los detalles de un pago específico.
     */
    public function show(Pago $pago)
    {
        $pago->load('servicios');
        $esVer = true;
        return Inertia::render('Pago/Create', compact('pago', 'esVer'));
    }

    /**
     *
     */
    public function edit(Pago $pago)
    {
        if($pago->estado != 'Pendiente') {
            session()->flash('jetstream.flash', [
                'banner' => 'Solo se puede confirmar un pago Pendiente!',
                'bannerStyle' => 'danger'
            ]);
            return redirect()->route('pago.index');
        }
        $pago->load('servicios');
        $esConfirmar = true;
        return Inertia::render('Pago/Create', compact('pago', 'esConfirmar'));
    }


    /**
     * Actualizar un pago existente.
     */
    public function update(PagoUpdateRequest $request, Pago $pago)
    {
        DB::beginTransaction();
        try {
            $pago->update([
                'estado' => 'Confirmado',
                'fecha_hora_confirmacion' => Carbon::now()
            ]);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Pago Confirmado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('pago.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al confirmar el Pago!',
                'bannerStyle' => 'danger'
            ]);
            return redirect()->route('pago.index');
        }
    }

    /**
     * Eliminar un pago.
     */
    public function destroy(Pago $pago)
    {
        DB::beginTransaction();
        try {
            $pago->update([
                'estado' => 'Inactivo'
            ]);
            DB::commit();
            session()->flash('jetstream.flash', [
                'banner' => 'Pago Eliminado corretamente!',
                'bannerStyle' => 'success'
            ]);
            return redirect()->route('pago.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al eliminar el Pago!',
                'bannerStyle' => 'error'
            ]);
            return redirect()->route('pago.index');
        }
    }

    public function confirmar(Pago $pago) {
        if($pago->estado != 'Pendiente') {
            session()->flash('jetstream.flash', [
                'banner' => 'Solo se puede confirmar un pago Pendiente!',
                'bannerStyle' => 'danger'
            ]);
            return redirect()->route('pago.index');
        }
        $pago->load('servicios');
        return Inertia::render('Pago/Confirmar', compact('pago'));
    }
}
