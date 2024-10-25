<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manage clients')->only(['store', 'update', 'destroy']);
        $this->middleware('permission:view clients')->only(['index', 'show']);
    }


    /**
     * Display a listing of the clients.
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients, Response::HTTP_OK);
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            // Agrega otras validaciones según sea necesario
        ]);

        // Crear el cliente
        $client = Client::create($validated);

        return response()->json($client, Response::HTTP_CREATED);
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        return response()->json($client, Response::HTTP_OK);
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clients,email,' . $client->id,
            // Agrega otras validaciones según sea necesario
        ]);

        // Actualizar el cliente
        $client->update($validated);

        return response()->json($client, Response::HTTP_OK);
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
