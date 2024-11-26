<?php

namespace App\Http\Controllers;

use App\Models\SafeLimit;
use Illuminate\Http\Request;

class SafeLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $safeLimits = SafeLimit::all(); // Obtener todos los límites seguros
        return view('safe_limits.index', compact('safeLimits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('safe_limits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'max_value' => 'nullable|numeric',
            'min_value' => 'nullable|numeric',
            'enable' => 'required|boolean',
        ]);

        SafeLimit::create($request->all());

        return redirect()->route('safe_limits.index')->with('success', 'Límite seguro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SafeLimit $safeLimit)
    {
        return view('safe_limits.show', compact('safeLimit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SafeLimit $safeLimit)
    {
        return view('safe_limits.edit', compact('safeLimit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SafeLimit $safeLimit)
    {
        $request->validate([
            'max_value' => 'nullable|numeric',
            'min_value' => 'nullable|numeric',
            'enable' => 'required|boolean',
        ]);

        $safeLimit->update($request->all());

        return redirect()->route('safe_limits.index')->with('success', 'Límite seguro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SafeLimit $safeLimit)
    {
        $safeLimit->delete();

        return redirect()->route('safe_limits.index')->with('success', 'Límite seguro eliminado exitosamente.');
    }
}
