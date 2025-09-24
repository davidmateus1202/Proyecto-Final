<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Pathologies",
 *   type="object",
 *   title="Pathologies",
 *   description="Modelo de patologías de losas",
 *   required={"slab_id", "name", "url_image", "long_damage", "type_long_damage", "width_damage", "type_width_damage", "repair_long", "type_repair_long", "repair_width", "type_repair_width", "type_damage"}
 * )
 *
 * @OA\Property(property="slab_id", type="integer", example=1, description="ID de la losa")
 * @OA\Property(property="name", type="string", example="Fisura", description="Nombre de la patología")
 * @OA\Property(property="url_image", type="string", format="url", example="https://ejemplo.com/imagen.jpg", description="URL de la imagen de la patología")
 * @OA\Property(property="long_damage", type="number", format="float", example=2.5, description="Longitud del daño")
 * @OA\Property(property="type_long_damage", type="string", example="m", description="Unidad de longitud del daño")
 * @OA\Property(property="width_damage", type="number", format="float", example=0.3, description="Ancho del daño")
 * @OA\Property(property="type_width_damage", type="string", example="cm", description="Unidad de ancho del daño")
 * @OA\Property(property="repair_long", type="number", format="float", example=2.0, description="Longitud de la reparación")
 * @OA\Property(property="type_repair_long", type="string", example="m", description="Unidad de longitud de la reparación")
 * @OA\Property(property="repair_width", type="number", format="float", example=0.2, description="Ancho de la reparación")
 * @OA\Property(property="type_repair_width", type="string", example="cm", description="Unidad de ancho de la reparación")
 * @OA\Property(property="type_damage", type="string", example="Fisura", description="Tipo de daño")
 */
class Pathologies extends Model
{
    protected $fillable = [
        'slab_id',
        'name',
        'url_image',
        'long_damage',
        'type_long_damage',
        'width_damage',
        'type_width_damage',
        'repair_long',
        'type_repair_long',
        'repair_width',
        'type_repair_width',
        'type_damage'
    ];

    public function abscisaById()
    {
        
    }

    
}
