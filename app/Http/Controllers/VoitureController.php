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

    public function search(Request $request)
    {
        $marque = $request->marque ?? '';
        $modele = $request->model ?? '';
        $annee = $request->year ?? '';
        $cars = Voiture::where('marque', 'like', '%' . $marque . '%')->where('modele', 'like', '%' . $modele . '%')->where('annee', $annee)->get();

        if (!count($cars)) return response()->json(["message" => "No car found"]);
        return response()->json(["data" => $cars]);
    }

    public function estimatePrice(Request $request){
            $request->validate([
                "marque" => "required|string|max:255",
                "modele" => "required|string|max:255",
                "annee" => "required|integer|digits:4",
                "kilometrage" => "required|integer",
                "prix" => "required|numeric|between:0,999999.99",
                "puissance" => "required|integer",
                "motorisation" => "required|string|max:255",
                "carburant" => "required|string|max:255",
            ]);
    
            $minKilometrage = $request->kilometrage - 200000;
            $maxKilometrage = $request->kilometrage + 200000;
            $minPrix = $request->prix - 100000;
            $maxPrix = $request->prix + 100000;
            
            $voiteurestimation = Voiture::where([
                ['modele', '=', $request->modele],
                ['annee', '=', $request->annee],
                ['puissance', '=', $request->puissance],
                ['motorisation', '=', $request->motorisation],
                ['carburant', '=', $request->carburant],
            ])
            ->whereBetween('kilometrage', [$minKilometrage, $maxKilometrage])
            ->whereBetween('prix', [$minPrix, $maxPrix])
            ->avg('prix');
            return response()->json(["Etimate price is " => $voiteurestimation ]);
    }
    
}