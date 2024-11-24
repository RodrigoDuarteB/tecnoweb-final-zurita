<?php

namespace App\Http\Controllers;

use App\Models\SDescuento;
use App\Models\Servicio;
use App\Models\Descuento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SDescuentoController extends Controller
{
    /**
     * Listar 
     */
    public function index()
    {
        $servicioDescuentos = SDescuento::with('servicio', 'descuento') 
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));

        return Inertia::render('SDescuento/Index', compact('servicioDescuentos'));
    }

    /**
     * Mostrar
     */
    public function create()
    {
        $servicios = Servicio::all(); 
        $descuentos = Descuento::all(); 
        
        return Inertia::render('SDescuento/Create', compact('servicios', 'descuentos'));
    }

    /**
     * Guardar 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|exists:servicios,id', // Validar la existencia de servicio.
            'descuento_id' => 'required|exists:descuento,id', // Validar la existencia de descuento.
            'estado' => 'required|boolean', // Estado del servicio descuento.
        ]);

        SDescuento::create($validated);
        return redirect()->route('servicio-descuento.index')->with('success', 'Descuento a servicio creado con éxito.');
    }

    /**
     * Mostrar un descuento aplicado a un servicio.
     */
    public function show(SDescuento $servicioDescuento)
    {
        $servicioDescuento->load('servicio', 'descuento'); // Cargar las relaciones correspondientes.
        return Inertia::render('SDescuento/Show', compact('servicioDescuento'));
    }

   
    public function edit(SDescuento $servicioDescuento)
    {
        $servicios = Servicio::all(); // Obtener todos los servicios.
        $descuentos = Descuento::all(); // Obtener todos los descuentos.

        return Inertia::render('SDescuento/Edit', compact('servicioDescuento', 'servicios', 'descuentos'));
    }

   
    public function update(Request $request, SDescuento $servicioDescuento)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'descuento_id' => 'required|exists:descuento,id',
            'estado' => 'required|boolean',
        ]);

        $servicioDescuento->update($validated);
        return redirect()->route('servicio-descuento.index')->with('success', 'Descuento a servicio actualizado con éxito.');
    }

  
    public function destroy(SDescuento $servicioDescuento)
    {
        $servicioDescuento->delete();
        return redirect()->route('servicio-descuento.index')->with('success', 'Descuento a servicio eliminado con éxito.');
    }
}
