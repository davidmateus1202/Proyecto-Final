<?php

namespace App\Http\Controllers;

use App\Models\Pathologies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;

class PathologiesController extends Controller
{
    /**
     * insertar conceptos tecnicos de patologias
     * @param Request $request
     * @return JsonResponse
     */
    public function createNewPathologyConcept(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => $validated->errors()], 400);
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('pathologies_concept', 'public');
                $url = Storage::url($path);
                $request->merge(['url_image' => $url]);
            }

            $pathologyConcept = Pathologies::create($request->all());

            return response()->json(['pathologyConcept' => $pathologyConcept], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating pathology concept',
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
