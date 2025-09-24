<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\Abscisa;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Projects",
    description: "Endpoints para la gestión de proyectos."
)]
class ProjectController extends Controller
{
    /**
     * create a new project
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: "/api/projects/create",
        summary: "Crear un nuevo proyecto",
        tags: ["Projects"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Proyecto Vía Central"),
                    new OA\Property(property: "description", type: "string", example: "Rehabilitación de vía principal"),
                    new OA\Property(property: "image", type: "string", format: "binary", description: "Imagen del proyecto"),
                    new OA\Property(property: "start_lat", type: "string", example: "4.60971"),
                    new OA\Property(property: "start_lng", type: "string", example: "-74.08175"),
                    new OA\Property(property: "end_lat", type: "string", example: "4.70000"),
                    new OA\Property(property: "end_lng", type: "string", example: "-74.10000")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Proyecto creado exitosamente"),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function create(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'string',
            'start_lat' => 'string',
            'start_lng' => 'string',
            'end_lat' => 'string',
            'end_lng' => 'string',
        ]);

        if ($validated->fails()) return response()->json($validated->errors(), 400);

        $url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $url = Storage::url($path);
        }

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $url,
            'start_lat' => $request->start_lat,
            'start_lng' => $request->start_lng,
            'end_lat' => $request->end_lat,
            'end_lng' => $request->end_lng,
        ]);

        if (!$project) return response()->json(['message' => 'Error creating project'], 500);

        // insertamos el proyecto en la tabla pivote user_projects
        $user = Auth::user();
        $user_projects = UserProject::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);

        if (!$user_projects) return response()->json(['message' => 'Error creating user project'], 500);

        return response()->json($project, 201);
    }

    /**
     * get all projects
     * @return JsonResponse
     */
    #[OA\Get(
        path: "/api/projects",
        summary: "Obtener todos los proyectos del usuario autenticado",
        tags: ["Projects"],
        responses: [
            new OA\Response(response: 200, description: "Lista de proyectos paginada"),
            new OA\Response(response: 404, description: "No se encontraron proyectos")
        ]
    )]
    public function index() : JsonResponse
    {
        $user = Auth::user();
        $projects = $user->projects()->orderby('id', 'desc')->paginate(10);

        foreach ($projects as $project) {
            if ($project->url) {
                $url = URL::asset($project->url);
                $project->url = $url;
            }
        }

        if (!$projects) return response()->json(['message' => 'Projects not found'], 404);
        
        return response()->json($projects, 200);
    }

    /**
     * get details project by id
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: "/api/projects/details",
        summary: "Obtener detalles de un proyecto por ID",
        tags: ["Projects"],
        parameters: [
            new OA\Parameter(name: "project_id", in: "query", required: true, description: "ID del proyecto", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Detalles del proyecto"),
            new OA\Response(response: 404, description: "Proyecto no encontrado"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function showDetails(Request $request) : JsonResponse
    {
        try {

            $validated = Validator::make($request->all(), [
                'project_id' => 'required|integer',
            ]);
    
            if ($validated->fails()) return response()->json($validated->errors(), 400);

            $userId = Auth::id();

            $project = Project::with([
                'abscisaInProgress' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])->find($request->project_id);
            
            if (!$project) return response()->json(['message' => 'Project not found'], 404);

            if ($project->url) {
                $url = URL::asset($project->url);
                $project->url = $url;
            }
    
            return response()->json($project, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting project details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * get details project by id from route parameter
     * @param request Request
     * @return JsonResponse
     */
    #[OA\Get(
        path: "/api/projects/{id}",
        summary: "Obtener detalles de un proyecto por parámetro de ruta",
        tags: ["Projects"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID del proyecto", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Detalles del proyecto"),
            new OA\Response(response: 404, description: "Proyecto no encontrado"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function showDetailsById(Request $request) : JsonResponse 
    {
        try {
            $projectId = $request->route('id');
            $project = Project::with('abscisas')->find($projectId);

            $project->url = URL::asset($project->url);

            if (!$project) return response()->json(['message' => 'Project not found'], 404);

            return response()->json($project, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting project details by id',
                'error' => $e->getMessage()
            ], 500);
        } 
    }

    /**
     * register a new collaborator into a project
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: "/api/projects/collaborator/register",
        summary: "Registrar un colaborador en un proyecto",
        tags: ["Projects"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["project_id"],
                properties: [
                    new OA\Property(property: "project_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Colaborador registrado con éxito"),
            new OA\Response(response: 400, description: "Datos inválidos"),
            new OA\Response(response: 404, description: "Proyecto no encontrado"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function registerCollaborator(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'project_id' => 'required|integer',
        ]);

        if ($validated->fails()) return response()->json($validated->errors(), 400);

        $user = Auth::user();

        try {

            $project = Project::find($request->project_id);

            if (!$project) return response()->json(['message' => 'Projecto no encontrado'], 404);

            $team = UserProject::where('project_id', $request->project_id)
                ->where('user_id', $user->id)
                ->first();
    
            if ($team) {
                return response()->json(['message' => 'Ya está registrado como colaborador en este proyecto'], 400);
            }

            $userProject = UserProject::create([
                'user_id' => $user->id,
                'project_id' => $request->project_id,
            ]);

            if (!$userProject) {
                return response()->json(['message' => 'Error registering collaborator'], 500);
            }

            return response()->json(['message' => 'Colaborador registrado con éxito'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error registering collaborator',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * get all project
     */
    #[OA\Get(
        path: "/api/projects/all",
        summary: "Obtener todos los proyectos (limitado)",
        tags: ["Projects"],
        responses: [
            new OA\Response(response: 200, description: "Lista de proyectos"),
            new OA\Response(response: 500, description: "Error interno")
        ]
    )]
    public function getAllProjects() : JsonResponse
    {
        try {

            $projects = Project::limit(4)->get();
            
            foreach ($projects as $project) {
                $project->url = URL::asset($project->url);
            }

            return response()->json($projects, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting all projects',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
