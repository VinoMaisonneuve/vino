@php
    date_default_timezone_set('America/New_York');
@endphp
@extends('layouts.app')
@section('title', 'Statistiques par utilisateur')

@section('content')
<header>
    <a href="{{ route('statistics.index') }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        statistiques
    </a>
</header>
<main>
<h2>Statistiques détaillées pour {{ $user->nom }}</h2>
<span> En date du {{date('Y-m-d H:i')}}</span>

<!-- Dépenses totales des celliers -->
<section>
<h3>Dépenses totales par cellier</h3>
@if(count($celliers) > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Bouteilles par cellier</th>
                <th>Dépense totale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($celliers as $cellier)
                <tr>
                    <td>{{ $cellier->nom }}</td>
                    <td>
                        {{ $cellier->bouteillesCelliers->sum('quantite') }}
                    </td>
                    <td>
                        @php
                            $totalPrixCellier = $cellier->bouteillesCelliers->sum(function ($bouteilleCellier) {
                                return optional($bouteilleCellier->bouteille)->prix * $bouteilleCellier->quantite;
                            });
                        @endphp
                        ${{ $totalPrixCellier ?? 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@else
    <p>Aucun cellier n'estassocié à cet utilisateur.</p>
</section>
@endif

<!-- Type de vin par cellier-->
<section>
<h3>Type de vin par cellier</h3>
    @if(count($celliers) > 0)
    @foreach($celliers as $cellier)
    <h4>Cellier - {{ $cellier->nom }}</h4>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Couleur</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedBouteilles = $cellier->bouteillesCelliers->groupBy('bouteille.type');
            @endphp

            @foreach($groupedBouteilles as $type => $bouteilles)
                <tr>
                    <td>{{ $type }}</td>
                    <td>{{ $bouteilles->sum('quantite') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
</section>
@else
    <p>Aucun cellier n'est associé à cet utilisateur.</p>
</section>
@endif

<!-- Cépage par cellier -->
<section>
    <h3>Type de cépage par cellier</h3>
    @if(count($celliers) > 0)
    @foreach($celliers as $cellier)
    <h4>Cellier : {{ $cellier->nom }}</h4>

    @php
        // Utilisez la méthode groupBy pour regrouper par cépage
        $groupedBouteillesCellier = $cellier->bouteillesCelliers->filter(function ($item) {
            return optional($item->bouteille)->cepage !== null;
        })->groupBy(function ($item) {
            return optional($item->bouteille)->cepage;
        });
    @endphp

    @if(count($groupedBouteillesCellier) > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Cépage</th>
                <th>Quantité Totale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedBouteillesCellier as $cepage => $bouteilles)
                <tr>
                    <td>{{ $cepage }}</td>
                    <td>{{ $bouteilles->sum('quantite') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucune donnée à afficher pour ce cellier.</p>
</section>
@endif
@endforeach
@else 
    <p>Aucun cellier n'est associé à cet utilisateur.</p>
</section>
@endif

<!-- Dépenses totales par listes -->
<section>
    <h3>Dépenses totales par liste</h3>
    @if(count($listes) > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nom de la Liste</th>
                <th>Qté bouteilles/Liste</th>
                <th>Prix total/Liste</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listes as $liste)
                <tr>
                    <td>{{ $liste->nom }}</td>
                    <td>
                        {{ $liste->bouteillesListes->sum('quantite') }}
                    </td>
                    <td>
                        @php
                            $totalPrixListe = $liste->bouteillesListes->sum(function ($bouteilleListe) {
                                return optional($bouteilleListe->bouteille)->prix * $bouteilleListe->quantite;
                            });
                        @endphp
                        ${{ $totalPrixListe ?? 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@else
    <p>Aucune liste n'est associée à cet utilisateur.</p>
</section>
@endif

<section>
<h3>Type de vin par liste</h3>
@if(count($listes) > 0)
@foreach($listes as $liste)
    <h4>Liste : {{ $liste->nom }}</h4>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Type de Vin</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedBouteilles = $liste->bouteillesListes->groupBy('bouteille.type');
            @endphp

            @foreach($groupedBouteilles as $type => $bouteilles)
                <tr>
                    <td>{{ $type }}</td>
                    <td>{{ $bouteilles->sum('quantite') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
</section>
@else
    <p>Aucune liste n'est associée à cet utilisateur.</p>
</section>
@endif

<section>
    <h3>Type de cépage par liste</h3>
    @if(count($listes) > 0)
    @foreach($listes as $liste)
    <h3>Liste : {{ $liste->nom }}</h3>

    @php
        // Utilisation de la méthode groupBy pour regrouper par cépage
        $groupedBouteillesListe = $liste->bouteillesListes->filter(function ($item) {
            return optional($item->bouteille)->cepage !== null;
        })->groupBy(function ($item) {
            return optional($item->bouteille)->cepage;
        });
    @endphp

    @if(count($groupedBouteillesListe) > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Cépage</th>
                <th>Quantité Totale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedBouteillesListe as $cepage => $bouteilles)
                <tr>
                    <td>{{ $cepage }}</td>
                    <td>{{ $bouteilles->sum('quantite') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Aucune donnée à afficher pour cette liste.</p>
</section>
    @endif
    @endforeach
@endif
</main>
@endcontent