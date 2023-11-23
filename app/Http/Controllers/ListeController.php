<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ListeController extends Controller
{
    /**
     * Affichage de l'ensemble des listes de bouteilles de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $listes = Liste::withCount('bouteillesListes')
                            ->with('bouteillesListes.bouteille')
                            ->where('user_id', Auth::id())
                            ->get(); 

        $listes->each(function ($liste) {
            $liste->prixTotal = 0; 
            $liste->quantiteTotal = 0; 
            foreach($liste->bouteillesListes as $bouteilleListe) {
                $liste->prixTotal += $bouteilleListe->bouteille->prix * $bouteilleListe->quantite; 
                $liste->quantiteTotal += $bouteilleListe->quantite;
            }
        }); 
        
        return view('liste.index', ['listes' => $listes]); 
    }
    
    /**
     * Renvoi des données des listes de bouteilles de l'utilisateur au format JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexJSON()
    {
        $listes = Liste::withCount('bouteillesListes')
                            ->with('bouteillesListes.bouteille')
                            ->where('user_id', Auth::id())
                            ->get(); 

        $listes->each(function ($liste) {
            $liste->prixTotal = 0;
            $liste->quantiteTotal = 0;  
            foreach($liste->bouteillesListes as $bouteilleListe) {
                $liste->prixTotal += $bouteilleListe->bouteille->prix; 
                $liste->quantiteTotal += $bouteilleListe->quantite;
            }
        }); 
        
        return response()->json($listes); 
    }

    /**
     * Affichage du formulaire de création d'une liste.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('liste.create');
    }

    /**
     * Stockage d'une nouvelle liste de bouteilles pour l'utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            ['nom' => 'required|max:255|unique:listes,nom,NULL,id,user_id,' . Auth::id()],
            [
                'nom.required' => 'Le nom de de la liste est obligatoire.', 
                'nom.unique' => 'Vous avez déjà une liste avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newListe = Liste::create([
            'nom' => $request->nom, 
            'user_id' => Auth::id()
        ]);

        $newListe->save(); 

        return redirect(route('liste.index'))
        ->withSuccess('Liste ajoutée!'); 
    }

    /**
     * Affichage des détails d'une liste de bouteilles.
     *
     * @param \App\Models\Liste $liste_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(Liste $liste_id, Request $request)
    {
        $liste = $liste_id;

        $sort = $request->input('sort');
    
        if ($sort == 'name-asc') {
            $liste->bouteillesListes = $liste->bouteillesListes->sortBy('bouteille.nom');
        } elseif ($sort == 'name-desc') {
            $liste->bouteillesListes = $liste->bouteillesListes->sortByDesc('bouteille.nom');
        } elseif ($sort == 'price-asc') {
            $liste->bouteillesListes = $liste->bouteillesListes->sortBy('bouteille.prix');
        } elseif ($sort == 'price-desc') {
            $liste->bouteillesListes = $liste->bouteillesListes->sortByDesc('bouteille.prix');
        }

        foreach($liste->bouteillesListes as $bouteilleListe) {
            $liste->quantiteTotal += $bouteilleListe->quantite;
        }

        $celliers = Cellier::where('user_id', Auth::id())->get();
    
        return view('liste.show', ['liste' => $liste, 'celliers' => $celliers]);
    }

    /**
     * Affichage du formulaire d'édition d'une liste de bouteilles.
     *
     * @param int $liste_id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($liste_id)
    {
        $liste = Liste::findOrFail($liste_id); 
        if ($liste->nom != 'Favoris') {
            return view('liste.edit', ['liste' => $liste]); 
        }
        else {
            return redirect(route('liste.index')); 
        }
    }

    /**
     * Mise à jour des informations d'une liste de bouteilles.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $liste_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $liste_id)
    {
        $request->validate(
            [
                'nom' => ['required', 'max:255', Rule::unique('listes', 'nom')
                ->ignore($liste_id, 'id')
                ->where('user_id', Auth::id()),]
            ],
            [
                'nom.required' => 'Le nom de de la liste est obligatoire.', 
                'nom.unique' => 'Vous avez déjà une liste avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        Liste::findOrFail($liste_id)->update([
            'nom' => $request->nom
        ]);

        $liste = Liste::findOrFail($liste_id);

        return redirect(route('liste.show', ['liste_id' => $liste_id, 'liste' => $liste]))
        ->withSuccess('Liste modifiée!');
    }

    /**
     * Suppression d'une liste de bouteilles.
     *
     * @param int $liste_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($liste_id)
    {
        try {
            $liste = Liste::findOrFail($liste_id); 
            if ($liste->nom != 'Favoris') { 
                $liste->bouteillesListes()->delete(); 
                $liste->delete(); 
                return redirect(route('liste.index'))
                    ->withSuccess('Liste supprimée!'); 
            }
            else {
                return redirect(route('liste.index'))->with('error', 'Vous ne pouvez pas effacer la liste Favoris.'); 
            }
        }
        catch (\Exception $e) {
            return redirect(route('liste.index'))->with('error', 'La liste n\'existe pas'); 
        }
    }

    /**
     * Calcul du total des prix et quantités pour toutes les listes de bouteilles de l'utilisateur.
     *
     * @return array Tableau contenant le total en quantité et de prix de toutes listes confondues
     */
    public static function calculerTotalListe()
    {
        $listes = Liste::with('bouteillesListes.bouteille')
        ->where('user_id', Auth::id())
        ->get();

        $totalPrix = 0;
        $totalQuantite = 0;

        foreach ($listes as $liste) {
            foreach ($liste->bouteillesListes as $bouteilleListe) {
                $totalPrix += $bouteilleListe->bouteille->prix * $bouteilleListe->quantite;
                $totalQuantite += $bouteilleListe->quantite;
            }
        }

        return [
            'totalPrixListes' => $totalPrix,
            'totalQuantiteListes' => $totalQuantite
        ];
    }
}
