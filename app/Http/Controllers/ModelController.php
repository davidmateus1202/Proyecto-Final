<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Model",
    description: "Endpoints para la consulta y procesamiento del modelo de IA."
)]
class ModelController extends Controller
{
    /**
     * Consulta el modelo de IA
     *@param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: "/api/model/ia",
        summary: "Consultar el modelo de IA con una imagen",
        tags: ["Model"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["image"],
                properties: [
                    new OA\Property(property: "image", type: "string", format: "binary", description: "Imagen para procesar en el modelo IA")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Respuesta del modelo IA"),
            new OA\Response(response: 400, description: "Error de validación o imagen no válida"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function ia_model(Request $request) 
    {
        $validated = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 400);
        }

        try {
            // subir imagen al servidor
            $url_image = $this->uploadImage($request);

            if ($url_image == null) {
                return response()->json([
                    'message' => 'Error: imagen no valida'
                ], 400);
            }

            //url de la peticion
            $url = env('API_URL_MODEL');
            $response = Http::post($url, [
                'image' => $url_image,
            ]);

            if ($response->status() != 200) {
                return response()->json([
                    'message' => 'Error: ' . $response->body()
                ], $response->status());
            }

            return response()->json([
                'message' => 'Modelo IA',
                'data' => $response->json(),
                'image' => $url_image
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * procesa la imagen
     * - valida la imagen y retorna el enlace de la imagen
     * @param $image
     */
    private function uploadImage($image)
    {
        $url = null;

        if ($image->hasFile('image')) {
            $path = $image->file('image')->store('pathologies', 'public');
            $url = Storage::url($path);
        }

        if ($url != null) {
            $url = URL::asset($url);
        }
        return $url;
    }
}

