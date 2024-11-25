<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class APIClientController extends Controller
{
    /**
     * Constructor para aplicar middleware de permisos.
     */
    public function __construct()
    {
        $this->middleware('permission:create-Client')->only(['store']);
        $this->middleware('permission:read-Client')->only(['index', 'show']);
        $this->middleware('permission:update-Client')->only(['update']);
        $this->middleware('permission:delete-Client')->only(['destroy']);
    }

    /**
     * Display a listing of the clients.
     */
    public function index()
    {
        // $permission = Permission::where('name', 'read-Client')->first();
        // return [$permission, auth()->user(),auth()->user()->permissions->contains($permission),auth()->user()->permissions];
        // if (!$permission || !auth()->user()->permissions->contains($permission)) {
        //     return response()->json(['message' => 'Forbidden'], 403);
        // }

        $clients = Client::all();
        return response()->json($clients, 200);
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
