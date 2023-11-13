@extends('layouts.app')
@section('title', 'Modification de liste')
@section('content')
    <main class="form-border nav-margin">
        <h1 class="form-h1">
            Modifier une liste
        </h1>
        <div class="form-container">
            <form method="post" id="modifierListe">
                @method('put')
                @csrf
                <div class="form-input-container">
                    <label for="nom">Nom de la liste</label>
                    <input type="text" id="nom" name="nom" value="{{ $liste->nom }}">
                    @if ($errors->has('nom')) 
                        <div>{{ $errors->first('nom') }}</div>
                    @endif
                </div>
                <div class="form-button">
                    <button type="submit" form="modifierListe" class="btn-submit">Mettre à jour</button>
                </div>
            </form>
        </div>
        <div class="form-container">
            <form action="{{route('liste.destroy', $liste->id)}}" method="post" id="supprimerListe">
                @method('delete')
                @csrf
                <div class="form-button">
                    <button type="submit" form="supprimerListe" class="btn-action btn-round btn-red btn-supprimer">Supprimer</button>
                </div>
            </form>
        </div>
        <dialog id="modal-supprimer" class="modal">
            <h2>Suppression de la liste {{ $liste->nom }}</h2>
            <hr>
            <p>Êtes-vous certain de vouloir supprimer la liste {{ $liste->nom }}?</p>
            <form action="{{ route('liste.destroy', $liste->id) }}" method="post" class="form-modal" id="supprimerListe">
                @csrf
                @method('DELETE')
                <div class="btn-modal-container">
                    <button type="submit" form="supprimerListe" class="btn-modal-action btn-red">oui, supprimer</button>
                    <button class="btn-modal-cancel btn-green">annuler</button>
                </div>
            </form>
        </dialog>
        <script src="{{ asset('js/modalSupprimer.js') }}"></script>
    </main>

@endsection