<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * @OA\Schema(
 *   schema="PathologyConcept",
 *   type="object",
 *   title="PathologyConcept",
 *   description="Concepto de patología para losas",
 *   required={"name", "description", "url_image"}
 * )
 *
 * @OA\Property(property="id", type="integer", example=1, description="ID del concepto de patología")
 * @OA\Property(property="name", type="string", example="Fisura", description="Nombre del concepto de patología")
 * @OA\Property(property="description", type="string", example="Fisura longitudinal en la losa", description="Descripción del concepto")
 * @OA\Property(property="url_image", type="string", format="url", example="https://ejemplo.com/imagen.jpg", description="URL de la imagen de referencia")
 */
class PathologyConcept extends Model
{
    use Searchable;

    protected $fillable = ['name', 'description', 'url_image'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
