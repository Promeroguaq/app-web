<?php

namespace App\Http\Controllers;

use App\Models\Termal;
use Illuminate\Http\Request;

class TermalController extends Controller
{
    // Listar todos
    public function index()
    {
        return response()->json(Termal::all());
    }

    // Guardar nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'locality_id' => 'required|integer',
            'country_id' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        $termal = Termal::create($request->all());

        return response()->json($termal, 201);
    }

    // Mostrar uno
    public function show($id)
    {
        return response()->json(
            Termal::findOrFail($id)
        );
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $termal = Termal::findOrFail($id);
        $termal->update($request->all());

        return response()->json($termal);
    }

    // Eliminar
    public function destroy($id)
    {
        Termal::findOrFail($id)->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
