<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
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
            ->with('successMessage', 'Commentaire ajouté avec succès')
            ->with('commentaire', $commentaire);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
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
    
            return redirect()->back()->with('successMessage', 'Commentaire modifié avec succès')
            ->with('commentaire', $commentaire);;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du commentaire"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commentaire $commentaire)
    {
        try {

            $commentaire->delete();

            return redirect()->back()->withSuccess('Commentaire supprimé avec succès');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['erreur' => "Une erreur s'est produite lors de la suppression du commentaire"]);
        }
    }
}
