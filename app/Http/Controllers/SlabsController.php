<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Slabs;
use Illuminate\Http\JsonResponse;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Slabs",
    description: "Endpoints para la gestión de losas (placas) de abscisas."
)]
class SlabsController extends Controller
{
    /**
     * Create new Slab
     * @param  Request $request
     * @return Response
     */
    #[OA\Post(
        path: "/api/slabs/create",
        summary: "Crear nueva losa",
        tags: ["Slabs"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["abscisa_id", "long", "width", "type_long", "type_width", "latitude", "longitude"],
                properties: [
                    new OA\Property(property: "abscisa_id", type: "integer", example: 1),
                    new OA\Property(property: "long", type: "number", format: "float", example: 5.0),
                    new OA\Property(property: "width", type: "number", format: "float", example: 2.5),
                    new OA\Property(property: "type_long", type: "string", example: "m"),
                    new OA\Property(property: "type_width", type: "string", example: "m"),
                    new OA\Property(property: "latitude", type: "string", example: "4.60971"),
                    new OA\Property(property: "longitude", type: "string", example: "-74.08175")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Losa creada exitosamente"),
            new OA\Response(response: 400, description: "Datos inválidos")
        ]
    )]
    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'abscisa_id' => 'required|integer',
            'long' => 'required',
            'width' => 'required',
            'type_long' => 'required|string',
            'type_width' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()], 400);
        }

        $slab = Slabs::create($request->all());
        return response()->json($slab, 201);

    }

    /**
     * Get all Slabs
     * @return Response
     */
    #[OA\Get(
        path: "/api/slabs/{abscisa_id}",
        summary: "Obtener todas las losas de una abscisa",
        tags: ["Slabs"],
        parameters: [
            new OA\Parameter(name: "abscisa_id", in: "path", required: true, description: "ID de la abscisa", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista de losas"),
            new OA\Response(response: 404, description: "No se encontraron losas")
        ]
    )]
    public function index($abscisa_id) : JsonResponse
    {

        $slabs = Slabs::where('abscisa_id', $abscisa_id)->get();

        if (!$slabs) {
            return response()->json(['message' => 'Slabs not found'], 404);
        }

        return response()->json($slabs, 200);
    }
}
