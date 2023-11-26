<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use App\Models\CommentaireBouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BouteilleController extends Controller
{
    /**
     * Affichage de la liste des bouteilles avec des filtres et des informations supplémentaires.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bouteilles = Bouteille::orderBy('nom')->paginate(25)->onEachSide(2);
                        
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

    /**
     * Exécution d'une recherche avancée de bouteilles en fonction des critères spécifiés.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $bouteilles = Bouteille::paginate(25);
        $allHtml = view('partials.bouteilles', compact('bouteilles'))->render();

        $bouteillesQuery = Bouteille::query();

        $query = $request->input('search');
        $sortOption = $request->input('sort');

        // Recherche
        if (!empty($query)) {
            $bouteillesQuery->where('nom', 'LIKE', '%' . $query . '%');
        }

        // Prix
        if ($prixMin = $request->input('prix-min')) {
            $bouteillesQuery->where('prix', '>=', $prixMin);
        }
        if ($prixMax = $request->input('prix-max')) {
            $bouteillesQuery->where('prix', '<=', $prixMax);
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
        $results = $bouteillesQuery->paginate(25)->appends([
            'search' => $query,
            'sort' => $sortOption,
            'page' => $page,
        ]);
    
        $resultsHtml = view('partials.bouteilles', compact('results'))->render();
        return response()->json(['resultsHtml' => $resultsHtml]);
    }

    /**
     * Affichage du formulaire de création d'une nouvelle bouteille.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('bouteille.create');
    }

    /**
     * Affichage des détails d'une bouteille spécifique.
     *
     * @param int $id L'identifiant de la bouteille.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bouteille = Bouteille::findOrFail($id);
        $celliers = Cellier::where('user_id', Auth::id())->get();
        $commentaire = CommentaireBouteille::where('user_id', Auth::id())
        ->where('bouteille_id', $id)
        ->first();
        return view('bouteille.show', ['bouteille'=> $bouteille, 'celliers' => $celliers, 'commentaire' => $commentaire]);
    }
}
