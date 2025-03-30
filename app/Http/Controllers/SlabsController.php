<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Slabs;
use Illuminate\Http\JsonResponse;

class SlabsController extends Controller
{
    /**
     * Create new Slab
     * @param  Request $request
     * @return Response
     */
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
    public function index($abscisa_id) : JsonResponse
    {

        $slabs = Slabs::where('abscisa_id', $abscisa_id)->get();

        if (!$slabs) {
            return response()->json(['message' => 'Slabs not found'], 404);
        }

        return response()->json($slabs, 200);
    }
}
