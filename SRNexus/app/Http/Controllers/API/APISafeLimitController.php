<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SafeLimit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APISafeLimiteController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-SafeLimit')->only(['store']);
        $this->middleware('permission:read-SafeLimit')->only(['index', 'show']);
        $this->middleware('permission:update-SafeLimit')->only(['update']);
        $this->middleware('permission:delete-SafeLimit')->only(['destroy']);
    }

    /**
     * Display a listing of the SafeLimites.
     */
    public function index()
    {
        $safeLimits = SafeLimit::all();
        return response()->json($safeLimits, Response::HTTP_OK);
    }

    /**
     * Store a newly created SafeLimit in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'max_value' => 'required|numeric',
            'min_value' => 'required|numeric',
            'enable' => 'sometimes|boolean',
        ]);

        // Crear el SafeLimit
        $safeLimit = SafeLimit::create($validated);

        return response()->json($safeLimit, Response::HTTP_CREATED);
    }

    /**
     * Display the specified SafeLimit.
     */
    public function show(SafeLimit $safeLimit)
    {
        return response()->json($safeLimit, Response::HTTP_OK);
    }

    /**
     * Update the specified SafeLimit in storage.
     */
    public function update(Request $request, SafeLimit $safeLimit)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'max_value' => 'sometimes|required|numeric',
            'min_value' => 'sometimes|required|numeric',
            'enable' => 'sometimes|boolean',
        ]);

        // Actualizar el SafeLimit
        $safeLimit->update($validated);

        return response()->json($safeLimit, Response::HTTP_OK);
    }

    /**
     * Remove the specified SafeLimit from storage.
     */
    public function destroy(SafeLimit $safeLimit)
    {
        $safeLimit->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
