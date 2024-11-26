<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Project;
use App\Models\SafeLimit;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Muestra una lista de todos los sensores.
     */
    public function index()
    {
        $sensors = Sensor::with(['project', 'safeLimit'])->get();
        return view('sensors.index', compact('sensors'));
    }

    /**
     * Muestra el formulario para crear un nuevo sensor.
     */
    public function create()
    {
        $projects = Project::all();
        $safeLimits = SafeLimit::all();
        return view('sensors.create', compact('projects', 'safeLimits'));
    }

    /**
     * Almacena un nuevo sensor en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'safe_limit_id' => 'nullable|exists:safe_limits,id',
            'name' => 'required|string|max:255',
            'range_max' => 'required|numeric',
            'range_min' => 'required|numeric',
            'error' => 'required|numeric',
            'sensitivity' => 'nullable|string|max:255',
            'enable' => 'required|boolean',
        ]);

        Sensor::create($validated);
        return redirect()->route('sensors.index')->with('success', 'Sensor creado correctamente.');
    }

    /**
     * Muestra un sensor específico.
     */
    public function show(Sensor $sensor)
    {
        return view('sensors.show', compact('sensor'));
    }

    /**
     * Muestra el formulario para editar un sensor.
     */
    public function edit(Sensor $sensor)
    {
        $projects = Project::all();
        $safeLimits = SafeLimit::all();
        return view('sensors.edit', compact('sensor', 'projects', 'safeLimits'));
    }

    /**
     * Actualiza un sensor existente.
     */
    public function update(Request $request, Sensor $sensor)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'safe_limit_id' => 'nullable|exists:safe_limits,id',
            'name' => 'required|string|max:255',
            'range_max' => 'required|numeric',
            'range_min' => 'required|numeric',
            'error' => 'required|numeric',
            'sensitivity' => 'nullable|string|max:255',
            'enable' => 'required|boolean',
        ]);

        $sensor->update($validated);
        return redirect()->route('sensors.index')->with('success', 'Sensor actualizado correctamente.');
    }

    /**
     * Elimina un sensor de la base de datos.
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return redirect()->route('sensors.index')->with('success', 'Sensor eliminado correctamente.');
    }
}
