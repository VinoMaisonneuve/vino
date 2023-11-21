<?php

namespace App\Http\Controllers;

use App\Models\BouteillePersonnalisee;
use App\Models\Cellier;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BouteillePersonnaliseeController extends Controller
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
    public function create($cellier_id)
    {
        $bouteilles = BouteillePersonnalisee::where('user_id', Auth::id())->get(); 
        return view('bouteille.create', ['cellier_id' => $cellier_id, 'bouteilles' => $bouteilles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cellier_id)
    {
        $request->validate(
            [
                'nom' => 'required|max:255',
                'millesime' => 'max:255',
                'degre' => 'max:255',
                'couleur' => 'max:255',
                'producteur' => 'max:255',
                'type' => 'max:255',
                'cepage' => 'max:255',
                'region' => 'max:255',
                'pays' => 'max:255',
                'prix' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'format' => 'max:255'
            ],
            [
                'nom.required' => 'Le nom de la bouteille est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'millesime.max' => 'Le millésime ne doit pas dépasser 255 caractères.',
                'degre.max' => 'Le degré ne doit pas dépasser 255 caractères.',
                'couleur.max' => 'La couleur ne doit pas dépasser 255 caractères.',
                'producteur.max' => 'Le producteur ne doit pas dépasser 255 caractères.',
                'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
                'cepage.max' => 'Le cépage ne doit pas dépasser 255 caractères.',
                'region.max' => 'Le région ne doit pas dépasser 255 caractères.',
                'pays.max' => 'Le pays ne doit pas dépasser 255 caractères.',
                'prix.numeric' => 'Le prix doit être numérique.',
                'prix.regex' => 'Le prix doit être séparé par un point et doit contenir un maximum de deux décimales.',
                'format.max' => 'Le format ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newBouteille = BouteillePersonnalisee::create([
            'nom' => $request->nom, 
            'millesime' => $request->millesime, 
            'degre' => $request->degre, 
            'couleur' => $request->couleur, 
            'producteur' => $request->producteur, 
            'type' => $request->type, 
            'cepage' => $request->cepage, 
            'region' => $request->region, 
            'pays' => $request->pays, 
            'prix' => $request->prix, 
            'format' => $request->format, 
            'user_id' => Auth::id()
        ]);

        $newBouteille->save(); 

        return redirect('/celliers\\' . $cellier_id . '/bouteilles'); 
    }


    /**
     * Display the specified resource.
     *
     * @param $cellier_id
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($cellier_id, $id)
    {
        $bouteille = BouteillePersonnalisee::findOrFail($id);
        $celliers = Cellier::where('user_id', Auth::id())->get();
        $commentaire = Commentaire::where('user_id', Auth::id())
        ->where('bouteille_id', $id)
        ->first();
        return view('bouteille.show-personnalisee', ['bouteille'=> $bouteille, 'celliers' => $celliers, 'commentaire' => $commentaire, 'cellier_id' => $cellier_id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BouteillePersonnalisee  $bouteillePersonnalisee
     * @return \Illuminate\Http\Response
     */
    public function edit($cellier_id, $bouteille_id)
    {
        $bouteille = BouteillePersonnalisee::findOrFail($bouteille_id);
        return view('bouteille.edit', ['bouteille'=> $bouteille, 'cellier_id' => $cellier_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BouteillePersonnalisee  $bouteillePersonnalisee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bouteille_id, $cellier_id)
    {
        $request->validate(
            [
                'nom' => 'required|max:255',
                'millesime' => 'max:255',
                'degre' => 'max:255',
                'couleur' => 'max:255',
                'producteur' => 'max:255',
                'type' => 'max:255',
                'cepage' => 'max:255',
                'region' => 'max:255',
                'pays' => 'max:255',
                'prix' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'format' => 'max:255'
            ],
            [
                'nom.required' => 'Le nom de la bouteille est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'millesime.max' => 'Le millésime ne doit pas dépasser 255 caractères.',
                'degre.max' => 'Le degré ne doit pas dépasser 255 caractères.',
                'couleur.max' => 'La couleur ne doit pas dépasser 255 caractères.',
                'producteur.max' => 'Le producteur ne doit pas dépasser 255 caractères.',
                'type.max' => 'Le type ne doit pas dépasser 255 caractères.',
                'cepage.max' => 'Le cépage ne doit pas dépasser 255 caractères.',
                'region.max' => 'Le région ne doit pas dépasser 255 caractères.',
                'pays.max' => 'Le pays ne doit pas dépasser 255 caractères.',
                'prix.numeric' => 'Le prix doit être numérique.',
                'prix.regex' => 'Le prix doit être séparé par un point et doit contenir un maximum de deux décimales.',
                'format.max' => 'Le format ne doit pas dépasser 255 caractères.'
            ]
        ); 

        BouteillePersonnalisee::findOrFail($bouteille_id)->update([
            'nom' => $request->nom, 
            'millesime' => $request->millesime, 
            'degre' => $request->degre, 
            'couleur' => $request->couleur, 
            'producteur' => $request->producteur, 
            'type' => $request->type, 
            'cepage' => $request->cepage, 
            'region' => $request->region, 
            'pays' => $request->pays, 
            'prix' => $request->prix, 
            'format' => $request->format, 
            'user_id' => Auth::id()
        ]);

        return redirect('/celliers\\' . $cellier_id . '/bouteilles-personnalisees\\' . $bouteille_id); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cellier_id
     * @param $bouteille_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cellier_id, $bouteille_id)
    {
        try {
            $bouteillePersonnalisee = BouteillePersonnalisee::findOrFail($bouteille_id); 
            $bouteillePersonnalisee->bouteillesPersonnaliseesCelliers()->delete(); 
            $bouteillePersonnalisee->delete(); 
            return redirect('/celliers\\' . $cellier_id . '/bouteilles'); 
        }
        catch (\Exception $e) {
            return redirect('/celliers\\' . $cellier_id . '/bouteilles')->with('error', 'Le cellier n\'existe pas'); 
        }
    }
}
