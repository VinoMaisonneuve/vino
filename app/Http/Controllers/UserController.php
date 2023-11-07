<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importez le modèle User
use Spatie\Permission\Models\Role; // Importez le modèle Role

class UserController extends Controller
{
    // Méthode pour afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Méthode pour traiter l'inscription d'un utilisateur
    public function register(Request $request)
    {
        // Validez les données du formulaire d'inscription (utilisez les règles de validation de Laravel)

        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créez un nouvel utilisateur
        $user = new User();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Attribuez un rôle (par exemple, 'Utilisateur') à l'utilisateur
        $role = Role::where('name', 'Utilisateur')->first(); // Assurez-vous que le rôle existe
        $user->assignRole($role);

        // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
        return redirect()->route('login');
    }

    // Autres méthodes pour gérer les utilisateurs
}
