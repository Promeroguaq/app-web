<?php

namespace App\Http\Controllers;

use App\Models\Isla;
use Illuminate\Http\Request;

class IslaController extends Controller
{
    public function index()
    {
        return Isla::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_isla' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        return Isla::create($request->all());
    }

    public function show($id)
    {
        return Isla::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $isla = Isla::findOrFail($id);

        $request->validate([
            'nombre_isla' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $isla->update($request->all());

        return $isla;
    }

    public function destroy($id)
    {
        Isla::findOrFail($id)->delete();
        return response()->json(['message' => 'Isla eliminada']);
    }
}
