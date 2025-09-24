<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Project",
 *   type="object",
 *   title="Project",
 *   description="Modelo de proyecto de infraestructura",
 *   required={"name", "description", "url", "start_lat", "start_lng", "end_lat", "end_lng", "status"}
 * )
 *
 * @OA\Property(property="id", type="integer", example=1, description="ID del proyecto")
 * @OA\Property(property="name", type="string", example="Proyecto Vía Central", description="Nombre del proyecto")
 * @OA\Property(property="description", type="string", example="Rehabilitación de vía principal", description="Descripción del proyecto")
 * @OA\Property(property="url", type="string", format="url", example="https://proyecto.com", description="URL del proyecto")
 * @OA\Property(property="start_lat", type="string", example="4.60971", description="Latitud inicial")
 * @OA\Property(property="start_lng", type="string", example="-74.08175", description="Longitud inicial")
 * @OA\Property(property="end_lat", type="string", example="4.70000", description="Latitud final")
 * @OA\Property(property="end_lng", type="string", example="-74.10000", description="Longitud final")
 * @OA\Property(property="status", type="string", example="in_progress", enum={"pending", "in_progress", "finished"}, description="Estado del proyecto")
 */
class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects');
    }

    /**
     * Get single abscisa in progress
     */
    public function abscisaInProgress()
    {
        return $this->hasOne(Abscisa::class)
            ->where('status', 'in_progress')
            ->with('slabs');
    }

    /**
     * Get all abscisas by project id
     */
    public function abscisas()
    {
        return $this->hasMany(Abscisa::class)
            ->with('slabsWithPathologies');
    }
}
