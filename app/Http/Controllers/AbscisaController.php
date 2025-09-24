<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Abscisa;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Abscisas",
    description: "Endpoints para la gestión de abscisas (tramos de proyecto)."
)]
class AbscisaController extends Controller
{
    #[OA\Get(
        path: "/api/abscisa",
        summary: "Obtener lista paginada de abscisas por proyecto",
        tags: ["Abscisas"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "project_id", in: "query", required: true, description: "ID del proyecto", schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "page", in: "query", description: "Número de página", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Operación exitosa",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(property: "data", type: "object", description: "Objeto de paginación de Laravel", properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Abscisa")),
                    ])
                ])
            ),
            new OA\Response(response: 400, description: "Parámetros inválidos"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function index(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'project_id' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json([ 
                'success' => false,
                'error' => $validated->errors()], 
            400);
        }

        $abscisas = Abscisa::where('project_id', $request->project_id)
            ->where('user_id', $request->user()->id)
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $abscisas
        ], 200);
    }

    #[OA\Post(
        path: "/api/abscisa/create",
        summary: "Crear una nueva abscisa",
        tags: ["Abscisas"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Datos de la nueva abscisa",
            content: new OA\JsonContent(
                required: ["number_of_abscisas", "project_id"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "K1+000 - K2+000"),
                    new OA\Property(property: "number_of_abscisas", type: "integer", example: 100),
                    new OA\Property(property: "project_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Abscisa creada exitosamente", content: new OA\JsonContent(properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "data", ref: "#/components/schemas/Abscisa")
            ])),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function create(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'string',
            'number_of_abscisas' => 'required|integer',
            'project_id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([ 
                'success' => false,
                'error' => $validated->errors()], 
            400);
        }

        $abscisa = Abscisa::create([
            'name' => $request->name,
            'number_of_abscisas' => $request->number_of_abscisas,
            'project_id' => $request->project_id,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $abscisa
        ], 201);
    }

    #[OA\Delete(
        path: "/api/abscisa/delete",
        summary: "Eliminar una abscisa",
        tags: ["Abscisas"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "abscisa", in: "path", required: true, description: "ID de la abscisa a eliminar", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Abscisa eliminada exitosamente", content: new OA\JsonContent(properties: [new OA\Property(property: "success", type: "boolean", example: true)])),
            new OA\Response(response: 404, description: "Abscisa no encontrada"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function delete(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json([ 
                'success' => false,
                'error' => $validated->errors()], 
            400);
        }

        $abscisa = Abscisa::find($request->id);
        if (!$abscisa) {
            return response()->json([
                'success' => false,
                'error' => 'Abscisa not found'
            ], 404);
        }
        $abscisa->delete();

        return response()->json([
            'success' => true,
        ], 200);
    }

    #[OA\Get(
        path: "/api/web/projects/show",
        summary: "Obtener todas las abscisas de un proyecto con sus losas",
        tags: ["Abscisas", "Projects"],
        parameters: [
            new OA\Parameter(name: "project_id", in: "path", required: true, description: "ID del proyecto", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Operación exitosa", content: new OA\JsonContent(properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Abscisa"))
            ])),
            new OA\Response(response: 500, description: "Error del servidor")
        ]
    )]
    public function getDetails(Request $request) : JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'project_id' => 'required|integer'
            ]);

            if ($validated->fails()) {
                return response()->json([ 
                    'success' => false,
                    'error' => $validated->errors()], 
                400);
            };

            return response()->json([
                'success' => true,
                'data' => Abscisa::where('project_id', $request->project_id)->with('slabs')->get()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[OA\Get(
        path: "/api/abscisa/chart/show/{abscisa_id}",
        summary: "Obtener datos de patologías y daños para una abscisa",
        tags: ["Abscisas"],
        parameters: [
            new OA\Parameter(name: "abscisa", in: "path", required: true, description: "ID de la abscisa", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Operación exitosa"),
            new OA\Response(response: 404, description: "Abscisa no encontrada"),
            new OA\Response(response: 500, description: "Error del servidor")
        ]
    )]
    public function getChartData($abscisa_id)
    {
        try {
        $abscisa = Abscisa::find($abscisa_id);

            $area = 0;
            $damageArea = 0;
        $percentageDamage = 0;

        if (!$abscisa) {
            return response()->json([
                'success' => false,
                'error' => 'Abscisa not found'
            ], 404);
        }
            $slabs = $abscisa->slabsWithPathologies()->get();

            $groupData = [];

            foreach ($slabs as $slab) {
                foreach ($slab->pathologies as $pathology) {
                    $name = $pathology->name;
                    if (!isset($groupData[$name])) {
                    $groupData[$name] = [
                        'count' => 0,
                    ];
                    }
                    $groupData[$name]['count']++;
                    $damageArea += $pathology->long_damage * $pathology->width_damage;
                }

            // area
            $areaSlab = $slab->long * $slab->width;
            $area += $areaSlab;
            }

            $formattedData = [];
            foreach ($groupData as $name => $data) {
            $formattedData[] = [
                'name' => $name,
                'count' => $data['count'],
            ];
            }

        // Calculate the percentage of damage area
        if ($area > 0) {
            $percentageDamage = ($damageArea / $area) * 100;
        }
            
            return response()->json([
                'success' => true,
                'slabs' => $slabs,
                'damageArea' => $percentageDamage,
                'chart' => $formattedData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[OA\Patch(
        path: "/api/abscisa/change/status",
        summary: "Actualizar el estado de una abscisa",
        tags: ["Abscisas"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "abscisa", in: "path", required: true, description: "ID de la abscisa", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["status"],
                properties: [
                    new OA\Property(property: "status", type: "string", description: "Nuevo estado de la abscisa", example: "finished", enum: ["pending", "in_progress", "finished"])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Estado actualizado exitosamente"),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 404, description: "Abscisa no encontrada"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function changeStatusAbscisa(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'abscisa_id' => 'required',
            'status' => 'required'
        ]);

        if ($validated->fails()) return response()->json($validated->errors(), 400);

        $abscisa = Abscisa::where('id', $request->abscisa_id)->first();

        if (!$abscisa) return response()->json(['message' => 'Abscisa not found'], 404);

        $abscisa->status = 'finished';
        $abscisa->save();

        return response()->json(['message' => 'Abscisa status updated successfully'], 200);
    }
}