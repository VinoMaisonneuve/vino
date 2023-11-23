<?php

namespace App\Http\Controllers;

use App\Models\BouteilleListe;
use Illuminate\Http\Request;

class BouteilleListeController extends Controller
{
    /**
     * Enregistre une bouteille dans la liste correspondante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $bouteilleListe = BouteilleListe::where([
            'liste_id' => $request->location_id,
            'bouteille_id' => $request->bouteille_id
        ])->first();
        if ($bouteilleListe) {
            $bouteilleListe->quantite += $request->quantite; 
            $bouteilleListe->save();
        }
        else {
            BouteilleListe::create([
                'liste_id' => $request->location_id, 
                'bouteille_id' => $request->bouteille_id,
                'quantite' => $request->quantite
            ]);
        }

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Mise à jour du nombre d'une bouteille en particulier dans une liste
     *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id Identifiant de l'entité BouteilleListe
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

        BouteilleListe::findOrFail($id)->update([
            'quantite' => $request->quantite
        ]);

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Suppression d'une entité BouteilleListe lors de la suppression d'une liste.
     *
     * @param  int  $liste_id Identifiant de la liste
     * @param  \App\Models\BouteilleListe  $bouteille_liste Instance de BouteilleListe à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($liste_id, BouteilleListe $bouteille_liste)
    {
        BouteilleListe::select()->where('id', $bouteille_liste->id)->delete(); 
        return redirect(route('liste.show', $liste_id))
        ->withSuccess('Bouteille supprimée de la liste!');
    }
}
