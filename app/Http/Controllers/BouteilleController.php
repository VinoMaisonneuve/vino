<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Utiliser Log quand on ne peut débug avec var_dump (à cause de return JSON)
// ex. Log::info('Information des couleurs', ['couleurs' => $couleurs]);
// use Illuminate\Support\Facades\Log; 

class BouteilleController extends Controller
{
    /**
     * Affiche la liste des bouteilles en page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bouteilles = Bouteille::orderBy('nom')->paginate(7)->onEachSide(2);
                        
        $celliers = Cellier::where('user_id', Auth::id())->get();
        
        // Récupérer les filtres distincts sans valeurs nulles et en ordre alphabétique
        $couleurs = Bouteille::whereNotNull('couleur')->distinct()->orderBy('couleur', 'asc')->pluck('couleur');
        $pays = Bouteille::whereNotNull('pays')->distinct()->orderBy('pays', 'asc')->pluck('pays');
        $formats = Bouteille::whereNotNull('format')->distinct()->orderBy('format', 'asc')->pluck('format');
        $designations = Bouteille::whereNotNull('designation')->distinct()->orderBy('designation', 'asc')->pluck('designation');
        $producteurs = Bouteille::whereNotNull('producteur')->distinct()->orderBy('producteur', 'asc')->pluck('producteur');
        $agentPromotions = Bouteille::whereNotNull('agentPromotion')->distinct()->orderBy('agentPromotion', 'asc')->pluck('agentPromotion');
        $types = Bouteille::whereNotNull('type')->distinct()->orderBy('type', 'asc')->pluck('type');
        $millesimes = Bouteille::whereNotNull('millesime')->distinct()->orderBy('millesime', 'asc')->pluck('millesime');
        $cepages = Bouteille::whereNotNull('cepage')->distinct()->orderBy('cepage', 'asc')->pluck('cepage');
        $regions = Bouteille::whereNotNull('region')->distinct()->orderBy('region', 'asc')->pluck('region');
        
        // Récupérer le prix le plus élevé
        $prixMax = Bouteille::max('prix');

        // Récupérer le prix le plus bas
        $prixMin = Bouteille::min('prix');

    
        return view('bouteille.index', [
            'bouteilles'=> $bouteilles, 
            'celliers' => $celliers,
            'couleurs' => $couleurs,
            'pays' => $pays,
            'formats' => $formats,
            'designations' => $designations,
            'producteurs' => $producteurs,
            'agentPromotions' => $agentPromotions,
            'types' => $types,
            'millesimes' => $millesimes,
            'cepages' => $cepages,
            'regions' => $regions,
            'prixMax' => $prixMax,
            'prixMin' => $prixMin,
        ]);
    }    

    public function search(Request $request)
    {
        // Initialisation de la requête
        // $bouteillesQuery = DB::table('bouteilles');

        $bouteilles = Bouteille::paginate(7);
        $allHtml = view('partials.bouteilles', compact('bouteilles'))->render();

        $bouteillesQuery = Bouteille::query();

        $query = $request->input('search');
        $sortOption = $request->input('sort');

        // Recherche
        if (!empty($query)) {
            $bouteillesQuery->where('nom', 'LIKE', '%' . $query . '%');
        }


        // Filtres
        $selectors = ['couleur', 'pays', 'format', 'designation', 'producteur', 'agentPromotion', 'type', 'millesime', 'cepage', 'region'];

        foreach ($selectors as $selector) {
            $value = $request->input($selector);

            if (!empty($value)) {
                // Si la valeur est un string avec des valeurs séparées par des virgules, la convertir en array
                if (is_string($value)) {
                    $value = explode(',', $value);
                }

                // Si c'est un array
                if (is_array($value)) {
                    $bouteillesQuery->whereIn($selector, $value);
                } else {
                    $bouteillesQuery->where($selector, $value);
                }
            }
        }

        // Trier
        if (!empty($sortOption)) {
            switch ($sortOption) {
                case 'price-asc':
                    $bouteillesQuery->orderBy('prix', 'asc');
                    break;
                case 'price-desc':
                    $bouteillesQuery->orderBy('prix', 'desc');
                    break;
                case 'name-asc':
                    $bouteillesQuery->orderBy('nom', 'asc');
                    break;
                case 'name-desc':
                    $bouteillesQuery->orderBy('nom', 'desc');
                    break;
            }
        }

        $page = $request->input('page');
        $results = $bouteillesQuery->paginate(7)->appends([
            'search' => $query,
            'sort' => $sortOption,
            'page' => $page,
        ]);
    
        $resultsHtml = view('partials.bouteilles', compact('results'))->render();
        return response()->json(['resultsHtml' => $resultsHtml]);
    }



    public function sorting (Request $request) {

        $sort = $request->input('sort');
        switch ($sort) {
            case 'price-asc':
                $bouteilles = Bouteille::orderBy('prix', 'asc')->paginate(3);
                break;
            case 'price-desc':
                $bouteilles = Bouteille::orderBy('prix', 'desc')->paginate(3);
                break;
            case 'name-asc':
                $bouteilles = Bouteille::orderBy('nom', 'asc')->paginate(3);
                break;
            case 'name-desc':
                $bouteilles = Bouteille::orderBy('nom', 'desc')->paginate(3);
                break;
            default:
                $bouteilles = Bouteille::all();
                break;
        }
        return view('bouteille.show-sorting', compact('bouteilles'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bouteille.create');
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
        return view('bouteille.show', ['bouteille'=> $bouteille]);
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
}
