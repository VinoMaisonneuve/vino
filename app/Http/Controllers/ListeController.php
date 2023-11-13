<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('liste.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ['nom' => 'required|max:255'],
            [
                'nom.required' => 'Le nom de de la liste est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newListe = Liste::create([
            'nom' => $request->nom, 
            'user_id' => Auth::id()
        ]);

        $newListe->save(); 

        return redirect(route('liste.index')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function edit($liste_id)
    {
        $liste = Liste::findOrFail($liste_id); 

        return view('liste.edit', ['liste' => $liste]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $liste_id)
    {
        $request->validate(
            ['nom' => 'required|max:255'],
            [
                'nom.required' => 'Le nom de la liste est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        Liste::findOrFail($liste_id)->update([
            'nom' => $request->nom
        ]);

        return redirect(route('liste.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liste  $liste
     * @return \Illuminate\Http\Response
     */
    public function destroy($liste_id)
    {
        try {
            $liste = Liste::findOrFail($liste_id); 
            $liste->bouteillesListes()->delete(); 
            $liste->delete(); 
            return redirect(route('liste.index')); 
        }
        catch (\Exception $e) {
            return redirect(route('liste.index'))->with('error', 'La liste n\'existe pas'); 
        }
    }

    /**
     * Count the total price from a specific cellar.
     *
     * @return $totalPrix Total price
     * @return $totalBouteille Number of bottles
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
