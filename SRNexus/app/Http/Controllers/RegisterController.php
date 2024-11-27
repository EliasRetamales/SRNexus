<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registers = Register::all();
        return view('registers.index', compact('registers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
            'measurement_time' => 'required|date',
            'enable' => 'boolean',
        ]);

        Register::create($request->all());
        return redirect()->route('registers.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        return view('registers.show', compact('register'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Register $register)
    {
        return view('registers.edit', compact('register'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        $request->validate([
            'value' => 'required|numeric',
            'measurement_time' => 'required|date',
            'enable' => 'boolean',
        ]);

        $register->update($request->all());
        return redirect()->route('registers.index')->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return redirect()->route('registers.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
