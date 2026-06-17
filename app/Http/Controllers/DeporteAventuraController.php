<?php

namespace App\Http\Controllers;

use App\Models\DeporteAventura;
use Illuminate\Http\Request;

class DeporteAventuraController extends Controller
{
    // Obtener todos con paginación
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $page = $request->get('page', 1);
        
        return DeporteAventura::with('locality')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();
    }

    // Guardar desde Excel / formulario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'locality_id' => 'required|exists:localities,id',
            'descripcion' => 'nullable|string',
        ]);

        return DeporteAventura::create($request->all());
    }

    // Mostrar uno
    public function show($id)
    {
        return DeporteAventura::with('locality')->findOrFail($id);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $deporte = DeporteAventura::findOrFail($id);

        $deporte->update($request->all());

        return $deporte;
    }

    // Eliminar
    public function destroy($id)
    {
        DeporteAventura::destroy($id);

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
