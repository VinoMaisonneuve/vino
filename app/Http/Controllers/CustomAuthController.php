<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|min:2|max:20|alpha',
            'prenom' => 'required|min:2|max:20|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed', // Added 'confirmed' rule
        ]);

        $user = new User;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect(route('welcome'))->withSuccess('Utilisateur enregistré');
    }

    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ], [
            'email.required' => 'Veuillez saisir votre adresse email',
            'password.required' => 'Veuillez saisir votre mot de passe',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::validate($credentials)) {
            return redirect('login')
                ->withErrors([
                    'email' => 'L\'adresse email ou le mot de passe est incorrect'
                ])
                ->withInput();
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user, $request->get('remember'));

        return redirect()->route('cellier.index')->with('success', 'Vous êtes connecté');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect(route('login'))->withSuccess('Vous êtes déconnecté');
    }
}
