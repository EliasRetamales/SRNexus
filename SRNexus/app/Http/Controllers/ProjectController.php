<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client')->get(); // Incluimos la relación con Client
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all(); // Obtenemos los clientes para el dropdown
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'required|string',
            'enable' => 'boolean',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Proyecto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::all(); // Obtenemos los clientes para el dropdown
        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'required|string',
            'enable' => 'boolean',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }

    public function dashboard()
    {
        $projects = Project::with('sensors')->get();
        return view('projects.index_dashboard', compact('projects'));
    }

    // public function showSensorTypes($id)
    // {
    //     $project = Project::with(['sensors.sensorType'])
    //         ->where('id', $id)
    //         ->firstOrFail();

    //     $sensorTypes = $project->sensors
    //         ->groupBy('sensor_type_id');

    //     return view('projects.sensor_types', compact('project', 'sensorTypes'));
    // }

    public function showSensorTypes($id, Request $request)
    {
        // Obtener el rango de tiempo
        $defaultStartTime = Carbon::now()->subMinutes(5);
        $startTime = $request->query('start_time', $defaultStartTime->toDateTimeString());

        // Obtener el proyecto y sensores agrupados por tipo
        $project = Project::with(['sensors.sensorType', 'sensors.registers' => function ($query) use ($startTime) {
            $query->where('measurement_time', '>=', $startTime);
        }])->findOrFail($id);

        $sensorTypes = $project->sensors
            ->groupBy('sensor_type_id');

        return view('projects.sensor_types', compact('project', 'sensorTypes', 'startTime'));
    }
}
