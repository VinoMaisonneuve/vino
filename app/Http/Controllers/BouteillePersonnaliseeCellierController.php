<?php

namespace App\Http\Controllers;

use App\Models\BouteillePersonnaliseeCellier;
use Illuminate\Http\Request;

class BouteillePersonnaliseeCellierController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cellier_id)
    {   
        $bouteillePersonnaliseeCellier = BouteillePersonnaliseeCellier::where([
            'cellier_id' => $cellier_id,
            'bouteille_id' => $request->bouteille_id
        ])->first();
        if ($bouteillePersonnaliseeCellier) {
            $bouteillePersonnaliseeCellier->quantite += $request->quantite; 
            $bouteillePersonnaliseeCellier->save();
        }
        else {
            BouteillePersonnaliseeCellier::create([
                'cellier_id' => $cellier_id, 
                'bouteille_id' => $request->bouteille_id,
                'quantite' => $request->quantite
            ]);
        }
        $quantite = $request->quantite;
        return redirect('/celliers\\' . $cellier_id . '/bouteilles#bouteilles-perso') //retourne vers le cellier à l'ancre des bouteilles personnalisées
        ->withSuccess($quantite . ' bouteille(s) personnalisée(s) ajoutée(s)!');
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

        BouteillePersonnaliseeCellier::findOrFail($id)->update([
            'quantite' => $request->quantite
        ]);

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cellier_id
     * @param  \App\Models\BouteillePersonnaliseeCellier  $bouteille_personnalisee_cellier_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cellier_id, BouteillePersonnaliseeCellier $bouteille_personnalisee_cellier)
    {
        BouteillePersonnaliseeCellier::select()->where('id', $bouteille_personnalisee_cellier->id)->delete(); 
        return redirect(route('cellier.show', $cellier_id));
    }
}
