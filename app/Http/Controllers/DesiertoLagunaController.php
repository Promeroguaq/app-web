<?php

namespace App\Http\Controllers;

use App\Models\DesiertoLaguna;
use Illuminate\Http\Request;

class DesiertoLagunaController extends Controller
{
    public function index()
    {
        return DesiertoLaguna::all();
    }

    public function store(Request $request)
    {
        return DesiertoLaguna::create($request->all());
    }

    public function show($id)
    {
        return DesiertoLaguna::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $desierto = DesiertoLaguna::findOrFail($id);
        $desierto->update($request->all());
        return $desierto;
    }

    public function destroy($id)
    {
        DesiertoLaguna::destroy($id);
        return response()->json(['message' => 'Registro eliminado']);
    }
}
