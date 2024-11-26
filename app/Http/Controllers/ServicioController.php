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

        $servicios = Servicio::with('usuario')
            ->orderBy('id')
            ->paginate(10)
            ->appends(request()->except("page"));

        return Inertia::render('Servicio/Index', compact('servicios'));
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

        $servicio->load(['usuario', 'servicioDescuentos', 'servicioPagos']);

        return Inertia::render('Servicio/Show', compact('servicio'));
    }


    public function edit(Servicio $servicio)
    {
        $usuarios = User::all();

        return Inertia::render('Servicio/Edit', compact('servicio', 'usuarios'));
    }


    public function update(Request $request, Servicio $servicio)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'usuario_id' => 'required|exists:users,id'
        ]);


        $servicio->update($validated);

        return redirect()->route('servicio.index')->with('success', 'Servicio actualizado con éxito.');
    }


    public function destroy(Servicio $servicio)
    {

        $servicio->delete();


        return redirect()->route('servicio.index')->with('success', 'Servicio eliminado con éxito.');
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
