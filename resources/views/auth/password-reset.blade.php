<!-- Formulaire d'entrer du courriel et de l'envoi d'un nouveau mot de passe -->
@extends('layouts.app')
@section('title', 'Mot de passe oublié')
@section('content')
<header>
    vino
</header>
<main class="form-border">
    <h1 class="form-h1">
        Mot de passe oublié
    </h1>
    <div class="form-container">
        @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
        @endif
        @if($errors)
            @foreach($errors->all() as $error)
            <div>
                {{ $error }}
            </div>
            @endforeach
        @endif
        <form action="{{ route('temp.password') }}" method="post" id="forgot-password">
            @csrf
            <div class="form-input-container">
                <label for="email">Courriel</label>
                <input type="text" id="email" name="email">
                @if ($errors->has('email'))
                <span>
                    {{ $errors->first('email') }}
                </span>
                @endif
            </div>
            <div class="form-button">
                <button type="submit" form="forgot-password" class="btn-submit">Envoyer un courriel</button>
            </div>
        </form>
    </div>
</main>
<footer>
    © <span>vino</span> 2023. (version 1.1) - Tous droits réservés.
</footer>
@endsection