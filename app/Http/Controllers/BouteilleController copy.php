<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BouteilleController extends Controller
{
    /**

     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bouteille  $bouteille
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bouteille = Bouteille::findOrFail($id);
        return view('bouteille.show', ['bouteille' => $bouteille]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bouteille  $bouteille
     * @return \Illuminate\Http\Response
     */
    public function edit(Bouteille $bouteille)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bouteille  $bouteille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bouteille $bouteille)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bouteille  $bouteille
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bouteille $bouteille)
    {
        //
    }




    public function index(Request $request)
    {
        $bouteillesQuery = Bouteille::query();
        $celliers = Cellier::where('user_id', Auth::id())->get();

        // Récupération des paramètres de recherche
        $nom = $request->input('search');
        $prix_min = $request->input('prix_min');
        $prix_max = $request->input('prix_max');
        $couleur = $request->input('couleur');
        $format = $request->input('format');
        $pays = $request->input('pays');
        $region = $request->input('region');
        $millesime = $request->input('millesime');
        $cepage = $request->input('cepage');

        // Application des filtres si les paramètres sont présents
        if (!empty($nom)) {
            $bouteillesQuery->where('nom', 'like', "%{$nom}%");
        }

        if (!empty($prix_min)) {
            $bouteillesQuery->where('prix', '>=', $prix_min);
        }

        if (!empty($prix_max)) {
            $bouteillesQuery->where('prix', '<=', $prix_max);
        }

        if (!empty($couleur)) {
            $bouteillesQuery->where('couleur', $couleur);
        }

        if (!empty($format)) {
            $bouteillesQuery->where('format', $format);
        }

        if (!empty($pays)) {
            $bouteillesQuery->where('pays', $pays);
        }

        if (!empty($region)) {
            $bouteillesQuery->where('region', $region);
        }

        if (!empty($millesime)) {
            $bouteillesQuery->where('millesime', $millesime);
        }

        if (!empty($cepage)) {
            $bouteillesQuery->where('cepage', $cepage);
        }

        // Ajout de la logique de tri
        $sort = $request->input('sort');
        if (!empty($sort)) {
            switch ($sort) {
                case 'name-asc':
                    $bouteillesQuery->orderBy('nom', 'asc');
                    break;
                case 'name-desc':
                    $bouteillesQuery->orderBy('nom', 'desc');
                    break;
                case 'price-asc':
                    $bouteillesQuery->orderBy('prix', 'asc');
                    break;
                case 'price-desc':
                    $bouteillesQuery->orderBy('prix', 'desc');
                    break;
                    // Ajoutez d'autres cas de tri au besoin
            }
        } else {
            // Si aucun tri n'est spécifié, tri par défaut
            $bouteillesQuery->orderBy('created_at', 'desc');
        }

        $bouteilles = $bouteillesQuery->paginate(10);

        // Récupération de champs de la base de données
        $couleurs = Bouteille::distinct()->pluck('couleur');
        $formats = Bouteille::distinct()->pluck('format');
        $lesPays = Bouteille::distinct()->pluck('pays');
        $regions = Bouteille::distinct()->pluck('region');
        $millesimes = Bouteille::distinct()->pluck('millesime');
        $cepages = Bouteille::distinct()->pluck('cepage');

        return view('bouteille.index', compact('bouteilles', 'couleurs', 'formats', 'lesPays', 'regions', 'millesimes', 'cepages', 'celliers'));
    }

}
