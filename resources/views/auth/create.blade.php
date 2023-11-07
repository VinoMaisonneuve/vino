@extends('layouts.app')
@section('title', 'Bienvenue')
@section('content')

<div class="container">
    <div class="welcome">
        <h2 class="welcome-title">Bienvenue chez <span class="welcome-vino">vino</span>!</h2>
        <p class="welcome-text">L'outil le plus simple et efficace pour gérer vos celliers et vos achats SAQ.</p>
    </div>
    <img src="{{ asset('assets/img/img_connexion.jpeg') }}" alt="Bouteille au marché" class="welcome-img">
    <div class="welcome-informations">
        <form action="/register" class="welcome-form" method="post" id="registration">
            @csrf
            <div class="welcome-input-container">
                <label for="nom" class="welcome-form-label">NOM</label>
                <input type="text" id="nom" name="nom" class="welcome-form-input">
            </div>
            <div class="welcome-input-container">
                <label for="prenom" class="welcome-form-label">PRÉNOM</label>
                <input type text" id="prenom" name="prenom" class="welcome-form-input">
            </div>
            <div class="welcome-input-container">
                <label for="email" class="welcome-form-label">EMAIL</label>
                <input type="text" id="email" name="email" class="welcome-form-input">
            </div>
            <div class="welcome-input-container">
                <label for="password" class="welcome-form-label">MOT DE PASSE</label>
                <input type="password" id="password" name="password" class="welcome-form-input">
            </div>
            <div class="welcome-input-container">
                <label for="password_confirmation" class="welcome-form-label">CONFIRMER LE MOT DE PASSE</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="welcome-form-input">
            </div>
        </form>
        <div class="welcome-forgot-psw">
            <a href="#">MOT DE PASSE OUBLIÉ</a>
        </div>
        <button class="welcome-connection-btn" type="submit" form="registration">CRÉER UN COMPTE</button>
        <a href="{{ route('login') }}">SE CONNECTER</a>
    </div>
</div>

@endsection
