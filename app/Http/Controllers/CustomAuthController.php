<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Role;
use App\Http\Controllers\CellierController;

class CustomAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalsCelliers = CellierController::calculerTotalCellier();
        $totalsListes = ListeController::calculerTotalListe();

        $totalPrixCelliers = $totalsCelliers['totalPrixCelliers'];
        $totalQuantiteCelliers = $totalsCelliers['totalQuantiteCelliers'];
        $totalPrixListes = $totalsListes['totalPrixListes'];
        $totalQuantiteListes = $totalsListes['totalQuantiteListes'];
    
        return view('welcome', compact('totalPrixCelliers', 'totalQuantiteCelliers', 'totalPrixListes', 'totalQuantiteListes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.create');
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
            'nom'      => 'required|min:2|max:20|alpha',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed'
        ],
        [
            'nom.required'      => 'Veuillez saisir votre nom',
            'nom.min'           => 'Votre nom doit contenir au moins 2 caractères',
            'nom.max'           => 'Votre nom ne doit pas dépasser 20 caractères',
            'nom.alpha'         => 'Votre nom ne doit contenir que des lettres',
            'email.required'    => 'Veuillez saisir votre adresse email',
            'email.email'       => 'Veuillez entrer un courriel valide',
            'password.required' => 'Veuillez saisir votre mot de passe',
            'password.min'      => 'Votre mot de passe doit contenir au moins 6 caractères',
            'password.confirmed'=> 'Les mots de passe ne correspondent pas'
        ]);

        $user = new User;
        $user->nom = $request->input('nom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect(route('welcome'))->withSuccess('Compte créé avec succès, vous pouvez maintenant vous connecter.');
    }

    /**
     * Authentification / log in of a resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authentication(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users',
            'password' => 'required'
        ], [
            'email.required'     => "Veuillez saisir votre adresse email",
            'email.email'        => "Veuillez entrer une adresse email valide",
            'email.exists' => "Ce courriel n'est pas associé à un compte",
            'password.required'  => "Veuillez saisir votre mot de passe",
        ]);
        try {

            $credentials = $request->only('email', 'password');

            if (!Auth::validate($credentials)) {
                return redirect('login')
                    ->withErrors([
                        'erreur' => "L'adresse email ou le mot de passe est incorrect"
                    ]);
            }

            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            Auth::login($user, $request->get('remember'));

            return redirect()->route('welcome'); 
        } catch (\Exception $e) {
            return redirect('login')
                ->withErrors([
                    'erreur' => "Une erreur s'est produite lors de l'authentification"
                ]);
        }
    }

    /**
     * Log out a resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->withSuccess('Vous êtes déconnecté');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('utilisateur.index', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('utilisateur.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom'   => 'required|min:2|max:20|alpha',
            'email' => 'required|email',
        ],
        [
            'nom.required'   => 'Veuillez saisir votre nom',
            'nom.min'        => 'Votre nom doit contenir au moins 2 caractères',
            'nom.max'        => 'Votre nom ne doit pas dépasser 20 caractères',
            'nom.alpha'      => 'Votre nom ne doit contenir que des lettres',
            'email.required' => 'Veuillez saisir votre adresse courriel', 
            'email.email'    => 'Veuillez saisir un courriel valide'
        ]); 

        try {
            $user->update([
                'nom' => $request->nom,
                'email' => $request->email
            ]);
    
            return redirect(route('profil.show', $user->id))->withSuccess('Profil mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect(route('profil.edit', $user->id))->withErrors(['erreur' => "Une erreur s'est produite lors de la mise à jour du profil"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], 
        [
            'password.required' => "Le mot de passe est requis pour supprimer un compte"
        ]);
    
        if (Hash::check($request->password, $user->password)) {
            
            $celliers = $user->celliers;
            foreach($celliers as $cellier){
                $cellier->bouteillesCelliers()->delete(); 
            }
            $user->celliers()->delete();
        
            $listes = $user->listes;
            foreach($listes as $liste){
                $liste->bouteillesListes()->delete(); 
            }
            $user->listes()->delete();

            $user->delete();
            return redirect()->route('welcome')->withSuccess('Compte supprimé avec succès.');
        } else {
            return back()->withErrors(['erreur' => 'Le mot de passe est incorrect.']);
        }
    }

}