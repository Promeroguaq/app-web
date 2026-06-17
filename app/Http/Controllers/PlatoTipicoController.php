<?php

namespace App\Http\Controllers;

use App\Models\PlatoTipico;
use Illuminate\Http\Request;

class PlatoTipicoController extends Controller
{
    public function index()
    {
        return PlatoTipico::all();
    }

    public function store(Request $request)
    {
        return PlatoTipico::create($request->all());
    }

    public function show($id)
    {
        return PlatoTipico::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $plato = PlatoTipico::findOrFail($id);
        $plato->update($request->all());
        return $plato;
    }

    public function destroy($id)
    {
        PlatoTipico::destroy($id);
        return response()->json(['message' => 'Plato eliminado']);
    }
}
