<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{
    /**
     * Listar todos los pagos.
     */
    public function index()
    {
        $pagos = Pago::orderBy('id')->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Pago/Index', compact('pagos'));
    }

   
    public function create()
    {
        return Inertia::render('Pago/Create');
    }

    /**
     * Guardar un nuevo pago.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_hora' => 'required|date',
            'fecha_hora_confirmacion' => 'nullable|date',
            'qr_imagen' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string|max:50',
        ]);

        Pago::create($validated);
        return redirect()->route('pago.index')->with('success', 'Pago creado con éxito.');
    }

    /**
     * Mostrar un pago específico.
     */
    public function show(Pago $pago)
    {
        return Inertia::render('Pago/Show', compact('pago'));
    }

    /**
     * Mostrar el formulario para editar un pago.
     */
    public function edit(Pago $pago)
    {
        return Inertia::render('Pago/Edit', compact('pago'));
    }

    /**
     * Actualizar un pago existente.
     */
    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'fecha_hora' => 'required|date',
            'fecha_hora_confirmacion' => 'nullable|date',
            'qr_imagen' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string|max:50',
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
