<!-- Création d'un nouveau mot de passe suite à l'ouverture du courriel reçu -->
@extends('layouts.app')
@section('title', 'Nouveau mot de passe')
@section('content')
<header>
    vino
</header>
<main class="form-border">
    <h1 class="form-h1">
        Nouveau mot de passe
    </h1>
    @if(session('success'))
        <span>{{session('success')}}</span>
    @endif
    <div class="form-container">
        <form method="post" id="newPassword">
            @csrf
            <div class="form-input-container">
                <label for="new-password">Nouveau mot de passe</label>
                <input type="password" id="new-password" name="password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-input-container">
                <label for="repeat-new-password">Répéter nouveau mot de passe</label>
                <input type="password" id="repeat-new-password" name="password_confirmation">
            </div>
            <div class="form-button">
                <button type="submit" form="newPassword" class="btn-submit">Enregistrer</button>
            </div>
        </form>
    </div>
</main>
@endsection