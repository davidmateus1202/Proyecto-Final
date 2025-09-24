<?php

namespace App\Http\Controllers;

use App\Models\Pathologies;
use App\Models\PathologyConcept;
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
    public function create(Request $request) : JsonResponse
    {
        try {

            $validated = Validator::make($request->all(), [
                'slab_id' => 'required',
                'name' => 'required',
                'url_image' => 'required',
                'long_damage' => 'required',
                'type_long_damage' => 'required',
                'width_damage' => 'required',
                'type_width_damage' => 'required',
                'repair_long' => 'required',
                'type_repair_long' => 'required',
                'repair_width' => 'required',
                'type_repair_width' => 'required',
                'type_damage' => 'required',
            ]);
    
            if ($validated->fails()) {
                return response()->json(['error' => $validated->errors()], 400);
            }
    
            $pathologie = Pathologies::create($request->all());
    
            return response()->json(['pathologie' => $pathologie], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating pathologie',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
