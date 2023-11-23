<?php

namespace App\Http\Controllers;

use App\Models\BouteilleCellier;
use Illuminate\Http\Request;

class BouteilleCellierController extends Controller
{
    /**
     * Stockage d'une bouteille dans un cellier.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {   
        $bouteilleCellier = BouteilleCellier::where([
            'cellier_id' => $request->location_id,
            'bouteille_id' => $request->bouteille_id
        ])->first();
        if ($bouteilleCellier) {
            $bouteilleCellier->quantite += $request->quantite; 
            $bouteilleCellier->save();
        }
        else {
            BouteilleCellier::create([
                'cellier_id' => $request->location_id, 
                'bouteille_id' => $request->bouteille_id,
                'quantite' => $request->quantite
            ]);
        }

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Mise à jour la quantité d'une bouteille dans le cellier.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            ['quantite' => 'required|min: 0|integer'],
            [
                'quantite.required' => 'La quantité est obligatoire.', 
                'quantite.min' => 'La quantité doit être supérieure ou égale à zéro.',
                'quantite.integer' => 'La quantité doit être entière, sans décimal.'
            ]
        ); 

        BouteilleCellier::findOrFail($id)->update([
            'quantite' => $request->quantite
        ]);

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Suppression d'une bouteille du cellier.
     *
     * @param int $cellier_id
     * @param \App\Models\BouteilleCellier $bouteille_cellier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cellier_id, BouteilleCellier $bouteille_cellier)
    {
        BouteilleCellier::select()->where('id', $bouteille_cellier->id)->delete(); 
        return redirect(route('cellier.show', $cellier_id))
        ->withSuccess('Bouteille supprimée du cellier!');;
    }
}
