<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class APIClientController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-client')->only(['store']);
        $this->middleware('permission:read-client')->only(['index', 'show']);
        $this->middleware('permission:update-client')->only(['update']);
        $this->middleware('permission:delete-client')->only(['destroy']);
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
            'activity' => 'required|string|max:255',
            'rut' => 'required|string|max:50|unique:clients,rut',
            'enable' => 'required|boolean',
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
            'activity' => 'sometimes|required|string|max:255',
            'rut' => 'sometimes|required|string|max:50|unique:clients,rut,' . $client->id,
            'enable' => 'sometimes|required|boolean',
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
