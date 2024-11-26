<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
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
            return redirect()->route('pago.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al crear el Pago!',
                'bannerStyle' => 'error'
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
        $pago->load('servicios');
        $esConfirmar = true;
        return Inertia::render('Pago/Create', compact('pago', 'esConfirmar'));
    }


    /**
     * Actualizar un pago existente.
     */
    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'fecha_hora' => 'required|date',
            'fecha_hora_confirmacion' => 'nullable|date',
            'qr_imagen' => 'nullable|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string|max:255',
        ]);

        $pago->update($validated);

        return redirect()->route('pago.index')->with('success', 'Pago actualizado con éxito.');
    }

    /**
     * Eliminar un pago.
     */
    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('pago.index')->with('success', 'Pago eliminado con éxito.');
    }
}
