@extends('layouts.app')

@section('title', 'Modifier la liste')

@section('content')
    <header>
        <h1>Modifier la liste</h1>
    </header>
    <main>
        <section>
            <h2>Modifier la liste</h2>
            <form action="{{ route('liste.update', $liste->id) }}" method="post">
                @csrf
                @method('put')

                <div class="form-input-container">
                    <label for="nom">Nom de la liste</label>
                    <input type="text" id="nom" name="nom" value="{{ $liste->nom }}">
                </div>

                <div class="form-input-container">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ $liste->description }}</textarea>
                </div>
                <!-- Ajoutez d'autres champs pour la modification ici -->

                <button type="submit">Enregistrer les modifications</button>
            </form>
        </section>
    </main>
@endsection
