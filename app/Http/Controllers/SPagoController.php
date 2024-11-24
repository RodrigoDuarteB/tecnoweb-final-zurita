<?php

namespace App\Http\Controllers;

use App\Models\ServicioPago;
use App\Models\Servicio;
use App\Models\Pago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicioPagoController extends Controller
{
    
    public function index()
    {
        $servicioPagos = ServicioPago::with('servicio', 'pago') 
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));

        return Inertia::render('ServicioPago/Index', compact('servicioPagos'));
    }

   
    public function create()
    {
        $servicios = Servicio::all(); 
        $pagos = Pago::all(); 
        
        return Inertia::render('ServicioPago/Create', compact('servicios', 'pagos'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|exists:servicios,id', 
            'pago_id' => 'required|exists:pago,id', 
        ]);

        ServicioPago::create($validated); 
        return redirect()->route('servicio-pago.index')->with('success', 'ServicioPago registrado con éxito.');
    }

   
    public function show(ServicioPago $servicioPago)
    {
        $servicioPago->load('servicio', 'pago'); // Cargar las relaciones servicio y pago.
        return Inertia::render('ServicioPago/Show', compact('servicioPago'));
    }

    
    public function edit(ServicioPago $servicioPago)
    {
        $servicios = Servicio::all(); // Obtener todos los servicios.
        $pagos = Pago::all(); // Obtener todos los pagos.

        return Inertia::render('ServicioPago/Edit', compact('servicioPago', 'servicios', 'pagos'));
    }

   
    public function update(Request $request, ServicioPago $servicioPago)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'pago_id' => 'required|exists:pago,id',
        ]);

        $servicioPago->update($validated); // Actualizar la relación servicio-pago.
        return redirect()->route('servicio-pago.index')->with('success', 'ServicioPago actualizado con éxito.');
    }

 
    public function destroy(ServicioPago $servicioPago)
    {
        $servicioPago->delete(); // Eliminar la relación servicio-pago.
        return redirect()->route('servicio-pago.index')->with('success', 'ServicioPago eliminado con éxito.');
    }
}
