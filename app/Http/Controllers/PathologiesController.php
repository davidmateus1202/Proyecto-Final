<?php

namespace App\Http\Controllers;

use App\Models\Pathologies;
use App\Models\PathologyConcept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
