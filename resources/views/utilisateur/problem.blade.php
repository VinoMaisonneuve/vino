@extends('layouts.app')
@section('title', 'Signalement')

@section('content')
<header>
    <a href="{{ route('profil.show', Auth::user()->id) }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        profil
    </a>
</header>
<main class="nav-margin">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @else
    <section>
        <p>Veuillez entrer la catégorie d'erreur que vous rencontrez. <br> Nous vous contacterons dans les plus brefs délais.</p>
        <div class="form-container">
            <form action="{{ route('signalerErreur') }}" method="post" id="signalerErreur">
                @csrf
                <div class="form-input-container">
                    <label for="select_issue">Signaler un problème</label>
                    <select name="probleme" id="select_issue">
                        <option value="Choisir un problème">Choisir un problème</option>
                        <option value="Gestion du profil">Gestion du profil</option>
                        <option value="Erreurs d'informations d'une bouteille">Erreurs d'informations d'une bouteille</option>
                        <option value="Erreurs de gestion de celliers">Erreurs de gestion de celliers</option>
                        <option value="Erreurs de gestion de listes">Erreurs de gestion de listes</option>
                        <option value="Erreurs de gestion d'une bouteille personnalisée">Erreurs de gestion d'une bouteille personnalisée</option>
                        <option value="Problème lié à l'application générale">Problème lié à l'application générale</option>
                        <option value="Plainte">Plainte</option>
                    </select>
                </div>
                <div class="form-button">
                    <button type="submit" form="signalerErreur" class="btn-submit">Signaler</button>
                </div>
            </form>
        </div>
    </section>
    @endif
</main>
@endsection