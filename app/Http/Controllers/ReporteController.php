<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContadorPagina;
use App\Models\Servicio;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteController extends Controller
{

    public function index() {
        $contadores = ContadorPagina::orderByDesc('conteo')
        ->limit(3)
        ->get();
        return Inertia::render('Reporte/Index', compact('contadores'));
    }

    public function pagosCliente() {
        $clientes = Cliente::with('usuario')->get();
        return Inertia::render('Reporte/PagosCliente', compact('clientes'));
    }

    public function pagosPorCliente(Request $request) {
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $registros = DB::select("SELECT      p.id, u.name AS cliente,     TO_CHAR(p.fecha_hora, 'DD/MM/YYYY HH24:MI') AS fecha_hora,     COALESCE(TO_CHAR(p.fecha_hora_confirmacion, 'DD/MM/YYYY HH24:MI'), '-')
        AS fecha_hora_confirmacion,     p.estado,     STRING_AGG(s.nombre || ' ($' || sp.subtotal || ')', ', ') AS servicios,     SUM(sp.subtotal) AS total, SUM(sp.total_descuento)
        AS total_descuento
        FROM      pago p
        JOIN      servicio_pago sp ON p.id = sp.pago_id
        JOIN      servicio s ON sp.servicio_id = s.id
        JOIN cliente c ON c.id = p.cliente_id
        JOIN users u ON u.id = c.usuario_id
        WHERE p.estado <> 'Inactivo' AND p.cliente_id = ? AND p.fecha_hora BETWEEN ? AND ?
        GROUP BY p.id, p.fecha_hora, p.fecha_hora_confirmacion, p.estado, u.name ORDER BY p.fecha_hora", [$request->cliente_id, $fecha_inicio, $fecha_fin]);

        return response()->json($registros);
    }

    public function pagosServicio() {
        $servicios = Servicio::activos()->get();
        return Inertia::render('Reporte/PagosServicio', compact('servicios'));
    }

    public function pagosPorServicio(Request $request) {
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $registros = DB::select("SELECT p.id, u.name as cliente, TO_CHAR(p.fecha_hora, 'DD/MM/YYYY HH24:MI') AS fecha_hora,
        COALESCE(TO_CHAR(p.fecha_hora_confirmacion, 'DD/MM/YYYY HH24:MI'), '-') AS fecha_hora_confirmacion, p.estado, STRING_AGG(s.nombre || ' ($' || sp.subtotal || ')', ', ') AS servicios,
        SUM(sp.subtotal) AS total, SUM(sp.total_descuento) AS total_descuento
        FROM pago p
        JOIN servicio_pago sp ON p.id = sp.pago_id
        JOIN servicio s ON sp.servicio_id = s.id
        JOIN cliente c on c.id = p.cliente_id join users u on u.id = c.usuario_id
        WHERE p.estado <> 'Inactivo' AND p.id IN ( SELECT pago_id FROM servicio_pago WHERE servicio_id = ? )
        AND p.fecha_hora BETWEEN ? AND ? GROUP BY p.id, p.fecha_hora, p.fecha_hora_confirmacion, p.estado, u.name ORDER BY p.fecha_hora", [$request->servicio_id, $fecha_inicio, $fecha_fin]);

        return response()->json($registros);
    }

    public function total() {
        return Inertia::render('Reporte/Total');
    }

    public function totalPagosYDescuentos(Request $request) {
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $res = DB::select("SELECT SUM(sp.subtotal) as total, SUM(sp.total_descuento) as total_descuento
        FROM pago p JOIN servicio_pago sp ON p.id = sp.pago_id
        WHERE p.estado = 'Confirmado' AND p.fecha_hora_confirmacion BETWEEN ? AND ?", [$fecha_inicio, $fecha_fin]);

        return response()->json($res);
    }
}
