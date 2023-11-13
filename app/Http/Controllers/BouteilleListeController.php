<?php

namespace App\Http\Controllers;

use App\Models\BouteilleListe;
use Illuminate\Http\Request;

class BouteilleListeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BouteilleListe  $bouteilleListe
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

        BouteilleListe::findOrFail($id)->update([
            'quantite' => $request->quantite
        ]);

        return response()->json(['message' => 'Mise à jour réussie'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BouteilleListe  $bouteilleListe
     * @return \Illuminate\Http\Response
     */
    public function destroy($liste_id, BouteilleListe $bouteille_liste)
    {
        BouteilleListe::select()->where('id', $bouteille_liste->id)->delete(); 
        return redirect(route('liste.show', $liste_id));
    }
}
