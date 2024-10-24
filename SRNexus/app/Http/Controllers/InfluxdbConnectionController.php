<?php

namespace App\Http\Controllers;

use App\Models\InfluxdbConnection;
use Illuminate\Http\Request;

class InfluxdbConnectionController extends Controller
{
    public function index()
    {
        $connections = InfluxdbConnection::all();
        return view('influxdb_connections.index', compact('connections'));
    }

    public function create()
    {
        return view('influxdb_connections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
            'token' => 'required',
            'bucket' => 'required',
            'organization' => 'required',
        ]);

        InfluxdbConnection::create($request->all());

        return redirect()->route('influxdb_connections.index')->with('success', 'Conexión creada exitosamente.');
    }

    // Métodos para editar y eliminar...
}
