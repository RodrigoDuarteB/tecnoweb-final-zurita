<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
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

    public function setPasswordAttribute($value){
        $this->attributes["password"]= Hash::make($value);
    }

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
        $permisos = DB::table('permisos')
        ->join('acciones', 'permisos.accion_id', '=', 'acciones.id')
        ->join('menus', 'acciones.menu_id', '=', 'menus.id')
        ->where('permisos.rol_id', $this->rol_id)
        ->select(
            'menus.nombre as menu',
            'acciones.id as accion_id',
            'acciones.nombre as accion_nombre',
            'acciones.es_menu',
            'acciones.url',
            'acciones.menu_id'
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
            'password' => 'hashed',
        ];
    }
}
