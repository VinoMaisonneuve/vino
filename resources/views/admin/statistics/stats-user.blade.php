@php
    date_default_timezone_set('America/New_York');
@endphp
@extends('layouts.app')
@section('title', 'Statistiques par utilisateur')

@section('content')
<header>
    <a href="{{ route('statistics.stats-users') }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        statistiques
    </a>
</header>
<main class="nav-margin">
    <h1>Statistiques détaillées pour {{ $user->nom }}</h1>
    <h3> En date du {{date('d-m-Y')}} à {{date('H:i')}}</h3>

    <h2>CELLIERS</h2>
<!-- Dépenses totales des celliers -->
    <section class="admin-stats-section">
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
        @else
        <p>Aucun cellier</p>
        @endif

<!-- Type de vin par cellier-->
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
        @else
        <p>Aucun cellier</p>
        @endif

<!-- Cépage par cellier -->
        <h3>Type de cépage par cellier</h3>
        @if(count($celliers) > 0)
        @foreach($celliers as $cellier)
        <h4>Cellier - {{ $cellier->nom }}</h4>

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
        @endif
        @endforeach
        @else 
        <p>Aucun cellier</p>
        @endif
    </section>

    <h2>LISTES</h2>
<!-- Dépenses totales par listes -->
    <section class="admin-stats-section">
        <h3>Dépenses totales par liste</h3>
        @if(count($listes) > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Bouteilles/Liste</th>
                    <th>Total/Liste</th>
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
        @else
        <p>Aucune liste</p>
        @endif
<!-- Types de vin par listes -->
        <h3>Type de vin par liste</h3>
        @if(count($listes) > 0)
        @foreach($listes as $liste)
        <h4>Liste - {{ $liste->nom }}</h4>
            @php
                $groupedBouteilles = $liste->bouteillesListes->groupBy('bouteille.type');
            @endphp
            @if($groupedBouteilles->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
            @foreach($groupedBouteilles as $type => $bouteilles)
                <tr>
                    <td>{{ $type }}</td>
                    <td>{{ $bouteilles->sum('quantite') }}</td>
                </tr>
            @endforeach
                </tbody>
            </table>
            @else 
            <p>Aucune donnée à afficher pour cette liste</p>
            @endif
        @endforeach
        @else
        <p>Aucune liste</p>
        @endif
<!-- Type de cépage par listes -->
        <h3>Type de cépage par liste</h3>
        @if(count($listes) > 0)
        @foreach($listes as $liste)
        <p>Liste - {{ $liste->nom }}</p>

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
        <p>Aucune donnée à afficher pour cette liste</p>
        @endif
        @endforeach
        @else 
        <p>Aucune liste</p>
        @endif
    </section>
</main>
@endcontent