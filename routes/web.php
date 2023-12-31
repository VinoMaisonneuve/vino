<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BouteilleCellierController;
use App\Http\Controllers\BouteilleListeController;
use App\Http\Controllers\BouteillePersonnaliseeController;
use App\Http\Controllers\BouteillePersonnaliseeCellierController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\Web2scraperController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\CommentaireBouteilleController;
use App\Http\Controllers\CommentaireBouteillePersonnaliseeController;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Middleware\CheckRole;

// Route d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {

    // *************** Connexion (redirection) ****************

    Route::get('/', [CustomAuthController::class, 'index'])->name('welcome');

    // *************** Déconnexion ****************

    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // *************** Gestion du profil ****************

    // Affichage du profil de l'utilisateur
    Route::get('/profil/{user}', [CustomAuthController::class, 'show'])->name('profil.show');
    // Modification du profil de l'utilisateur
    Route::get('/profil-modifier/{user}', [CustomAuthController::class, 'edit'])->name('profil.edit');
    // Stockage de la modification du profil de l'utilisateur
    Route::put('/profil-modifier/{user}', [CustomAuthController::class, 'update']);
    // Changement de mot de passe de l'utilisateur
    Route::get('/profil/changer-mdp/{user}', [CustomAuthController::class, 'changePassword'])->name('profil.change-password');
    // Stockage du changement de mot de passe de l'utilisateur
    Route::put('/profil/changer-mdp/{user}', [CustomAuthController::class, 'stockNewPassword']);
    // Suppression d'un profil
    Route::delete('/profil-modifier/{user}', [CustomAuthController::class, 'destroy'])->name('profil.destroy');

    // *************** Gestion des bouteilles ****************
    
    Route::get('/scrape', [Web2scraperController::class, 'scrapeData']);
    // Affichage de toutes les bouteilles
    Route::get('/bouteilles', [BouteilleController::class, 'index'])->name('bouteille.index');
    // Affichage des informations d'une bouteille 
    Route::get('/bouteilles/{bouteille_id}', [BouteilleController::class, 'show'])->name('bouteille.show');
    // Affichage des informations d'une bouteille personnalisée
    Route::get('/celliers/{cellier_id}/bouteilles-personnalisees/{bouteille_id}', [BouteillePersonnaliseeController::class, 'show'])->name('personnalisee.show');
    // Création d'une bouteille personnalisée
    Route::get('/celliers/{cellier_id}/bouteilles-ajouter', [BouteillePersonnaliseeController::class, 'create'])->name('bouteille.create');
    // Stockage d'une bouteille personnalisée dans la BDD
    Route::post('/celliers/{cellier_id}/bouteilles-ajouter', [BouteillePersonnaliseeController::class, 'store'])->name('bouteille.store');
    // Ajout d'une bouteille personnalisée dans un cellier
    Route::post('/celliers/{cellier_id}/bouteilles-ajouter-cellier', [BouteillePersonnaliseeCellierController::class, 'store'])->name('bouteillePersonnalisee.store');
    // Modification d'une bouteille personnalisée 
    Route::get('/celliers/{cellier_id}/bouteilles-personnalisees-modifier/{bouteille_id}', [BouteillePersonnaliseeController::class, 'edit'])->name('bouteille.edit');
    // Stockage de la modification d'une bouteille personnalisée dans la BDD
    Route::put('/celliers/{cellier_id}/bouteilles-personnalisees-modifier/{bouteille_id}', [BouteillePersonnaliseeController::class, 'update']);
    // Suppression d'une bouteille personnalisée
    Route::delete('/celliers/{cellier_id}/bouteilles-personnalisees-modifier/{bouteille_id}', [BouteillePersonnaliseeController::class, 'destroy'])->name('bouteillePersonnalisee.destroy');
    // Suppression d'une bouteille personnalisée d'un cellier
    Route::delete('/celliers/{cellier_id}/bouteilles-modifier/{bouteille_personnalisee_cellier}', [BouteillePersonnaliseeCellierController::class, 'destroy'])->name('bouteille.destroy');
    // Recherche d'une bouteille
    Route::get('/search', [BouteilleController::class, 'search']);

    // *************** Commentaires ****************

    // Stockage du commentaire sur une bouteille de la saq
    Route::post('/commentaires/{bouteille_id}', [CommentaireBouteilleController::class, 'store'])->name('comment.store');
    // Stockage de la modification d'un commentaire sur une bouteille de la saq dans la BDD
    Route::put('/commentaires-modifier/{commentaire_bouteille}', [CommentaireBouteilleController::class, 'update'])->name('comment.update');
    // Suppression d'un commentaire sur une bouteille de la saq
    Route::delete('/commentaires-modifier/{commentaire_bouteille}', [CommentaireBouteilleController::class, 'destroy'])->name('comment.destroy');
    // Stockage du commentaire sur une bouteille personnalisée
    Route::post('/celliers/{cellier_id}/commentaires/{bouteille_personnalisee_id}', [CommentaireBouteillePersonnaliseeController::class, 'store'])->name('commentPersonnalisee.store');
    // Stockage de la modification d'un commentaire sur une bouteille personnalisée dans la BDD
    Route::put('/commentaires-personnalisees-modifier/{commentaire_bouteille_id}', [CommentaireBouteillePersonnaliseeController::class, 'update'])->name('commentP.update'); 
    // Suppression d'un commentaire sur une bouteille personnalisée
    Route::delete('/commentaires-personnalisees-modifier/{commentaire_bouteille_id}', [CommentaireBouteillePersonnaliseeController::class, 'destroy'])->name('commentP.destroy');

    // *************** Gestion des celliers ****************

    // Affichage de tous les celliers
    Route::get('/celliers', [CellierController::class, 'index'])->name('cellier.index'); 
    // Affichage de tous les celliers en JSON
    Route::get('/celliers-json', [CellierController::class, 'indexJSON']); 
    // Affichage d'un cellier et de ses bouteilles
    Route::get('/celliers/{cellier_id}/bouteilles', [CellierController::class, 'show'])->name('cellier.show');
    // Création d'un cellier
    Route::get('/celliers-ajouter', [CellierController::class, 'create'])->name('cellier.create');
    // Stockage d'un cellier dans la BDD
    Route::post('/celliers-ajouter', [CellierController::class, 'store']);
    // Modification d'un cellier 
    Route::get('/celliers-modifier/{cellier_id}', [CellierController::class, 'edit'])->name('cellier.edit');
    // Stockage de la modification d'un cellier dans la BDD
    Route::put('/celliers-modifier/{cellier_id}', [CellierController::class, 'update']);
    // Suppression d'un cellier
    Route::delete('/celliers-modifier/{cellier_id}', [CellierController::class, 'destroy'])->name('cellier.destroy');

    // *************** Gestion des bouteilles d'un cellier ****************

    // Redirection vers l'ajout d'une bouteille à partir d'un cellier
    Route::get('/celliers/{cellier_id}/bouteilles-celliers-modifier', [BouteilleController::class, 'index'])->name('ajout.index');
    // Ajout d'une bouteille à un cellier
    Route::post('/celliers-json', [BouteilleCellierController::class, 'store']);
    // Retrait d'une bouteille d'un cellier
    Route::delete('/celliers/{cellier_id}/bouteilles-celliers-modifier/{bouteille_cellier}', [BouteilleCellierController::class, 'destroy'])->name('bouteilleCellier.delete');
    // Modification de la quantité de bouteilles se trouvant dans un même cellier
    Route::put('/bouteilles-celliers-modifier/{id}', [BouteilleCellierController::class, 'update']);
    // Modification de la quantité de bouteilles personnalisées se trouvant dans un même cellier
    Route::put('/bouteilles-personnalisees-celliers-modifier/{id}', [BouteillePersonnaliseeCellierController::class, 'update']);

    // *************** Gestion des listes ****************

    // Affichage de toutes les listes
    Route::get('/listes', [ListeController::class, 'index'])->name('liste.index'); 
    // Affichage de tous les celliers en JSON
    Route::get('/listes-json', [ListeController::class, 'indexJSON']); 
    // Affichage d'une liste et de ses bouteilles
    Route::get('/listes/{liste_id}/bouteilles', [ListeController::class, 'show'])->name('liste.show');
    // Création d'une liste
    Route::get('/listes-ajouter', [ListeController::class, 'create'])->name('liste.create');
    // Stockage d'une liste dans la BDD
    Route::post('/listes-ajouter', [ListeController::class, 'store']);
    // Modification d'une liste 
    Route::get('/listes-modifier/{liste_id}', [ListeController::class, 'edit'])->name('liste.edit');
    // Stockage de la modification d'une liste dans la BDD
    Route::put('/listes-modifier/{liste_id}', [ListeController::class, 'update']);
    // Suppression d'une liste
    Route::delete('/listes-modifier/{liste_id}', [ListeController::class, 'destroy'])->name('liste.destroy');

    // *************** Gestion des bouteilles d'une liste ****************

    // Redirection vers l'ajout d'une bouteille à partir d'une liste
    Route::get('/listes/{liste_id}/bouteilles-listes-modifier', [BouteilleController::class, 'index'])->name('ajoutListe.index');
    // Ajout d'une bouteille à une liste
    Route::post('/listes-json', [BouteilleListeController::class, 'store']);
    // Retrait d'une bouteille d'une liste
    Route::delete('/listes/{liste_id}/bouteilles-listes-modifier/{bouteille_liste}', [BouteilleListeController::class, 'destroy'])->name('bouteilleListe.delete');
    // Modification de la quantité de bouteilles se trouvant dans une même liste
    Route::put('/bouteilles-listes-modifier/{id}', [BouteilleListeController::class, 'update']);

    // *************** Admin ****************

    Route::middleware('role:Admin')->group(function () {
        // Affichage de tous les utilisateurs
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.index');
        // Recherche d'un utilisateur dans la liste par nom ou par id
        Route::get('/admin/search-users', [AdminController::class, 'searchUsers'])->name('admin.search-users');
        // Affichage d'un utilisateur
        Route::get('/admin/users-show/{user}', [AdminController::class, 'show'])->name('admin.show-user');
        // Création d'un nouvel utilisateur
        Route::get('/admin/users-create', [AdminController::class, 'create'])->name('admin.create-user');
        // Stockage d'un nouvel utilisateur dans la BDD
        Route::post('/admin/users-create', [AdminController::class, 'store']);
        // Modification d'un utilisateur
        Route::get('/admin/users-edit/{user}', [AdminController::class, 'edit'])->name('admin.edit-user');
        // Stockage de la modification d'un utilisateur dans la BDD
        Route::put('/admin/users-edit/{user}', [AdminController::class, 'update']);
        // Suppression d'un utilisateur
        Route::delete('/admin/users-delete/{user}', [AdminController::class, 'destroy'])->name('admin.destroy-user');
        // Affichage des statistiques de tous les utilisateurs
        Route::get('/statistics', [StatistiqueController::class, 'index'])->name('statistics.stats-users');
        // Affichage des statistiques par utilisateur
        Route::get('/statistics-details/{user}', [StatistiqueController::class, 'detail'])->name('statistics.stats-user');
        // Affichage de toutes les statistiques, catégories confondues
        Route::get('/statistics-all', [StatistiqueController::class, 'all'])->name('statistics.index');
        // Affichage des statistiques par mois
        Route::get('/statistics-monthly', [StatistiqueController::class, 'monthlyStatistics'])->name('statistics.monthly');
    });

});

// *************** Authentification ****************

// Page de connexion
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
// Connexion
Route::post('/login', [CustomAuthController::class, 'authentication'])->name('login.authentication');
// Création d'un nouvel utilisateur
Route::get('/register', [CustomAuthController::class, 'create'])->name('register');
// Stockage d'un nouvel utilisateur dans la BDD
Route::post('/register', [CustomAuthController::class, 'store'])->name('register.store');
// Affichage du formulaire d'oubli de mot de passe
Route::get('forgot-password', [CustomAuthController::class, 'forgotPassword'])->name
('password.forgot');;
// Envoi du formulaire d'oubli de mot de passe
Route::post('forgot-password', [CustomAuthController::class, 'tempPassword'])->name
('password.temp');
// Affichage du formulaire de nouveau mot de passe
Route::get('new-password/{user}/{tempPassword}', [CustomAuthController::class,
'newPassword']);
// Envoi du formulaire de nouveau mot de passe
Route::post('new-password/{user}/{tempPassword}', [CustomAuthController::class,
'storeNewPassword']);
// Affichage du formulaire de signalement de problème
Route::get('/signaler-erreur', [CustomAuthController::class, 'formulaireSignalerErreur'])->name('signalerErreur');
// Envoi du formulaire de signalement de problème
Route::post('/signaler-erreur', [CustomAuthController::class, 'signalerErreur'])->name('signalerErreur');


// *************** Importation des données de la SAQ ****************

Route::get('/scrape', [Web2scraperController::class, 'scrapeData']);

