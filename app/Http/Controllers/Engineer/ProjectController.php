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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'string',
            'start_lat' => 'string',
            'start_lng' => 'string',
            'end_lat' => 'string',
            'end_lng' => 'string',
        ]);

        if ($validated->fails()) return response()->json($validated->errors(), 400);

        $url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
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
        $projects = $user->projects()->paginate(10);

        if (!$projects) return response()->json(['message' => 'Projects not found'], 404);
        
        return response()->json($projects, 200);
    }
}
