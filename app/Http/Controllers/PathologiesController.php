<?php

namespace App\Http\Controllers;

use App\Models\Pathologies;
use App\Models\PathologyConcept;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Pathologies",
    description: "Endpoints para la gestión de patologías y conceptos técnicos."
)]
class PathologiesController extends Controller
{
    /**
     * insertar conceptos tecnicos de patologias
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: "/api/pathology-concept/create",
        summary: "Insertar concepto técnico de patología",
        tags: ["Pathologies"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description", "url_image"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Fisura"),
                    new OA\Property(property: "description", type: "string", example: "Fisura longitudinal en la losa"),
                    new OA\Property(property: "url_image", type: "string", format: "binary", description: "Imagen de referencia")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Concepto creado exitosamente"),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function createNewPathologyConcept(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'url_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => $validated->errors()], 400);
            }

            if ($request->hasFile('url_image')) {
                $path = $request->file('url_image')->store('pathologies_concept', 'public');
                $url = Storage::url($path);
            }

            $pathologyConcept = PathologyConcept::create([
                'name' => $request->name,
                'description' => $request->description,
                'url_image' => $url ?? null,
            ]);

            return response()->json(['pathologyConcept' => $pathologyConcept], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating pathology concept',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show concept pathology
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: "/api/pathology-concept",
        summary: "Mostrar todos los conceptos técnicos de patologías",
        tags: ["Pathologies"],
        responses: [
            new OA\Response(response: 200, description: "Lista de conceptos técnicos"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function showConcept(): JsonResponse
    {
        try {
            $pathologyConcepts = PathologyConcept::all();

            foreach ($pathologyConcepts as $concept) {
                $concept->url_image = URL::asset('storage/' . str_replace('storage/', '', $concept->url_image));
            }

            return response()->json(['pathologyConcepts' => $pathologyConcepts], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching pathology concepts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search pathologies
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: "/api/pathology-concept/search",
        summary: "Buscar conceptos técnicos de patologías",
        tags: ["Pathologies"],
        parameters: [
            new OA\Parameter(name: "search", in: "query", required: true, description: "Texto de búsqueda", schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Resultados de búsqueda"),
            new OA\Response(response: 404, description: "No se encontraron resultados"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function search(Request $request): JsonResponse
    {
        try {

            $search = $request->input('search');
            $pathologies = PathologyConcept::search($search)->get();

            if ($pathologies->isEmpty()) {
                return response()->json(['message' => 'No pathologies found'], 404);
            }

            foreach ($pathologies as $pathology) {
                $pathology->url_image = URL::asset('storage/' . str_replace('storage/', '', $pathology->url_image));
            }
            return response()->json(['pathologies' => $pathologies], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error searching pathologies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * index Pathologies
     */
    public function index()
    {

    }

    /**
     * Create new pathologie
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: "/api/pathologies/create",
        summary: "Crear nueva patología",
        tags: ["Pathologies"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["slab_id", "name", "url_image", "long_damage", "type_long_damage", "width_damage", "type_width_damage", "repair_long", "type_repair_long", "repair_width", "type_repair_width", "type_damage"],
                properties: [
                    new OA\Property(property: "slab_id", type: "integer", example: 1),
                    new OA\Property(property: "name", type: "string", example: "Fisura"),
                    new OA\Property(property: "url_image", type: "string", format: "binary", description: "Imagen de la patología"),
                    new OA\Property(property: "long_damage", type: "number", format: "float", example: 2.5),
                    new OA\Property(property: "type_long_damage", type: "string", example: "m"),
                    new OA\Property(property: "width_damage", type: "number", format: "float", example: 0.3),
                    new OA\Property(property: "type_width_damage", type: "string", example: "cm"),
                    new OA\Property(property: "repair_long", type: "number", format: "float", example: 2.0),
                    new OA\Property(property: "type_repair_long", type: "string", example: "m"),
                    new OA\Property(property: "repair_width", type: "number", format: "float", example: 0.2),
                    new OA\Property(property: "type_repair_width", type: "string", example: "cm"),
                    new OA\Property(property: "type_damage", type: "string", example: "Fisura")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Patología creada exitosamente"),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
     public function create(Request $request): JsonResponse
    {
        Log::info('Creating new pathology with request data: ', $request->all());
        try {
            // Reglas de validación base para los campos requeridos
            $rules = [
                'slab_id' => 'required|integer',
                'name' => 'required|string|max:255',
                'long_damage' => 'required|numeric',
                'type_long_damage' => 'required|string|max:255',
                'width_damage' => 'required|numeric',
                'type_width_damage' => 'required|string|max:255',
                'repair_long' => 'required|numeric',
                'type_repair_long' => 'required|string|max:255',
                'repair_width' => 'required|numeric',
                'type_repair_width' => 'required|string|max:255',
                'type_damage' => 'required|string|max:255',
            ];

            // Validar condicionalmente 'image' o 'url_image'
            // 'image' es opcional y debe ser un archivo de imagen si se envía.
            // 'url_image' es requerido SÓLO si no se ha enviado un archivo 'image'.
            // Esto asegura que siempre tendremos un valor para 'url_image'.
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif';
            $rules['url_image'] = 'required_without:image|nullable|string|max:2048'; // Es requerido si 'image' no está presente

            $validated = Validator::make($request->all(), $rules);

            if ($validated->fails()) {
                return response()->json(['error' => $validated->errors()], 400);
            }

            $finalImageUrl = null;

            // Lógica para determinar la URL de la imagen
            if ($request->hasFile('image')) {
                // Si se sube una nueva imagen, procesarla y obtener su URL
                $finalImageUrl = $this->uploadImage($request);
                if (!$finalImageUrl) {
                    // Si el proceso de subida falla (aunque uploadImage debería lanzar una excepción o retornar string)
                    return response()->json(['message' => 'Error al subir la imagen.'], 500);
                }
            } else {
                // Si no se sube una nueva imagen, usar la 'url_image' que viene en la petición
                // Esta ya está validada como 'required_without:image'
                $finalImageUrl = $request->input('url_image');
            }

            // Preparar los datos para la creación, excluyendo los campos de imagen originales
            // que ya hemos procesado
            $dataToCreate = $request->except(['image', 'url_image']);

            // Añadir la URL final de la imagen a los datos
            $dataToCreate['url_image'] = $finalImageUrl;

            $pathologie = Pathologies::create($dataToCreate);

            return response()->json(['pathologie' => $pathologie], 201);

        } catch (\Exception $e) { // Usamos Exception genérica para capturar cualquier error
            return response()->json([
                'message' => 'Error al crear la patología',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Procesa la imagen subida, la almacena y retorna su URL pública.
     *
     * @param Request $request
     * @return string|null La URL de la imagen o null si no se pudo subir.
     */
    private function uploadImage(Request $request): ?string
    {
        $url = null;

        if ($request->hasFile('image')) {
            // Guarda el archivo en el disco 'public' dentro de la carpeta 'pathologies'
            $path = $request->file('image')->store('pathologies', 'public');
            // Genera la URL pública para el archivo almacenado
            $url = Storage::url($path);
        }

        // Si se obtuvo una URL relativa, convertirla a absoluta si es necesario
        // URL::asset() genera una URL con el dominio base de la aplicación.
        if ($url !== null) {
            $url = URL::asset($url);
        }

        return $url;
    }
}