<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BouteilleCellierController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;



// Route d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {

    // *************** Connexion (redirection) ****************
    Route::get('/', [CustomAuthController::class, 'index'])->name('welcome');

    // *************** Déconnexion ****************
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
    // *************** Ajout de la route /cellier ****************
    Route::get('/cellier', [CellierController::class, 'index'])->name('cellier.index');
    

    // *************** Gestion du profil ****************

    // Affichage du profil de l'utilisateur
    Route::get('/profil/{utilisateur_id}', [CustomAuthController::class, 'show'])->name('profil.show');
    // Modification du profil de l'utilisateur
    Route::get('/profil-modifier/{utilisateur_id}', [CustomAuthController::class, 'edit'])->name('profil.edit');
    // Stockage de la modification du profil de l'utilisateur
    Route::put('/profil-modifier/{utilisateur_id}', [CustomAuthController::class, 'update']);
    // Suppression d'un profil
    Route::delete('/profil-modifier/{utilisateur_id}', [CustomAuthController::class, 'destroy'])->name('profil.destroy');

    // *************** Gestion des bouteilles ****************

    // Affichage de toutes les bouteilles
    Route::get('/bouteilles', [BouteilleController::class, 'index'])->name('bouteille.index');
    // Affichage des informations d'une bouteille 
    Route::get('/bouteilles/{bouteille_id}', [BouteilleController::class, 'show'])->name('bouteille.show');
    // Création d'une bouteille personnalisée
    Route::get('/bouteilles-ajouter/{bouteille_id}', [BouteilleController::class, 'create'])->name('bouteille.create');
    // Stockage d'une bouteille personnalisée dans la BDD
    Route::post('/bouteilles-ajouter', [BouteilleController::class, 'store']);
    // Modification d'une bouteille personnalisée 
    Route::get('/bouteilles-modifier/{bouteille_id}', [BouteilleController::class, 'edit'])->name('bouteille.edit');
    // Stockage de la modification d'une bouteille personnalisée dans la BDD
    Route::put('/bouteilles-modifier/{bouteille_id}', [BouteilleController::class, 'update']);
    // Suppression d'une bouteille personnalisée
    Route::delete('/bouteilles-modifier/{bouteille_id}', [BouteilleController::class, 'destroy'])->name('bouteille.destroy');

    // *************** Gestion des celliers ****************

    // Affichage de tous les celliers
    Route::get('/celliers', [CellierController::class, 'index'])->name('cellier.index'); 
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

    // Ajout d'une bouteille à un cellier
    Route::post('/celliers/{cellier_id}/bouteilles/{bouteille_id}', [BouteilleController::class, 'ajouterAuCellier'])->name('bouteilles.ajouterCellier');
    // Retrait d'une bouteille d'un cellier
    Route::delete('/bouteilles/{id}', [BouteilleController::class, 'retirerDuCellier'])->name('bouteilles.retirerCellier');
    // Modification de la quantité de bouteilles se trouvant dans un même cellier
    Route::put('/celliers/{cellier_id}/bouteilles/{bouteille_id}', [BouteilleController::class, 'modifierQuantiteCellier'])->name('bouteilles.modifierQuantiteCellier');

    // *************** Gestion des listes ****************

    // Affichage de toutes les listes
    Route::get('/listes', [ListeController::class, 'index'])->name('liste.index'); 
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

    // Ajout d'une bouteille à une liste
    Route::post('/listes/{liste_id}/bouteilles/{bouteille_id}', [BouteilleController::class, 'ajouterAListe'])->name('bouteilles.ajouterListe');
    // Retrait d'une bouteille d'une liste
    Route::delete('/bouteilles/{id}', [BouteilleController::class, 'retirerDeListe'])->name('bouteilles.retirerListe');
    // Modification de la quantité de bouteilles se trouvant dans une même liste
    Route::put('/listes/{liste_id}/bouteilles/{bouteille_id}', [BouteilleController::class, 'modifierQuantiteListe'])->name('bouteilles.modifierQuantiteListe');

    // Anciennes routes de gestion des bouteilles 
    // Route::get('/bouteilles/search', [BouteilleController::class, 'search'])->name('bouteilles.search');
    // Route::get('/bouteilles/addBouteilleSearch/{id}', [BouteilleController::class, 'addBouteilleSearch'])->name('bouteilles.addBouteilleSearch');

    // Anciennes routes des bouteilles d'un cellier
    // Route::get('/Ajouter-bouteilles/{cellier_id}', [BouteilleController::class, 'index'])->name('Ajouter-bouteilles');
    // Route::get('/Ajouter-bouteille-manuellement/{cellier_id}', [BouteilleController::class, 'AjouterbouteilleManuellement'])->name('Ajouter-bouteille-manuellement');
    // Route::post('/addBouteilleManuellementPost', [BouteilleController::class, 'addBouteilleManuellementPost'])->name('addBouteilleManuellementPost');
    // Route::post('/bouteilles/addBouteille/{id}', [BouteilleController::class, 'addBouteille'])->name('bouteilles.addBouteille');
    // Route::delete('/bouteilles/{id}', [BouteilleController::class, 'destroy'])->name('bouteilles.destroy');
    // Route::get('/mon-cellier', [CellierController::class, 'index'])->name('mon-cellier');
    // Route::get('/celliers/{cellier_id}', [BouteilleCellierController::class, 'index'])->name('celliers.show'); 

    // Pour modifier la quantité d'une bouteille dans un cellier
    // Route::get('/modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierBouteille'])->name('modifier-Qte');
    // Route::post('/modifierQte/{bouteille_id}', [BouteilleController::class, 'modifierQteBouteille'])->name('modifier-Qte');

    // Recherche de bouteilles pour le footer
    // Route::get('/bouteilles/rechercheFooterBouteille', [BouteilleController::class, 'rechercheFooterBouteille'])->name('bouteilles.rechercheFooterBouteille');
    // Route::post('/bouteilles/rechercheFooterBouteillePost', [BouteilleController::class, 'indexRecherche'])->name('bouteilles.rechercheFooterBouteillePost');

    // Redirection vers HomeController après authentification
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
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
// Importer data de la SAQ
Route::get('/scrape', [Web2scraperController::class, 'scrapeData']);
//Route::get('/register', [CustomAuthController::class, 'create'])->name('register');

//Route::get('/register', [UserController::class, 'create'])->name('register');

//Route::get('/register', 'UserController@showRegistrationForm')->name('register');
//Route::get('/admin/dashboard', 'AdminController@dashboard')->middleware(['auth', 'role:Administrateur']);









