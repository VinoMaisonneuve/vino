<?php
namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\User;
use App\Models\Liste;
use App\Models\BouteilleCellier;
use App\Models\BouteilleListe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class StatistiqueController extends Controller
{
    /**
     * Affichage de la page des statistiques avec les utilisateurs, le nombre de celliers et de listes associés.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupération de tous les utilisateurs avec le nombre de celliers et de listes
        $query = User::withCount(['celliers', 'listes']);
        $usersWithCellierAndListeCount = $query->get();
    
        // Récupération des données pour la variable JavaScript
        $userData = $usersWithCellierAndListeCount->map(function ($user) {
            return [
                'id_key' => $user->id,
                'email_key' => $user->email,
                'celliers_count_key' => $user->celliers_count,
                'listes_count_key' => $user->listes_count ?? 0,
            ];
        });
    
        return view('admin.statistics.index', [
            'userData' => $userData,
        ]);
    }
    
    /**
     * Affichage des détails statistiques pour un utilisateur spécifique.
     *
     * @param  int $userId Identifiant de l'utilisateur
     * @return \Illuminate\View\View
     */
    public function detail($userId)
    {
        // Récupération de l'utilisateur avec son nom
        $user = User::find($userId);

        // Vérification de l'existence de l'utilisateur
        if (!$user) {
            abort(404); // Gestion de la non-existence de l'utilisateur
        }

        // Récupération des celliers de l'utilisateur avec la quantité de bouteilles pour chaque cellier
        $celliers = Cellier::where('user_id', $userId)->get();

        // Récupération des listes de l'utilisateur avec la quantité de bouteilles pour chaque liste
        $listes = Liste::where('user_id', $userId)->get();

        return view('admin.statistics.stats-user', [
            'user' => $user,
            'celliers' => $celliers,
            'listes' => $listes,
        ]);
    }

    /**
     * Affichage des statistiques regroupées pour tous les utilisateurs.
     *
     * @return \Illuminate\View\View
     */
    public function all()
    {
        // Récupération des statistiques de tous les utilisateurs avec le nombre de celliers et de listes
        $usersWithCellierAndListeCount = User::withCount(['celliers', 'listes'])->get();

        return view('admin.statistics.index', [
            'usersWithCellierAndListeCount' => $usersWithCellierAndListeCount,
        ]);
    }

    /**
     * Affichage des statistiques mensuelles agrégées pour tous les utilisateurs.
     *
     * @return \Illuminate\View\View
     */
    public function monthlyStatistics()
    {
        $currentDate = now();
        $currentMonth = $currentDate->month;

        // Obtention de la somme totale des bouteilles dans tous les celliers et toutes les listes
        $totalBottlesCount = BouteilleCellier::sum('quantite') + BouteilleListe::sum('quantite');

        $monthlyStatistics = User::whereYear('created_at', $currentDate->year)
            ->whereMonth('created_at', $currentMonth)
            ->withCount(['celliers', 'listes'])
            ->get()
            ->reduce(function ($carry, $user) use ($totalBottlesCount) {
                $carry['user_count'] += 1;
                $carry['celliers_count'] += $user->celliers->count();
                $carry['listes_count'] += $user->listes->count();
                $carry['total_bottles_count'] = $totalBottlesCount;

                return $carry;
            }, [
                'user_count' => 0,
                'celliers_count' => 0,
                'listes_count' => 0,
                'total_bottles_count' => 0,
            ]);

        return view('statistics.monthly', ['monthlyStatistics' => $monthlyStatistics]);
    }

}
