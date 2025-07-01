<?php

namespace App\Http\Controllers;

use App\Http\Requests\BienStoreRequest;
use App\Http\Requests\BienUpdateRequest;
use App\Models\Bien;
use App\Models\TipoBien;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use InvalidArgumentException;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cliente = auth()->user()->cliente;
        $items = Bien::activos()
        ->with('cliente', 'tipoBien');
        if($cliente) {
            $items = $items->where('cliente_id', $cliente->id);
        }
        $items = $items->get();
        return Inertia::render('Bien/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Bien/Create', [
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BienStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $bien = Bien::create([
                ...$request->all(),
                'cliente_id' => $request->user()->cliente->id,
                'valor_referencial' => round($request->valor_referencial, 2)
            ]);
            $this->generarObligaciones($bien);
            session()->flash('jetstream.flash', [
                'banner' => 'Bien creado corretamente!',
                'bannerStyle' => 'success'
            ]);
            DB::commit();
            return redirect()->route('bien.index');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
            session()->flash('jetstream.flash', [
                'banner' => 'Hubo un error al crear el Bien!',
                'bannerStyle' => 'danger'
            ]);
            return redirect()->route('pago.index');
        }
    }

    private function generarObligaciones(Bien $bien) {
        $tiposObligacion = $bien->tipoBien->obligaciones;
        $createds = [];
        foreach($tiposObligacion as $tipoObligacion) {
            $created = $bien->obligaciones()->create([
                'obligacion_tipo_bien_id' => $tipoObligacion->id,
                'fecha_vencimiento' => $this->calcularFechaLimitePago($tipoObligacion->frecuencia)
            ]);
            $createds[] = $created;
        }
        return $createds;
    }

    private function calcularFechaLimitePago(string $frecuencia): Carbon | null {
        $fecha = Carbon::now();

        return match ($frecuencia) {
            'Diaria'    => $fecha->copy()->addDay(),
            'Semanal'   => $fecha->copy()->addWeek(),
            'Quincenal' => $fecha->copy()->addDays(15),
            'Mensual'   => $fecha->copy()->addMonth(),
            'Anual'     => $fecha->copy()->addYear(),
            'UnaVez'    => null,
            default     => throw new InvalidArgumentException("Frecuencia no válida: $frecuencia"),
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Bien $bien)
    {
         return Inertia::render('Bien/Create', [
            'item' => $bien,
            'esVer' => true,
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bien $bien)
    {
        return Inertia::render('Bien/Create', [
            'item' => $bien,
            'tiposBien' => TipoBien::activos()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BienUpdateRequest $request, Bien $bien)
    {
        $bien->update([
            ...$request->all(),
            'valor_referencial' => round($request->valor_referencial, 2)
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Bien actualizado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('bien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bien $bien)
    {
        $bien->eliminar();
        $bien->obligaciones()
        ->where('estado', 'Pendiente')
        ->update([
            'estado' => 'Cancelada'
        ]);
        session()->flash('jetstream.flash', [
            'banner' => 'Bien eliminado corretamente!',
            'bannerStyle' => 'success'
        ]);
        return redirect()->route('bien.index');
    }
}
