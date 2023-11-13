<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BouteilleController extends Controller
{
    /**
     * Affiche la liste des bouteilles en page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bouteilles = Bouteille::paginate(7);
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


    // public function search(Request $request) {

    //     $searchTerm = $request->input('search');
    //     $bouteilles = Bouteille::where('nom', 'like', "%$searchTerm%")->paginate(3);
               
    //   return view('bouteille.show-search', ['bouteilles' => $bouteilles]);
    // }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    //     $page = $request->input('page', 1);
        
    //     $results = Bouteille::where('nom', 'LIKE', '%' . $query . '%')
    //                     ->paginate(7, ['*'], 'page', $page);

    //     $resultsHtml = view('partials.results', compact('results'))->render();
    //     $paginationHtml = view('partials.pagination', compact('results'))->render();

    //     return response()->json([
    //         'resultsHtml' => $resultsHtml,
    //         'paginationHtml' => $paginationHtml
    //     ]);
    // }

    // public function search(Request $request)
    // {
    //     $query = $request->input('search');
    //     // $category = $request->input('category');
    //     // $sort = $request->input('sort', 'name');
    //     // $direction = $request->input('direction', 'asc');
        

    //     // Commencez par la requête de base
    //     $bouteillesQuery = Bouteille::query();

    //     // Appliquez le filtre de recherche si un terme de recherche est fourni
    //     if (!empty($query)) {
    //         $bouteillesQuery->where('nom', 'like', "%{$query}%");
    //     }

    //     // Appliquez le filtre de catégorie si une catégorie est sélectionnée
    //     // if (!empty($category)) {
    //     //     $bouteillesQuery->where('category_id', $category);
    //     // }

    //     // Appliquez le tri
    //     // $bouteillesQuery->orderBy($sort, $direction);

    //     // Paginer les résultats
    //     $bouteilles = $bouteillesQuery->paginate(10);

    //     // Si la requête est une requête AJAX, retournez uniquement la vue partielle
    //     if ($request->ajax()) {
    //         return view('partials.bouteilles', ['bouteilles' => $bouteilles])->render();
    //     }

    //     // Sinon, retournez la vue complète
    //     return view('bouteille.index', ['bouteilles' => $bouteilles]);
    // }

    public function search(Request $request)
    {
        $bouteilles = Bouteille::paginate(7);
        $allHtml = view('partials.bouteilles', compact('bouteilles'))->render();

        $bouteillesQuery = Bouteille::query();

        $query = $request->input('search');
        $sortOption = $request->input('sort');

        // Recherche
        if (!empty($query)) {
            $bouteillesQuery->where('nom', 'LIKE', '%' . $query . '%');
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
        
        // // Paginer
        // $results = $bouteillesQuery->paginate(7);
        // $resultsHtml = view('partials.bouteilles', compact('results'))->render();
        // return response()->json(['resultsHtml' => $resultsHtml]);

        $page = $request->input('page');
        $results = $bouteillesQuery->paginate(7)->appends([
            'search' => $query,
            'sort' => $sortOption,
            'page' => $page,
        ]);
    
        $resultsHtml = view('partials.bouteilles', compact('results'))->render();
        return response()->json(['resultsHtml' => $resultsHtml]);

        // if (!empty($query)) {
        //     $results = Bouteille::where('nom', 'LIKE', '%' . $query . '%')->paginate(10);
        //     $resultsHtml = view('partials.bouteilles', compact('results'))->render();
        //     return response()->json(['resultsHtml' => $resultsHtml]);
        // }
        // else if ($query === "") {
        //     return response()->json(['resultsHtml' => $allHtml]);
        // }

        // return response()->json(['resultsHtml' => 'Aucun résultat trouvé']);
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
