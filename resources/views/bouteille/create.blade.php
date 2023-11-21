<!-- Création d'une bouteille personnalisée -->
@extends('layouts.app')
@section('title','Recherche')
@section('content')
        <header>
            <a href="{{ route('cellier.show', ['cellier_id' => $cellier_id]) }}" class="btn-arrow-top">
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
                </svg>
                ajouter une bouteille
            </a>
        </header>
        <main class="form-border nav-margin">
            <h1 class="form-h1">
                Ajouter une bouteille
            </h1>
            <div class="form-container">
                <form action="{{ route('bouteillePersonnalisee.store', ['cellier_id' => $cellier_id]) }}" method="post" id="ajouterBouteilleExistante">
                    @csrf
                    <div class="form-input-container">
                        <label for="nom">Nom de la bouteille</label>
                        <select name="bouteille_id" id="select-location">
                            @forelse ($bouteilles as $bouteille)
                                <option value="{{ $bouteille->id }}">{{ $bouteille->nom }}</option>
                            @empty 
                                <option value="">Vous n'avez aucune bouteille personnalisée</option>
                            @endforelse
                        </select>
                    </div>
                    @if ($bouteilles->isNotEmpty())
                    <div class="card-bouteille-qt">
                        <button class="btn-decrement">-</button>
                        <input type="text" value="0" min="0" name="quantite" readonly>
                        <button class="btn-increment">+</button>
                    </div>
                    @endif
                    <div class="form-button">
                        <button type="submit" form="ajouterBouteilleExistante" class="btn-submit" @if($bouteilles->isEmpty()) disabled @endif>Ajouter bouteille</button>
                    </div>
                </form>
            </div>
            <h1 class="form-h1">
                Créer une bouteille
            </h1>
            <div class="form-container">
                <form action="{{ route('bouteille.store', ['cellier_id' => $cellier_id]) }}" method="post" id="ajouterBouteille">
                    @csrf
                    <div class="form-input-container">
                        <label for="nom">Nom de la bouteille</label>
                        <input type="text" id="nom" name="nom">
                        @if ($errors->has('nom')) 
                            <div>{{ $errors->first('nom') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="millesime">Millésime</label>
                        <input type="text" id="millesime" name="millesime">
                        @if ($errors->has('millesime')) 
                            <div>{{ $errors->first('millesime') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="degre">Degré d'alcool</label>
                        <input type="text" id="degre" name="degre">
                        @if ($errors->has('degre')) 
                            <div>{{ $errors->first('degre') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="couleur">Couleur</label>
                        <input type="text" id="couleur" name="couleur">
                        @if ($errors->has('couleur')) 
                            <div>{{ $errors->first('couleur') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="producteur">Producteur</label>
                        <input type="text" id="producteur" name="producteur">
                        @if ($errors->has('producteur')) 
                            <div>{{ $errors->first('producteur') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="type">Type</label>
                        <input type="text" id="type" name="type">
                        @if ($errors->has('type')) 
                            <div>{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="cepage">Cépage</label>
                        <input type="text" id="cepage" name="cepage">
                        @if ($errors->has('cepage')) 
                            <div>{{ $errors->first('cepage') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="region">Région</label>
                        <input type="text" id="region" name="region">
                        @if ($errors->has('region')) 
                            <div>{{ $errors->first('region') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="pays">Pays</label>
                        <input type="text" id="pays" name="pays">
                        @if ($errors->has('pays')) 
                            <div>{{ $errors->first('pays') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix">
                        @if ($errors->has('prix')) 
                            <div>{{ $errors->first('prix') }}</div>
                        @endif
                    </div>
                    <div class="form-input-container">
                        <label for="format">Format</label>
                        <input type="text" id="format" name="format">
                        @if ($errors->has('format')) 
                            <div>{{ $errors->first('format') }}</div>
                        @endif
                    </div>
                    <div class="form-button">
                        <button type="submit" form="ajouterBouteille" class="btn-submit">Créer bouteille</button>
                    </div>
                </form>
            </div>
            <script src="{{ asset('js/bottleCounterModal.js') }}"></script>
        </main>
        @endsection
