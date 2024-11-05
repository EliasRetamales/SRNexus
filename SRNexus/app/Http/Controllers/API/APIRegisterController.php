<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIRegisterController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-Register')->only(['store']);
        $this->middleware('permission:read-Register')->only(['index', 'show']);
        $this->middleware('permission:update-Register')->only(['update']);
        $this->middleware('permission:delete-Register')->only(['destroy']);
    }

    /**
     * Display a listing of the Registers.
     */
    public function index()
    {
        $registers = Register::all();
        return response()->json($registers, Response::HTTP_OK);
    }

    /**
     * Store a newly created Register in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'value' => 'required|numeric',
            'measurement_time' => 'required|date',
            'enable' => 'sometimes|boolean',
        ]);

        // Crear el Register
        $register = Register::create($validated);

        return response()->json($register, Response::HTTP_CREATED);
    }

    /**
     * Display the specified Register.
     */
    public function show(Register $register)
    {
        return response()->json($register, Response::HTTP_OK);
    }

    /**
     * Update the specified Register in storage.
     */
    public function update(Request $request, Register $register)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'value' => 'sometimes|required|numeric',
            'measurement_time' => 'sometimes|required|date',
            'enable' => 'sometimes|boolean',
        ]);

        // Actualizar el Register
        $register->update($validated);

        return response()->json($register, Response::HTTP_OK);
    }

    /**
     * Remove the specified Register from storage.
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
