<?php

namespace App\Http\Controllers;

use App\Models\ParqueTematico;
use Illuminate\Http\Request;

class ParqueTematicoController extends Controller
{
    public function index()
    {
        return ParqueTematico::all();
    }

    public function store(Request $request)
    {
        return ParqueTematico::create($request->all());
    }

    public function show($id)
    {
        return ParqueTematico::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $parque = ParqueTematico::findOrFail($id);
        $parque->update($request->all());
        return $parque;
    }

    public function destroy($id)
    {
        ParqueTematico::destroy($id);
        return response()->json(['deleted' => true]);
    }
}
