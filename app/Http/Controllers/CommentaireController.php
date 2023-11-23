<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Stocke un nouveau commentaire pour une bouteille.
     *
     * @param \Illuminate\Http\Request $request
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
        $commentaire = new Commentaire;
        $commentaire->corps = $request->input('comment');
        $commentaire->bouteille_id = $bouteille_id;
        $commentaire->user_id = Auth::user()->id;
        $commentaire->save();

        $commentaire = Commentaire::find($commentaire->id);

        return redirect()->route('bouteille.show', ['bouteille_id' => $bouteille_id])
            ->with('successMessage', 'Commentaire ajouté!')
            ->with('commentaire', $commentaire);
    }

    /**
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Mise à jour d'n commentaire pour une bouteille.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commentaire $commentaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        $request->validate([
            'comment'  => 'required|min:2'
        ],
        [
            'comment.required'  => 'Veuillez saisir votre commentaire',
            'comment.min'       => 'Votre commentaire doit contenir au moins 2 caractères'
        ]);

        try {
            $commentaire->update([
                'corps' => $request->comment
            ]);
    
            return redirect()->back()->with('successMessage', 'Commentaire modifié!')
            ->with('commentaire', $commentaire);;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du commentaire"]);
        }
    }

    /**
     * Suppression d'un commentaire pour une bouteille.
     *
     * @param \App\Models\Commentaire $commentaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Commentaire $commentaire)
    {
        try {

            $commentaire->delete();

            return redirect()->back()->withSuccess('Commentaire supprimé!');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la suppression du commentaire"]);
        }
    }
}
