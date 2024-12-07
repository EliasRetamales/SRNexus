<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Stadistic;
use App\Models\Sensor;
use App\Models\SensorType;
use Illuminate\Http\Request;

class StadisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stadistics = Stadistic::with('sensor')->get();
        return view('stadistics.index', compact('stadistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sensors = Sensor::all(); // Obtener sensores disponibles
        return view('stadistics.create', compact('sensors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'avg' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'min' => 'nullable|numeric',
        ]);

        Stadistic::create($validated);
        return redirect()->route('stadistics.index')->with('success', 'Estadística creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stadistic $stadistic)
    {
        return view('stadistics.show', compact('stadistic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stadistic $stadistic)
    {
        $sensors = Sensor::all();
        return view('stadistics.edit', compact('stadistic', 'sensors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stadistic $stadistic)
    {
        $validated = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'avg' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'min' => 'nullable|numeric',
        ]);

        $stadistic->update($validated);
        return redirect()->route('stadistics.index')->with('success', 'Estadística actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stadistic $stadistic)
    {
        $stadistic->delete();
        return redirect()->route('stadistics.index')->with('success', 'Estadística eliminada exitosamente.');
    }

    public function dashboard($projectId)
    {
        $project = Project::with('sensors.sensorType')->findOrFail($projectId);

        // Agrupar estadísticas por tipo de sensor
        $sensorTypes = SensorType::with(['sensors.stadistics' => function ($query) use ($projectId) {
            $query->whereHas('sensor', function ($sensorQuery) use ($projectId) {
                $sensorQuery->where('project_id', $projectId);
            });
        }])->get()->groupBy('id');

        return view('stadistics.index', compact('project', 'sensorTypes'));
    }
}
