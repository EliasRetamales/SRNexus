<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Sensor;
use App\Models\Register;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the alerts.
     */
    public function index()
    {
        $alerts = Alert::with(['sensor', 'register'])->get(); // Cargar relaciones
        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new alert.
     */
    public function create()
    {
        $sensors = Sensor::all();
        $registers = Register::all();
        return view('alerts.create', compact('sensors', 'registers'));
    }

    /**
     * Store a newly created alert in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'register_id' => 'required|exists:registers,id',
            'checked' => 'required|boolean',
            'enable' => 'required|boolean',
        ]);

        Alert::create($request->all());

        return redirect()->route('alerts.index')->with('success', 'Alerta creada con éxito.');
    }

    /**
     * Display the specified alert.
     */
    public function show(Alert $alert)
    {
        return view('alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified alert.
     */
    public function edit(Alert $alert)
    {
        $sensors = Sensor::all();
        $registers = Register::all();
        return view('alerts.edit', compact('alert', 'sensors', 'registers'));
    }

    /**
     * Update the specified alert in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'register_id' => 'required|exists:registers,id',
            'checked' => 'required|boolean',
            'enable' => 'required|boolean',
        ]);

        $alert->update($request->all());

        return redirect()->route('alerts.index')->with('success', 'Alerta actualizada con éxito.');
    }

    /**
     * Remove the specified alert from storage.
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();

        return redirect()->route('alerts.index')->with('success', 'Alerta eliminada con éxito.');
    }
}
