@extends('layouts.app')

@section('title', 'Listes de bouteilles')

@section('content')
    <header>
        <h1>Liste de toutes les listes d'achat</h1>
    </header>
    <main>
        <section>
            <h2>Listes disponibles</h2>
            <ul>
                @foreach ($listes as $liste)
                    <li>
                        <a href="{{ route('liste.show', $liste->id) }}">{{ $liste->nom }}</a>
                    </li>
                @endforeach
            </ul>
        </section>
        <section>
            <h2>Créer une nouvelle liste</h2>
            <form action="{{ route('liste.create') }}" method="get">
                <button type="submit">Créer une nouvelle liste</button>
            </form>
        </section>
    </main>
@endsection
