<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CellierController extends Controller
{
    /**
     * Affichage de la liste des celliers de l'utilisateur avec des informations sur les bouteilles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $celliers = Cellier::withCount(['bouteillesCelliers', 'bouteillesPersonnaliseesCelliers'])
                            ->with(['bouteillesCelliers.bouteille', 'bouteillesPersonnaliseesCelliers.bouteillePersonnalisee'])
                            ->where('user_id', Auth::id())
                            ->get();  

        $celliers->each(function ($cellier) {
            $cellier->prixTotal = 0; 
            $cellier->quantiteTotal = 0; 
            foreach($cellier->bouteillesCelliers as $bouteilleCellier) {
                $cellier->prixTotal += $bouteilleCellier->bouteille->prix * $bouteilleCellier->quantite;
                $cellier->quantiteTotal += $bouteilleCellier->quantite;
            }
            foreach ($cellier->bouteillesPersonnaliseesCelliers as $bouteillePersonnaliseeCellier) {
                if ($bouteillePersonnaliseeCellier->bouteillePersonnalisee->prix != null) {
                    $cellier->prixTotal  += $bouteillePersonnaliseeCellier->bouteillePersonnalisee->prix * $bouteillePersonnaliseeCellier->quantite;
                }
                $cellier->quantiteTotal += $bouteillePersonnaliseeCellier->quantite;
            }
        }); 
        
        return view('cellier.index', ['celliers' => $celliers]); 
    }
    
    /**
     * Renvoi des informations sur les celliers de l'utilisateur au format JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexJSON()
    {
        $celliers = Cellier::withCount('bouteillesCelliers')
                            ->with('bouteillesCelliers.bouteille')
                            ->where('user_id', Auth::id())
                            ->get(); 

        $celliers->each(function ($cellier) {
            $cellier->prixTotal = 0; 
            $cellier->quantiteTotal = 0; 
            foreach($cellier->bouteillesCelliers as $bouteilleCellier) {
                $cellier->prixTotal += $bouteilleCellier->bouteille->prix; 
                $cellier->quantiteTotal += $bouteilleCellier->quantite;
            }
        }); 
        return response()->json($celliers); 
    }

    /**
     * Affichage du formulaire de création d'un nouveau cellier.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cellier.create');
    }

    /**
     * Enregistrement d'un nouveau cellier pour l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            ['nom' => 'required|max:255|unique:celliers,nom,NULL,id,user_id,' . Auth::id()],
            [
                'nom.required' => 'Le nom du cellier est obligatoire.', 
                'nom.unique' => 'Vous avez déjà un cellier avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newCellier = Cellier::create([
            'nom' => $request->nom, 
            'user_id' => Auth::id()
        ]);

        $newCellier->save(); 

        return redirect(route('cellier.index'))
        ->withSuccess('Cellier ajouté!'); 
    }

    /**
     * Affichage des détails d'un cellier avec possibilité de tri des bouteilles.
     *
     * @param  \App\Models\Cellier  $cellier_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Cellier $cellier_id, Request $request)
    {
        $cellier = $cellier_id;

        $sort = $request->input('sort');
    
        if ($sort == 'name-asc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortBy('bouteille.nom');
            $cellier->bouteillesPersonnaliseesCelliers = $cellier->bouteillesPersonnaliseesCelliers->sortBy(function ($string) { return strtolower($string->bouteillePersonnalisee->nom); });
        } elseif ($sort == 'name-desc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortByDesc('bouteille.nom');
            $cellier->bouteillesPersonnaliseesCelliers = $cellier->bouteillesPersonnaliseesCelliers->sortByDesc(function ($string) { return strtolower($string->bouteillePersonnalisee->nom); });
        } elseif ($sort == 'price-asc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortBy('bouteille.prix');
            $cellier->bouteillesPersonnaliseesCelliers = $cellier->bouteillesPersonnaliseesCelliers->sortBy('bouteillePersonnalisee.prix');
        } elseif ($sort == 'price-desc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortByDesc('bouteille.prix');
            $cellier->bouteillesPersonnaliseesCelliers = $cellier->bouteillesPersonnaliseesCelliers->sortByDesc('bouteillePersonnalisee.prix');
        }

        foreach($cellier->bouteillesCelliers as $bouteilleCellier) {
            $cellier->quantiteTotal += $bouteilleCellier->quantite;
        }
        foreach($cellier->bouteillesPersonnaliseesCelliers as $bouteillePersonnaliseeCellier) {
            $cellier->quantiteTotalPersonnalisee += $bouteillePersonnaliseeCellier->quantite;
        }

        return view('cellier.show', ['cellier' => $cellier]);
    }

    /**
     * Affichage du formulaire d'édition d'un cellier.
     *
     * @param  int  $cellier_id Identifiant du cellier à éditer
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($cellier_id)
    {
        $cellier = Cellier::findOrFail($cellier_id); 
        if ($cellier->nom != 'Favoris') {
            return view('cellier.edit', ['cellier' => $cellier]); 
        }
        else {
            return redirect(route('cellier.index')); 
        }
    }

    /**
     * Mise à jour des informations d'un cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cellier_id Identifiant du cellier à mettre à jour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cellier_id)
    {
        $request->validate(
            [
                'nom' => ['required', 'max:255', Rule::unique('celliers', 'nom')
                ->ignore($cellier_id, 'id')
                ->where('user_id', Auth::id()),]
            ],
            [
                'nom.required' => 'Le nom du cellier est obligatoire.', 
                'nom.unique' => 'Vous avez déjà un cellier avec ce nom.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        Cellier::findOrFail($cellier_id)->update([
            'nom' => $request->nom
        ]);

        $cellier = Cellier::findOrFail($cellier_id);

        return redirect(route('cellier.show', ['cellier_id' => $cellier_id, 'cellier' => $cellier]))
        ->withSuccess('Cellier modifié!');
    }

    /**
     * Suppression d'un cellier et de ses relations associées.
     *
     * @param  int  $cellier_id Identifiant du cellier à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cellier_id)
    {
        try {
            $cellier = Cellier::findOrFail($cellier_id); 
            if ($cellier->nom != 'Favoris') {
                $cellier->bouteillesCelliers()->delete(); 
                $cellier->bouteillesPersonnaliseesCelliers()->delete(); 
                $cellier->delete(); 
                return redirect(route('cellier.index'))
                ->withSuccess('Cellier supprimé!'); 
            }
            else {
                return redirect(route('cellier.index'))->with('error', 'Vous ne pouvez pas effacer le cellier Favoris.'); 
            }
        }
        catch (\Exception $e) {
            return redirect(route('cellier.index'))->with('error', 'Le cellier n\'existe pas'); 
        }
    }

    /**
     * Calcul du total du prix et de la quantité de toutes les bouteilles dans les celliers de l'utilisateur.
     *
     * @return array Tableau associatif contenant le total du prix et de la quantité des bouteilles dans les celliers
     */
    public static function calculerTotalCellier()
    {
        $celliers = Cellier::with(['bouteillesCelliers.bouteille', 'bouteillesPersonnaliseesCelliers.bouteillePersonnalisee'])
        ->where('user_id', Auth::id())
        ->get();

        $totalPrix = 0;
        $totalQuantite = 0;

        foreach ($celliers as $cellier) {
            foreach ($cellier->bouteillesCelliers as $bouteilleCellier) {
                $totalPrix += $bouteilleCellier->bouteille->prix * $bouteilleCellier->quantite;
                $totalQuantite += $bouteilleCellier->quantite;
            }
            foreach ($cellier->bouteillesPersonnaliseesCelliers as $bouteillePersonnaliseeCellier) {
                if ($bouteillePersonnaliseeCellier->bouteillePersonnalisee->prix != null) {
                    $totalPrix += $bouteillePersonnaliseeCellier->bouteillePersonnalisee->prix * $bouteillePersonnaliseeCellier->quantite;
                }
                $totalQuantite += $bouteillePersonnaliseeCellier->quantite;
            }
        }

        return [
            'totalPrixCelliers' => $totalPrix,
            'totalQuantiteCelliers' => $totalQuantite
        ];
    }

}
