<?php

namespace App\Models;

use App\Traits\Modelo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    use Modelo;


    protected $table = 'pago';

    /**
     * Atributos
     */
    protected $fillable = [
        'fecha_hora',
        'fecha_hora_confirmacion',
        'qr_imagen',
        'cliente_id',
        'estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'fecha_hora_confirmacion' => 'datetime',
    ];

    protected function fechaHora(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y H:i') : null,
        );
    }

    protected function fechaHoraConfirmacion(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y H:i') : null,
        );
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relacion
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_pago')
        ->withPivot('monto_servicio', 'monto_descuento', 'porcentaje_descuento', 'subtotal', 'total_descuento', 'cantidad');
    }
}
