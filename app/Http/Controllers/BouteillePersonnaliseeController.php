<?php

namespace App\Http\Controllers;

use App\Models\BouteillePersonnalisee;
use App\Models\Cellier;
use App\Models\CommentaireBouteillePersonnalisee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BouteillePersonnaliseeController extends Controller
{
    /**
     * Affichage du formulaire de création d'une nouvelle bouteille personnalisée dans un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier
     * @return \Illuminate\View\View
     */
    public function create($cellier_id)
    {
        $bouteilles = BouteillePersonnalisee::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc') // pour afficher le plus récemment créée
                ->get(); 
        return view('bouteille.create', ['cellier_id' => $cellier_id, 'bouteilles' => $bouteilles]);
    }

    /**
     * Enregistrement d'une nouvelle bouteille personnalisée et affichage dans un cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cellier_id Identifiant du cellier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $cellier_id)
    {
        $request->validate(
            [
                'nom' => 'required|max:255|unique:bouteilles_personnalisees,nom,NULL,id,user_id,' . Auth::id(),
                'millesime' => 'nullable|integer',
                'degre' => 'nullable|max:255',
                'couleur' => 'nullable|max:255',
                'producteur' => 'nullable|max:255',
                'type' => 'nullable|max:255',
                'cepage' => 'nullable|max:255',
                'region' => 'nullable|max:255',
                'pays' => 'nullable|max:255',
                'prix' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'format' => 'nullable|max:255'
            ],
            [
                'nom.required' => 'Le nom de la bouteille est obligatoire.', 
                'nom.unique' => 'Vous avez déjà une bouteille avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'millesime.integer' => 'Le millésime doit être un nombre entier',
                'degre.max' => 'Le degré ne doit pas dépasser 255 caractères.',
                'couleur.max' => 'La couleur ne doit pas dépasser 255 caractères.',
                'producteur.max' => 'Le producteur ne doit pas dépasser 255 caractères.',
                'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
                'cepage.max' => 'Le cépage ne doit pas dépasser 255 caractères.',
                'region.max' => 'Le région ne doit pas dépasser 255 caractères.',
                'pays.max' => 'Le pays ne doit pas dépasser 255 caractères.',
                'prix.numeric' => 'Le prix doit être numérique.',
                'prix.regex' => 'Le prix doit être séparé par un point et doit contenir un maximum de deux décimales.',
                'format.max' => 'Le format ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newBouteille = BouteillePersonnalisee::create([
            'nom' => $request->nom, 
            'millesime' => $request->millesime, 
            'degre' => $request->degre, 
            'couleur' => $request->couleur, 
            'producteur' => $request->producteur, 
            'type' => $request->type, 
            'cepage' => $request->cepage, 
            'region' => $request->region, 
            'pays' => $request->pays, 
            'prix' => $request->prix, 
            'format' => $request->format, 
            'user_id' => Auth::id()
        ]);

        $newBouteille->save(); 

        return redirect('/celliers\\' . $cellier_id . '/bouteilles-ajouter')->withSuccess('Bouteille personnalisée créée!'); 
    }


    /**
     * Affichage des détails d'une bouteille personnalisée dans un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier
     * @param  int  $id Identifiant de la bouteille personnalisée
     * @return \Illuminate\View\View
     */
    public function show($cellier_id, $id)
    {
        $bouteille = BouteillePersonnalisee::findOrFail($id);
        $celliers = Cellier::where('user_id', Auth::id())->get();
        $commentaire = CommentaireBouteillePersonnalisee::where('user_id', Auth::id())
        ->where('bouteille_id', $id)
        ->first();
        return view('bouteille.show-personnalisee', ['bouteille'=> $bouteille, 'celliers' => $celliers, 'commentaire' => $commentaire, 'cellier_id' => $cellier_id]);
    }


    /**
     * Affichage du formulaire d'édition d'une bouteille personnalisée dans un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier
     * @param  int  $bouteille_id Identifiant de la bouteille personnalisée à éditer
     * @return \Illuminate\View\View
     */
    public function edit($cellier_id, $bouteille_id)
    {
        $bouteille = BouteillePersonnalisee::findOrFail($bouteille_id);
        return view('bouteille.edit', ['bouteille'=> $bouteille, 'cellier_id' => $cellier_id, 'bouteille_id' => $bouteille_id]);
    }

    /**
     * Mise à jour des informations d'une bouteille personnalisée dans un cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cellier_id Identifiant du cellier
     * @param  int  $bouteille_id Identifiant de la bouteille personnalisée à mettre à jour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cellier_id, $bouteille_id)
    {
        $request->validate(
            [
                'nom' => ['required', 'max:255', Rule::unique('bouteilles_personnalisees', 'nom')
                ->ignore($bouteille_id, 'id')
                ->where('user_id', Auth::id()),],
                'millesime' => 'nullable|integer',
                'degre' => 'nullable|max:255',
                'couleur' => 'nullable|max:255',
                'producteur' => 'nullable|max:255',
                'type' => 'nullable|max:255',
                'cepage' => 'nullable|max:255',
                'region' => 'nullable|max:255',
                'pays' => 'nullable|max:255',
                'prix' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'format' => 'nullable|max:255'
            ],
            [
                'nom.required' => 'Le nom de la bouteille est obligatoire.', 
                'nom.unique' => 'Vous avez déjà une bouteille avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'millesime.integer' => 'Le millésime doit être un nombre entier',
                'degre.max' => 'Le degré ne doit pas dépasser 255 caractères.',
                'couleur.max' => 'La couleur ne doit pas dépasser 255 caractères.',
                'producteur.max' => 'Le producteur ne doit pas dépasser 255 caractères.',
                'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
                'cepage.max' => 'Le cépage ne doit pas dépasser 255 caractères.',
                'region.max' => 'Le région ne doit pas dépasser 255 caractères.',
                'pays.max' => 'Le pays ne doit pas dépasser 255 caractères.',
                'prix.numeric' => 'Le prix doit être numérique.',
                'prix.regex' => 'Le prix doit être séparé par un point et doit contenir un maximum de deux décimales.',
                'format.max' => 'Le format ne doit pas dépasser 255 caractères.'
            ]
        ); 

        BouteillePersonnalisee::findOrFail($bouteille_id)->update([
            'nom' => $request->nom, 
            'millesime' => $request->millesime, 
            'degre' => $request->degre, 
            'couleur' => $request->couleur, 
            'producteur' => $request->producteur, 
            'type' => $request->type, 
            'cepage' => $request->cepage, 
            'region' => $request->region, 
            'pays' => $request->pays, 
            'prix' => $request->prix, 
            'format' => $request->format, 
            'user_id' => Auth::id()
        ]);

        return redirect('/celliers\\' . $cellier_id . '/bouteilles-personnalisees\\' . $bouteille_id)
        ->withSuccess('Bouteille personnalisée modifiée!'); ; 
    }

    /**
     * Suppression d'une bouteille personnalisée et de ses relations associées dans un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier
     * @param  int  $bouteille_id Identifiant de la bouteille personnalisée à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cellier_id, $bouteille_id)
    {
        $bouteillePersonnalisee = BouteillePersonnalisee::findOrFail($bouteille_id); 
        try {
            $bouteillePersonnalisee->bouteillesPersonnaliseesCelliers()->delete(); 
            $bouteillePersonnalisee->commentairesBouteillesPersonnalisees()->delete(); 
            $bouteillePersonnalisee->delete(); 
            // return redirect('/celliers\\' . $cellier_id . '/bouteilles')->withSuccess('Bouteille personnalisée supprimée'); ; 
            return redirect('/celliers\\' . $cellier_id . '/bouteilles-ajouter')->withSuccess('Bouteille personnalisée supprimée!'); ; 
        }
        catch (\Exception $e) {
            return redirect('/celliers\\' . $cellier_id . '/bouteilles')->with('error', 'Le cellier n\'existe pas'); 
        }
    }
}
