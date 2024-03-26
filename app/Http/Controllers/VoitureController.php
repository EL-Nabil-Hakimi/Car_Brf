<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    //
    public function index()
    {
        $voitures = Voiture::all();
        return response()->json($voitures);
    }

    public function store(Request $request)
    {
        $voiture = Voiture::create($request->all());
        return response()->json($voiture, 201);
    }

    public function show(Voiture $voiture)
    {
        return response()->json($voiture);
    }

    public function update(Request $request, Voiture $voiture)
    {
        $voiture->update($request->all());
        return response()->json($voiture, 200);
    }

    public function destroy(Voiture $voiture)
    {
        $voiture->delete();
        return response()->json(null, 204);
    }
}
