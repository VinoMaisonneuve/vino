<!-- Modification d'une bouteille personnalisée et suppression -->
@extends('layouts.app')
@section('title','Recherche')
@section('content')
<header>
    <a href="{{ route('personnalisee.show', ['bouteille_id' => $bouteille_id, 'cellier_id' => $cellier_id]) }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        modifier une bouteille
    </a>
</header>
<main class="form-border nav-margin">
    
    <h1 class="form-h1">
        Modifier une bouteille
    </h1>
    <div class="form-container">
        <form method="post" id="modifierBouteille">
            @csrf
            @method('put')
            <div class="form-input-container">
                <label for="nom">Nom de la bouteille</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') ?? $bouteille->nom }}" required>
                @if ($errors->has('nom')) 
                    <div class="error-message">{{ $errors->first('nom') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" value="{{ old('type') ?? $bouteille->type }}">
                @if ($errors->has('type')) 
                    <div class="error-message">{{ $errors->first('type') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="format">Format</label>
                <input type="text" id="format" name="format" value="{{ old('format') ?? $bouteille->format }}">
                @if ($errors->has('format')) 
                    <div class="error-message">{{ $errors->first('format') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="prix">Prix</label>
                <input type="text" id="prix" name="prix" value="{{ old('prix') ?? $bouteille->prix }}">
                @if ($errors->has('prix')) 
                    <div class="error-message">{{ $errors->first('prix') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="pays">Pays</label>
                <input type="text" id="pays" name="pays" value="{{ old('pays') ?? $bouteille->pays }}">
                @if ($errors->has('pays')) 
                    <div class="error-message">{{ $errors->first('pays') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="region">Région</label>
                <input type="text" id="region" name="region" value="{{ old('region') ?? $bouteille->region }}">
                @if ($errors->has('region')) 
                    <div class="error-message">{{ $errors->first('region') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="producteur">Producteur</label>
                <input type="text" id="producteur" name="producteur" value="{{ old('producteur') ?? $bouteille->producteur }}">
                @if ($errors->has('producteur')) 
                    <div class="error-message">{{ $errors->first('producteur') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="cepage">Cépage</label>
                <input type="text" id="cepage" name="cepage" value="{{ old('cepage') ?? $bouteille->cepage }}">
                @if ($errors->has('cepage')) 
                    <div class="error-message">{{ $errors->first('cepage') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="degre">Degré d'alcool</label>
                <input type="text" id="degre" name="degre" value="{{ old('degre') ?? $bouteille->degre }}">
                @if ($errors->has('degre')) 
                    <div class="error-message">{{ $errors->first('degre') }}</div>
                @endif
            </div>
            <div class="form-input-container">
                <label for="millesime">Millésime</label> 
                <input type="text" id="millesime" name="millesime" value="{{ old('millesime') ?? $bouteille->millesime }}">
                @if ($errors->has('millesime')) 
                    <div class="error-message">{{ $errors->first('millesime') }}</div>
                @endif
            </div>
            <div class="form-button">
                <button type="submit" form="modifierBouteille" class="btn-submit">Modifier bouteille</button>
            </div>
        </form>
    </div>
    <div class="form-container">
        <form action="{{route('bouteillePersonnalisee.destroy', ['cellier_id' => $cellier_id, 'bouteille_id' => $bouteille->id]) }}" method="post" id="supprimerBouteille">
            @method('delete')
            @csrf
            <div class="form-button">
                <button type="submit" form="supprimerBouteille" class="btn-action btn-round btn-red btn-supprimer">Supprimer</button>
            </div>
        </form>
    </div>
    <dialog id="modal-supprimer" class="modal">
        <h2>Suppression de la bouteille {{ $bouteille->nom }}</h2>
        <hr>
        <p>Êtes-vous certain(e) de vouloir supprimer la bouteille {{ $bouteille->nom }}? Cette action supprimera également cette bouteille de tous vos celliers.</p>
        <form action="{{ route('bouteillePersonnalisee.destroy', ['cellier_id' => $cellier_id, 'bouteille_id' => $bouteille->id]) }}" method="post" class="form-modal" id="supprimerBouteille">
            @csrf
            @method('DELETE')
            <div class="btn-modal-container">
                <button type="submit" form="supprimerBouteille" class="btn-modal-action btn-red">oui, supprimer</button>
                <button class="btn-modal-cancel btn-green">annuler</button>
            </div>
        </form>
    </dialog>
    <script src="{{ asset('js/modalSupprimer.js') }}"></script>
    <script src="{{ asset('js/bottleCounterModal.js') }}"></script>
</main>
@endsection
