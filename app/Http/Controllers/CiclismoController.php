<?php

namespace App\Http\Controllers;

use App\Models\Ciclismo;
use Illuminate\Http\Request;

class CiclismoController extends Controller
{
    public function index()
    {
        return Ciclismo::all(); // Lista todas las rutas
    }

    public function show($id)
    {
        return Ciclismo::findOrFail($id); // Muestra una ruta específica
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_ruta_ciclismo' => 'required|string|max:255',
            'id_localities' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        return Ciclismo::create($data);
    }

    public function update(Request $request, $id)
    {
        $ciclismo = Ciclismo::findOrFail($id);

        $data = $request->validate([
            'nombre_ruta_ciclismo' => 'sometimes|string|max:255',
            'id_localities' => 'sometimes|integer',
            'descripcion' => 'nullable|string',
        ]);

        $ciclismo->update($data);

        return $ciclismo;
    }

    public function destroy($id)
    {
        $ciclismo = Ciclismo::findOrFail($id);
        $ciclismo->delete();

        return response()->json(['message' => 'Ruta eliminada correctamente']);
    }
}
