@extends('layouts.app')

@section('title', 'Détails de la liste')

@section('content')
    <header>
        <h1>Détails de la liste</h1>
    </header>
    <main>
        <section>
            <h2>Détails de la liste</h2>
            <p>Nom de la liste : {{ $liste->nom }}</p>
            <p>Description : {{ $liste->description }}</p>
            <!-- Affiche d'autres détails de la liste ici -->
        </section>
    </main>
@endsection
