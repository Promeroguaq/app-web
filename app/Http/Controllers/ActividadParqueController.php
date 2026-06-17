<?php

namespace App\Http\Controllers;

use App\Models\ActividadParque;
use Illuminate\Http\Request;

class ActividadParqueController extends Controller
{
    // Listar todas las actividades
    public function index()
    {
        return ActividadParque::all();
    }

    // Guardar desde importación (Excel)
    public function store(Request $request)
    {
        return ActividadParque::create($request->all());
    }

    // Mostrar una actividad
    public function show($id)
    {
        return ActividadParque::findOrFail($id);
    }
}
