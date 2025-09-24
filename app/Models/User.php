<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;


/**
 * @OA\Schema(
 *   schema="User",
 *   type="object",
 *   title="User",
 *   description="Modelo de usuario del sistema",
 *   required={"name", "email", "password"}
 * )
 *
 * @OA\Property(property="id", type="integer", example=1, description="ID del usuario")
 * @OA\Property(property="name", type="string", example="Juan Perez", description="Nombre del usuario")
 * @OA\Property(property="email", type="string", format="email", example="juan@example.com", description="Correo electrónico")
 * @OA\Property(property="email_verified_at", type="string", format="date-time", example="2025-09-23T10:00:00Z", description="Fecha de verificación de correo")
 * @OA\Property(property="password", type="string", format="password", example="********", description="Contraseña del usuario")
 * @OA\Property(property="remember_token", type="string", example="token123", description="Token de sesión")
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApitokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_projects');
    }

    public function projectsFinished()
    {
        return $this->belongsToMany(Project::class, 'user_projects')
            ->where('projects.status', 'finished');
    }
}
