<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    public function index()
    {
        return Iglesia::all();
    }

    public function show($id)
    {
        return Iglesia::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_iglesia' => 'required|string',
            'id_localities'  => 'required|exists:localities,id',
            'descripcion'    => 'nullable|string'
        ]);

        return Iglesia::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $iglesia = Iglesia::findOrFail($id);

        $iglesia->update($request->all());

        return $iglesia;
    }

    public function destroy($id)
    {
        Iglesia::destroy($id);

        return response()->json(['message' => 'Iglesia eliminada']);
    }
}
