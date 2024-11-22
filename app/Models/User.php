<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
        'rol_id'
    ];

    /* public function setPasswordAttribute($value){
        $this->attributes["password"]= Hash::make($value);
    } */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'permisos'
    ];

    public function getPermisosAttribute(){
        if($this->rol_id == 1) {
            return Menu::activos()
            ->with(['acciones'])
            ->select('id', 'nombre as menu', 'estado')
            ->get();
        }
        $permisos = DB::table('permiso')
        ->join('accion', 'permiso.accion_id', '=', 'accion.id')
        ->join('menu', 'accion.menu_id', '=', 'menu.id')
        ->where('menu.estado', 'Activo')
        ->where('permiso.rol_id', $this->rol_id)
        ->select(
            'menu.nombre as menu',
            'accion.id as accion_id',
            'accion.nombre as accion_nombre',
            'accion.es_menu',
            'accion.url',
            'accion.menu_id'
        )
        ->get();

        // Agrupar las acciones completas por menú
        $groupedPermisos = $permisos->groupBy('menu')->map(function ($acciones, $menu) {
            return [
                'menu' => $menu,
                'acciones' => $acciones->map(function ($accion) {
                    return [
                        'id' => $accion->accion_id,
                        'nombre' => $accion->accion_nombre,
                        'es_menu' => $accion->es_menu,
                        'url' => $accion->url,
                        'menu_id' => $accion->menu_id,
                    ];
                })->toArray(),
            ];
        })->values(); // Para convertir a una colección simple

        return $groupedPermisos;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            //'password' => 'hashed',
        ];
    }
}
