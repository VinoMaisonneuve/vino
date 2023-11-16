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
    @if($errors)
    @foreach($errors->all() as $error)
        <span>{{$error}}</span>
    @endforeach
    @endif
    <div class="form-container">
        <form method="post">
            @csrf
            <div class="form-input-container">
                <label for="new-password">Nouveau mot de passe</label>
                <input type="text" id="new-password" name="password">
            </div>
            <div class="form-input-container">
                <label for="repeat-new-password">Répéter nouveau mot de passe</label>
                <input type="text" id="repeat-new-password" name="password_confirmation">
            </div>
            <div class="form-button">
                <button type="submit" form="" class="btn-submit">Enregistrer</button>
            </div>
        </form>
    </div>
</main>
@endsection