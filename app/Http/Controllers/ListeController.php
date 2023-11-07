<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importez la classe DB pour effectuer des requêtes SQL

class ListeController extends Controller
{
    // Affiche la liste des éléments
    public function index()
    {
        $listes = DB::select('SELECT * FROM listes'); // Remplacez 'listes' par le nom de votre table de listes
        return view('liste.index', ['listes' => $listes]);
    }

    // Affiche le formulaire de création de liste
    public function create()
    {
        return view('liste.create');
    }

    // Enregistre une nouvelle liste
    public function store(Request $request)
    {
        // Code pour valider et enregistrer la nouvelle liste
        // Vous devrez insérer les données directement dans la table listes
        // Exemple : DB::insert('INSERT INTO listes (champ1, champ2) VALUES (?, ?)', [$valeur1, $valeur2]);

        return redirect()->route('liste.index');
    }

    // Affiche une liste spécifique
    public function show($id)
    {
        // Code pour récupérer et afficher une liste spécifique
        return view('liste.show');
    }

    // Affiche le formulaire de modification de liste
    public function edit($id)
    {
        // Code pour récupérer et afficher le formulaire de modification
        return view('liste.edit');
    }

    // Met à jour une liste existante
    public function update(Request $request, $id)
    {
        // Code pour valider et mettre à jour la liste
        // Vous devrez mettre à jour les données directement dans la table listes
        // Exemple : DB::update('UPDATE listes SET champ1 = ?, champ2 = ? WHERE id = ?', [$nouvelleValeur1, $nouvelleValeur2, $id]);

        return redirect()->route('liste.index');
    }

    // Supprime une liste
    public function destroy($id)
    {
        // Code pour supprimer une liste
        // Vous devrez supprimer la ligne correspondante dans la table listes
        // Exemple : DB::delete('DELETE FROM listes WHERE id = ?', [$id]);

        return redirect()->route('liste.index');
    }
}
