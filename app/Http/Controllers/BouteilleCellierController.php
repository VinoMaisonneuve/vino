<?php

namespace App\Http\Controllers;

use App\Models\BouteilleCellier;
use Illuminate\Http\Request;

class BouteilleCellierController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param $cellier_id
     * @param  \App\Models\BouteilleCellier  $bouteille_cellier
     * @return \Illuminate\Http\Response
     */
    public function destroy($cellier_id, BouteilleCellier $bouteille_cellier)
    {
        BouteilleCellier::select()->where('id', $bouteille_cellier->id)->delete(); 
        return redirect(route('cellier.show', $cellier_id))
        ->withSuccess('Bouteille supprimée du cellier!');;
    }
}
