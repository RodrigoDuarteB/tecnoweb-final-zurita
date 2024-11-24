<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{
    //
    public function index()
    {
        $pagos = Pago::with('cliente') 
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));

        return Inertia::render('Pago/Index', compact('pagos'));
    }

    /**
     *
     */
    public function create()
    {
        $clientes = Cliente::all();
        return Inertia::render('Pago/Create', compact('clientes'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_hora' => 'required|date',
            'fecha_hora_confirmacion' => 'nullable|date',
            'qr_imagen' => 'nullable|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string|max:255',
        ]);

        Pago::create($validated);

        return redirect()->route('pago.index')->with('success', 'Pago creado con éxito.');
    }

    /**
     * Mostrar los detalles de un pago específico.
     */
    public function show(Pago $pago)
    {
        $pago->load('servicioPagos'); 
        return view('pago.show', compact('pago'));
    }

    /**
     * 
     */
    public function edit(Pago $pago)
    {
        $clientes = Cliente::all(); 

        return Inertia::render('Pago/Edit', compact('pago', 'clientes'));
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
