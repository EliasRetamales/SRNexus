<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIAlertController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-Alert')->only(['store']);
        $this->middleware('permission:read-Alert')->only(['index', 'show']);
        $this->middleware('permission:update-Alert')->only(['update']);
        $this->middleware('permission:delete-Alert')->only(['destroy']);
    }

    /**
     * Display a listing of the Alerts.
     */
    public function index()
    {
        $alerts = Alert::with(['sensor', 'register'])->get();
        return response()->json($alerts, Response::HTTP_OK);
    }

    /**
     * Store a newly created Alert in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'register_id' => 'required|exists:registers,id',
            'checked' => 'sometimes|boolean',
            'enable' => 'sometimes|boolean',
        ]);

        // Crear la Alert
        $alert = Alert::create($validated);

        return response()->json($alert, Response::HTTP_CREATED);
    }

    /**
     * Display the specified Alert.
     */
    public function show(Alert $alert)
    {
        $alert->load(['sensor', 'register']);
        return response()->json($alert, Response::HTTP_OK);
    }

    /**
     * Update the specified Alert in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'sensor_id' => 'sometimes|required|exists:sensors,id',
            'register_id' => 'sometimes|required|exists:registers,id',
            'checked' => 'sometimes|boolean',
            'enable' => 'sometimes|boolean',
        ]);

        // Actualizar la Alert
        $alert->update($validated);

        return response()->json($alert, Response::HTTP_OK);
    }

    /**
     * Remove the specified Alert from storage.
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
