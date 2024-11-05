<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APISensorController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-Sensor')->only(['store']);
        $this->middleware('permission:read-Sensor')->only(['index', 'show']);
        $this->middleware('permission:update-Sensor')->only(['update']);
        $this->middleware('permission:delete-Sensor')->only(['destroy']);
    }

    /**
     * Display a listing of the Sensors.
     */
    public function index()
    {
        $sensors = Sensor::with(['project', 'safeLimit'])->get();
        return response()->json($sensors, Response::HTTP_OK);
    }

    /**
     * Store a newly created Sensor in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'safe_limit_id' => 'nullable|exists:safe_limits,id',
            'name' => 'required|string|max:255',
            'enable' => 'sometimes|boolean',
            'range_max' => 'required|numeric',
            'range_min' => 'required|numeric',
            'error' => 'required|numeric',
            'sensitivity' => 'nullable|string|max:255',
        ]);

        // Crear el Sensor
        $sensor = Sensor::create($validated);

        return response()->json($sensor, Response::HTTP_CREATED);
    }

    /**
     * Display the specified Sensor.
     */
    public function show(Sensor $sensor)
    {
        $sensor->load(['project', 'safeLimit']);
        return response()->json($sensor, Response::HTTP_OK);
    }

    /**
     * Update the specified Sensor in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'project_id' => 'sometimes|required|exists:projects,id',
            'safe_limit_id' => 'sometimes|nullable|exists:safe_limits,id',
            'name' => 'sometimes|required|string|max:255',
            'enable' => 'sometimes|boolean',
            'range_max' => 'sometimes|numeric',
            'range_min' => 'sometimes|numeric',
            'error' => 'sometimes|numeric',
            'sensitivity' => 'sometimes|nullable|string|max:255',
        ]);

        // Actualizar el Sensor
        $sensor->update($validated);

        return response()->json($sensor, Response::HTTP_OK);
    }

    /**
     * Remove the specified Sensor from storage.
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
