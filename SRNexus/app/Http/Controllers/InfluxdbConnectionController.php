<?php

namespace App\Http\Controllers;

use App\Models\InfluxdbConnection;
use App\Models\Project;
use Illuminate\Http\Request;

class InfluxdbConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $connections = InfluxdbConnection::with('project')->get();
        return view('influxdb_connections.index', compact('connections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all(); // Para seleccionar el proyecto asociado
        return view('influxdb_connections.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'token' => 'required|string',
            'bucket' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
        ]);

        InfluxdbConnection::create($request->all());
        return redirect()->route('influxdb_connections.index')
                         ->with('success', 'Conexión a InfluxDB creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InfluxdbConnection $influxdbConnection)
    {
        return view('influxdb_connections.show', compact('influxdbConnection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfluxdbConnection $influxdbConnection)
    {
        $projects = Project::all();
        return view('influxdb_connections.edit', compact('influxdbConnection', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InfluxdbConnection $influxdbConnection)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'token' => 'required|string',
            'bucket' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
        ]);

        $influxdbConnection->update($request->all());
        return redirect()->route('influxdb_connections.index')
                         ->with('success', 'Conexión a InfluxDB actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfluxdbConnection $influxdbConnection)
    {
        $influxdbConnection->delete();
        return redirect()->route('influxdb_connections.index')
                         ->with('success', 'Conexión a InfluxDB eliminada correctamente.');
    }
}
