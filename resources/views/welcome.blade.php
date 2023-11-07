@extends('layouts.app')
@section('title', 'Bienvenue')
@section('content')
<header>
    vino
</header>
<main>
    <div class="welcome">
        <h1 class="welcome-title">Bienvenue chez <span class="welcome-vino">vino</span>!</h1>
        <p class="welcome-text">L'outil le plus simple et efficace pour gérer vos celliers et vos achats SAQ.</p>
    </div>
    <picture class="welcome-image-container">
        <img src="{{ asset('assets/img/img_connexion.jpeg') }}" alt="Bouteille au marché" class="welcome-img">
    </picture>
    <div class="form-container">
        <form action="{{ route('login.authentication') }}" method="post" id="login">
            @csrf
            <div class="form-input-container">
                <label for="email">EMAIL</label>
                <input type="text" id="email" name="email">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-input-container">
                <label for="password">PASSWORD</label>
                <input type="text" id="password" name="password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-forgot-psw link">
                <a href="#">MOT DE PASSE OUBLIÉ</a>
            </div>
            <button type="submit" form="login" class="btn-submit">CONNECTER</button>
            <div class="link">
                <a href="{{ route('register') }}">CRÉER UN COMPTE</a>
            </div>

        </form>
    </div>
</main>

@endsection