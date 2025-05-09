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

class ProjectController extends Controller
{
    /**
     * create a new project
     * @param Request $request
     * @return JsonResponse
     */
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
    public function showDetails(Request $request) : JsonResponse
    {
        try {

            $validated = Validator::make($request->all(), [
                'project_id' => 'required|integer',
            ]);
    
            if ($validated->fails()) return response()->json($validated->errors(), 400);
    
            $project = Project::with('abscisaInProgress')->find($request->project_id);
            
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
}
