@extends('layouts.app')
@section('title','Fiche bouteille')
@section('content')
<header>
    <a href="{{ route('cellier.show', $cellier_id) }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        fiche bouteille
    </a>
</header>
<main class="nav-margin">
    <section class="card-bouteille fiche-main-info {{ $bouteille->couleur == 'Blanc' ? 'bg-jaune' : ($bouteille->couleur == 'Rouge' ? 'bg-rouge' : ($bouteille->couleur == 'Rosé' ? 'bg-rose' : '')) }}">
        <picture class="fiche-picture">
            <img src="{{ asset('assets/img/bouteille_personnalisee.webp') }}" alt="Image défaut pour Bouteille personnalisée" >
        </picture>
        <div class="card-bouteille-content">
            <div class="card-bouteille-info">
                <h2>{{ $bouteille->nom}}</h2>
                <span>{{$bouteille->type  ?? 'Type N.D.'}} | {{ $bouteille->format  ?? 'Format N.D.'}} | {{$bouteille->pays  ?? 'Pays N.D.'}}</span>
                <p>{{$bouteille->prix  ?? 'Prix N.D.'}}  $</p>
            </div>
            <a href="{{ route('bouteille.edit', ['cellier_id' => $cellier_id, 'bouteille_id' => $bouteille->id]) }}" class="btn-ajouter">Modifier</a>
        </a>
        </div>
    </section>
    <table>
        <tbody>
            <tr>
                <th>Région</th>
                <td>{{$bouteille->region ?? '-'}}</td>
            </tr>
            <tr>
                <th>Producteur</th>
                <td>{{$bouteille->producteur ?? '-'}}</td>
            </tr>
            <tr>
                <th>Cépage</th>
                <td>{{ $bouteille->cepage ?? '-' }}</td>
            </tr>
            <tr>
                <th>Degré d'alcool</th>
                <td>{{$bouteille->degre ?? '-'}}</td>
            </tr>
            <tr>
                <th>Taux de sucre</th>
                <td>{{$bouteille->tauxSucre ?? '-'}}</td>
            </tr>
        </tbody>
    </table>
    @if ($commentaire)
        @include('partials.commentaires', ['route_update' => route('commentP.update', ['commentaire_bouteille_id' => $commentaire->id]), 'route_delete' => route('commentP.destroy', ['commentaire_bouteille_id' => $commentaire->id])])
    @else 
        @include('partials.commentaires', ['route_store' => route('commentPersonnalisee.store', ['cellier_id' => $cellier_id, 'bouteille_personnalisee_id' => $bouteille->id])])
    @endif
</main>
@endsection
