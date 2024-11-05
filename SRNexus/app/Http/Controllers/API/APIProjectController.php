<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIProjectController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-Project')->only(['store']);
        $this->middleware('permission:read-Project')->only(['index', 'show']);
        $this->middleware('permission:update-Project')->only(['update']);
        $this->middleware('permission:delete-Project')->only(['destroy']);
    }

    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::with('client')->get();
        return response()->json($projects, Response::HTTP_OK);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:projects,code',
            'description' => 'required|string',
            'enable' => 'required|boolean',
        ]);

        // Crear el proyecto
        $project = Project::create($validated);

        return response()->json($project, Response::HTTP_CREATED);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load('client');
        return response()->json($project, Response::HTTP_OK);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'client_id' => 'sometimes|required|exists:clients,id',
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|nullable|string|max:100|unique:projects,code,' . $project->id,
            'description' => 'sometimes|required|string',
            'enable' => 'sometimes|required|boolean',
        ]);

        // Actualizar el proyecto
        $project->update($validated);

        return response()->json($project, Response::HTTP_OK);
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
