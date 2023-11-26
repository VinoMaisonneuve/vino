<?php

namespace App\Http\Controllers;

use App\Models\CommentaireBouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireBouteilleController extends Controller
{
    /**
     * Enregistrement d'un nouveau commentaire pour une bouteille de la SAQ.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment'  => 'required|min:2'
        ],
        [
            'comment.required'  => 'Veuillez saisir votre commentaire',
            'comment.min'       => 'Votre commentaire doit contenir au moins 2 caractères'
        ]);

        $bouteille_id = $request->route('bouteille_id');
        $commentaire = new CommentaireBouteille;
        $commentaire->corps = $request->input('comment');
        $commentaire->bouteille_id = $bouteille_id;
        $commentaire->user_id = Auth::user()->id;
        $commentaire->save();

        $commentaire = CommentaireBouteille::find($commentaire->id);

        return redirect()->route('bouteille.show', ['bouteille_id' => $bouteille_id])
            ->with('successMessage', 'Commentaire ajouté!')
            ->with('commentaire', $commentaire);
    }

    /**
     * Mise à jour d'un commentaire sur une bouteille de la SAQ.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CommentaireBouteille $commentaire_bouteille
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CommentaireBouteille $commentaire_bouteille)
    {
        $request->validate([
            'comment'  => 'required|min:2'
        ],
        [
            'comment.required'  => 'Veuillez saisir votre commentaire',
            'comment.min'       => 'Votre commentaire doit contenir au moins 2 caractères'
        ]);

        try {
            $commentaire_bouteille->update([
                'corps' => $request->comment
            ]);
    
            return redirect()->back()->with('successMessage', 'Commentaire modifié!')
            ->with('commentaire', $commentaire_bouteille);;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du commentaire"]);
        }
    }

    /**
     * Suppression d'un commentaire sur une bouteille de la SAQ.
     *
     * @param \App\Models\CommentaireBouteille $commentaire_bouteille
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CommentaireBouteille $commentaire_bouteille)
    {
        try {

            $commentaire_bouteille->delete();

            return redirect()->back()->withSuccess('Commentaire supprimé!');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la suppression du commentaire"]);
        }
    }
}
