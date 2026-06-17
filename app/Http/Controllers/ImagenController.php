<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    // Listar imágenes
    public function index()
    {
        return Imagen::all();
    }

    // Guardar imagen
    public function store(Request $request)
    {
        $request->validate([
            'nombre_imagen' => 'required|string',
            'locality_id'   => 'required|integer',
            'ruta'          => 'required|string',
        ]);

        return Imagen::create($request->all());
    }

    // Mostrar una imagen
    public function show($id)
    {
        return Imagen::findOrFail($id);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $imagen = Imagen::findOrFail($id);

        $imagen->update($request->all());

        return $imagen;
    }

    // Eliminar
    public function destroy($id)
    {
        Imagen::destroy($id);

        return response()->json([
            'message' => 'Imagen eliminada'
        ]);
    }
}
