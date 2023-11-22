<?php

namespace App\Http\Controllers;

use App\Models\CommentaireBouteillePersonnalisee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireBouteillePersonnaliseeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            ->with('successMessage', 'Commentaire ajouté avec succès')
            ->with('commentaire', $commentaire);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommentaireBouteillePersonnalisee  $commentaireBouteillePersonnalisee
     * @return \Illuminate\Http\Response
     */
    public function show(CommentaireBouteillePersonnalisee $commentaireBouteillePersonnalisee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommentaireBouteillePersonnalisee  $commentaireBouteillePersonnalisee
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentaireBouteillePersonnalisee $commentaireBouteillePersonnalisee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommentaireBouteillePersonnalisee  $commentaireBouteillePersonnalisee
     * @return \Illuminate\Http\Response
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
    
            return redirect()->back()->with('successMessage', 'Commentaire modifié avec succès')
            ->with('commentaire', $commentaire_bouteille_id);;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du commentaire"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommentaireBouteillePersonnalisee  $commentaireBouteillePersonnalisee
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentaireBouteillePersonnalisee $commentaire_bouteille_id)
    {
        try {

            $commentaire_bouteille_id->delete();

            return redirect()->back()->withSuccess('Commentaire supprimé avec succès');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la suppression du commentaire"]);
        }
    }
}
