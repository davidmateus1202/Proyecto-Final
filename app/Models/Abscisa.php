<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA; // 1. Importar los atributos de OpenAPI

/**
 * 2. Anotación principal del Schema (Componente)
 */
#[OA\Schema(
    schema: "Abscisa", // Este es el ID único que usaremos para referenciarlo
    title: "Abscisa",
    description: "Modelo de Abscisa. Representa una sección o tramo específico dentro de un proyecto, el cual contiene múltiples losas (placas).",
    properties: [ // 3. Definición de cada campo que la API devolverá
        new OA\Property(property: "id", type: "integer", description: "El ID único de la abscisa", example: 1),
        new OA\Property(property: "name", type: "string", description: "Nombre o identificador de la abscisa (ej. K0+000)", example: "K0+000 - K1+000"),
        new OA\Property(property: "number_of_abscisas", type: "integer", description: "Número de mediciones o sub-secciones dentro de este tramo", example: 100),
        new OA\Property(property: "project_id", type: "integer", description: "ID del proyecto al que pertenece", example: 1),
        new OA\Property(property: "user_id", type: "integer", description: "ID del usuario que la registró", example: 12),
        new OA\Property(property: "status", type: "string", description: "Estado actual de la abscisa", example: "pending", enum: ["pending", "in_progress", "finished"]),
        new OA\Property(property: "created_at", type: "string", format: "date-time", description: "Fecha y hora de creación", example: "2023-10-27T10:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", description: "Fecha y hora de la última actualización", example: "2023-10-27T12:30:00Z"),

        // 4. Definición de la relación
        new OA\Property(
            property: "slabs",
            type: "array",
            description: "Lista de losas (placas) asociadas a esta abscisa. Esta propiedad solo aparecerá si se carga la relación.",
            items: new OA\Items(ref: "#/components/schemas/Slabs")
        ),
        new OA\Property(
            property: "slabs_with_pathologies",
            type: "array",
            description: "Lista de losas (placas) con sus patologías precargadas.",
            items: new OA\Items(ref: "#/components/schemas/Slabs")
        )
    ]
)]
class Abscisa extends Model
{
    protected $fillable = ['name', 'number_of_abscisas' , 'project_id', 'status', 'user_id'];

    
    public function slabs()
    {
        return $this->hasMany(Slabs::class, 'abscisa_id');
    }

    public function slabsWithPathologies()
    {
        return $this->hasMany(Slabs::class, 'abscisa_id')
            ->with('pathologies');
    }
}