<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Carbon\Carbon;
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
            'precio' => 'required|numeric|min:1'
        ]);


        Servicio::create([
            ...$validated,
            'usuario_id' => Auth::user()->id
        ]);

        session()->flash('jetstream.flash', [
            'banner' => 'Servicio Creado corretamente!',
            'bannerStyle' => 'success'
        ]);

        return redirect()->route('servicio.index');
    }

    public function show(Servicio $servicio)
    {
        $servicio->load(['usuario']);
        $esVer = true;
        return Inertia::render('Servicio/Create', compact('servicio','esVer'));
    }


    public function edit(Servicio $servicio)
    {
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
        session()->flash('jetstream.flash', [
            'banner' => 'Servicio Modificado corretamente!',
            'bannerStyle' => 'success'
        ]);

        return redirect()->route('servicio.index');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->update([
            'estado' => 'Inactivo'
        ]);

        // Mensaje de éxito
        session()->flash('jetstream.flash', [
            'banner' =>  'Servicio eliminado corretamente!',
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
            $monto_descuento = null;
            $nombre = $servicio->nombre;
            $precio_servicio = random_int(35, 500);

            if ($descuento) {
                $monto_descuento = $descuento->porcentaje > 0
                    ? ($precio_servicio * $descuento->porcentaje) / 100
                    : $descuento->monto;
                $precio = number_format($precio_servicio - $monto_descuento, 2);
                $nombre .= " / {$precio} Bs (-{$descuento->porcentaje}%)";
            } else {
                $precio = number_format($precio_servicio, 2);
                $nombre .= " / {$precio} Bs";
            }

            return [
                'id' => $servicio->id,
                'nombre' => $nombre,
                'precio' => $precio_servicio,
                'monto_descuento' => $monto_descuento,
                'subtotal' => $precio_servicio - ($monto_descuento ?? 0),
                'total_descuento' => $monto_descuento,
                'descuento' => $descuento
            ];
        });

        return response()->json($resultado);
    }
}
