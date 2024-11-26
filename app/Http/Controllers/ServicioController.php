<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ServicioController extends Controller
{



    public function index()
{
    $items = Servicio::activos()->get();

    return Inertia::render('Servicio/Index', compact('items'));
}



    public function create()
    {
        return Inertia::render('Servicio/Create');
    }


    public function store(Request $request)
    {
        
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);


        Servicio::create([
            ...$validated,
            'usuario_id' => Auth::user()->id
        ]);


        return redirect()->route('servicio.index')->with('success', 'Servicio creado con éxito.');
    }

    public function show(Servicio $servicio)
    {
        $servicio->load(['usuario']);
        $esVer = true;
        return Inertia::render('Servicio/Create', compact('servicio','esVer'));
    }


    public function edit(Servicio $servicio)
    {
        $usuarios = User::all();

        return Inertia::render('Servicio/Create', compact('servicio'));
    }


    public function update(Request $request, Servicio $servicio)
    {
       
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
           
        ]);


        $servicio->update($validated);

        return redirect()->route('servicio.index')->with('success', 'Servicio actualizado con éxito.');
    }

    public function destroy(Servicio $servicio)
    {
        // Marcar el servicio como inactivo en la sesión (sin cambiar la base de datos)
        session()->put('servicio_inactivo', $servicio->id);
    
        // Mensaje de éxito
        session()->flash('jetstream.flash', [
            'banner' =>  'eliminado corretamente!',
            'bannerStyle' => 'success'
        ]);
    
        // Redirigir de vuelta a la lista de servicios
        return redirect()->route('servicio.index');
    }
    
    

    public function buscar(Request $request) {
        $termino = $request->input('termino');
        $fechaActual = Carbon::now();

        // Buscar servicios que contengan el término en el nombre
        $servicios = Servicio::activos()
        ->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($termino) . '%'])
        ->with(['descuentos' => function ($query) use ($fechaActual) {
                $query->where('descuento.fecha_inicio', '<=', $fechaActual)
                    ->where('descuento.fecha_fin', '>=', $fechaActual)
                    ->where('descuento.estado', 'Activo') // Ensure it's explicitly from "descuento" table
                    ->orderBy('descuento.fecha_inicio', 'desc')
                    ->limit(1); // Get only the most recent discount
            }])
            ->get();

        // Formatear la respuesta para incluir el monto con descuento
        $resultado = $servicios->map(function ($servicio) {
            $descuento = $servicio->descuentos->first(); // Obtener el único descuento cargado
            $montoDescuento = null;

            if ($descuento) {
                $descuentoAplicado = $descuento->porcentaje > 0
                    ? ($servicio->precio * $descuento->porcentaje) / 100
                    : $descuento->monto;

                $montoDescuento = $servicio->precio - $descuentoAplicado;
            }

            return [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'precio' => $servicio->precio,
                'monto_descuento' => $montoDescuento,
                'descuento' => $descuento
            ];
        });

        return response()->json($resultado);
    }
}
