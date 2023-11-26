<?php

namespace App\Http\Controllers;

use App\Models\CommentaireBouteillePersonnalisee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireBouteillePersonnaliseeController extends Controller
{
    /**
     * Stocke un nouveau commentaire pour une bouteille personnalisée.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $cellier_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $cellier_id)
    {
        $request->validate([
            'comment'  => 'required|min:2'
        ],
        [
            'comment.required'  => 'Veuillez saisir votre commentaire',
            'comment.min'       => 'Votre commentaire doit contenir au moins 2 caractères'
        ]);

        $bouteille_id = $request->route('bouteille_personnalisee_id');
        $commentaire = new CommentaireBouteillePersonnalisee();
        $commentaire->corps = $request->input('comment');
        $commentaire->bouteille_id = $bouteille_id;
        $commentaire->user_id = Auth::user()->id;
        $commentaire->save();

        $commentaire = CommentaireBouteillePersonnalisee::find($commentaire->id);

        return redirect()->route('personnalisee.show', ['cellier_id' => $cellier_id, 'bouteille_id' => $bouteille_id])
            ->with('successMessage', 'Commentaire ajouté!')
            ->with('commentaire', $commentaire);
    }

    /**
     * Mise à jour d'un commentaire de bouteille personnalisée.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CommentaireBouteillePersonnalisee $commentaire_bouteille_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CommentaireBouteillePersonnalisee $commentaire_bouteille_id)
    {
        $request->validate([
            'comment'  => 'required|min:2'
        ],
        [
            'comment.required'  => 'Veuillez saisir votre commentaire',
            'comment.min'       => 'Votre commentaire doit contenir au moins 2 caractères'
        ]);

        try {
            $commentaire_bouteille_id->update([
                'corps' => $request->comment
            ]);
    
            return redirect()->back()->with('successMessage', 'Commentaire modifié!')
            ->with('commentaire', $commentaire_bouteille_id);;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du commentaire"]);
        }
    }

    /**
     * Suppression d'un commentaire de bouteille personnalisée.
     *
     * @param \App\Models\CommentaireBouteillePersonnalisee $commentaire_bouteille_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CommentaireBouteillePersonnalisee $commentaire_bouteille_id)
    {
        try {

            $commentaire_bouteille_id->delete();

            return redirect()->back()->withSuccess('Commentaire supprimé!');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la suppression du commentaire"]);
        }
    }
}
