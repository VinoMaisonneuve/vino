<?php

namespace App\Http\Controllers;

use App\Models\BouteillePersonnaliseeCellier;
use Illuminate\Http\Request;

class BouteillePersonnaliseeCellierController extends Controller
{

    /**
     * Enregistrement d'une nouvelle bouteille personnalisée dans le cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cellier_id Identifiant du cellier
     * @return \Illuminate\Http\RedirectResponse
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
     * Mise à jour des informations d'une bouteille personnalisée dans le cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Identifiant de la bouteille personnalisée dans le cellier
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

        BouteillePersonnaliseeCellier::findOrFail($id)->update([
            'quantite' => $request->quantite
        ]);

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Suppression d'une bouteille personnalisée spécifique à un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier
     * @param  \App\Models\BouteillePersonnaliseeCellier  $bouteille_personnalisee_cellier Instance du lien entre la bouteille personnalisée et le cellier à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cellier_id, BouteillePersonnaliseeCellier $bouteille_personnalisee_cellier)
    {
        BouteillePersonnaliseeCellier::select()->where('id', $bouteille_personnalisee_cellier->id)->delete(); 
        return redirect(route('cellier.show', $cellier_id));
    }
}
