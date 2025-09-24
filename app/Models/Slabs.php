<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Slabs",
 *   type="object",
 *   title="Slabs",
 *   description="Modelo de losas de abscisa",
 *   required={"abscisa_id", "long", "width", "type_long", "type_width", "latitude", "longitude"}
 * )
 *
 * @OA\Property(property="abscisa_id", type="integer", example=1, description="ID de la abscisa")
 * @OA\Property(property="long", type="number", format="float", example=5.0, description="Longitud de la losa")
 * @OA\Property(property="width", type="number", format="float", example=2.5, description="Ancho de la losa")
 * @OA\Property(property="type_long", type="string", example="m", description="Unidad de longitud")
 * @OA\Property(property="type_width", type="string", example="m", description="Unidad de ancho")
 * @OA\Property(property="latitude", type="string", example="4.60971", description="Latitud de la losa")
 * @OA\Property(property="longitude", type="string", example="-74.08175", description="Longitud de la losa")
 * @OA\Property(property="observation", type="string", example="Sin observaciones", description="Observaciones de la losa")
 */
class Slabs extends Model
{
    protected $fillable = ['abscisa_id', 'long', 'width', 'type_long', 'type_width', 'latitude', 'longitude', 'observation'];

    /**
     * Get all pathologies by slab
     */
    public function pathologies()
    {
        return $this->hasMany(Pathologies::class, 'slab_id');
    }
}
