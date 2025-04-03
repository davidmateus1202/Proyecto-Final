<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    /**
     * get all projects in status 'finished'
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index() : JsonResponse
    {
        try {

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                ], 401);
            }

            $projects = $user->projects()->paginate();

            if ($projects->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No projects found',
                ], 404);
            }

            foreach ($projects as $project) {
                if ($project->url != null) {
                    $project->url = URL::asset($project->url);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $projects,
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * get details of a project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDetails(Request $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'project_id' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors(),
            ], 400);
        }

        try {

            $project = Project::where('id', $request->project_id)->first();
            $project = $project->abscisas()->get();

            if (!$project) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Project details not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $project,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
