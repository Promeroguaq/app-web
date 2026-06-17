<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGastronomica;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaGastronomicaController extends Controller
{
    /**
     * Mostrar todas las categorías gastronómicas.
     */
    public function index()
    {
        $categorias = CategoriaGastronomica::orderBy('PLATOS_TIPICOS', 'asc')->get();
        return response()->json($categorias);
    }

    /**
     * Crear una nueva categoría gastronómica.
     */
    public function store(Request $request)
    {
        $request->validate([
            'PLATOS_TIPICOS' => 'required|string|max:255|unique:tabla_gastronomia,PLATOS_TIPICOS',
            'CATEGORIA' => 'required|string|max:255',
            'DEPARTAMENTO' => 'required|string|max:255',
            'REGIÓN' => 'required|string|max:255',
            'DESCRIPCION' => 'required|string',
        ]);

        $categoria = CategoriaGastronomica::create($request->all());

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $categoria
        ], 201);
    }

    /**
     * Mostrar una categoría específica.
     */
    public function show($id)
    {
        $categoria = CategoriaGastronomica::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    /**
     * Actualizar una categoría existente.
     */
    public function update(Request $request, $id)
    {
        $categoria = CategoriaGastronomica::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $request->validate([
            'PLATOS_TIPICOS' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tabla_gastronomia')->ignore($categoria->ID_PLATOS, 'ID_PLATOS'),
            ],
            'CATEGORIA' => 'required|string|max:255',
            'DEPARTAMENTO' => 'required|string|max:255',
            'REGIÓN' => 'required|string|max:255',
            'DESCRIPCION' => 'required|string',
        ]);

        $categoria->update($request->all());

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'data' => $categoria
        ]);
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy($id)
    {
        $categoria = CategoriaGastronomica::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}
