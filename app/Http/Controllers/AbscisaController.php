<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Abscisa;

class AbscisaController extends Controller
{
    /**
     * Get all abscisas
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $validated = Validator::make(request()->all(), [
            'project_id' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return response()->json([ 
                'success' => false,
                'error' => $validated->errors()], 
            400);
        }

        $abscisas = Abscisa::where('project_id', $request->project_id)->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $abscisas
        ], 200);
    }

    /**
     * Create new abscisa
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            'project_id' => $request->project_id
        ]);

        return response()->json([
            'success' => true,
            'data' => $abscisa
        ], 201);
    }

    /**
     * Delete abscisa
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Get all information about project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
}
