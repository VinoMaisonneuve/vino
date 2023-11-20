@extends('layouts.app')
@section('title', 'Statistiques des utilisateurs')

@section('content')
@php
    date_default_timezone_set('America/New_York');
@endphp
<header>

</header>
<main>

</main>
<h2>Statistiques de tous les utilisateurs </h2>
    <?php date_default_timezone_set('America/New_York');?>
    <span>{{date('Y-m-d H:i')}}</span>
    <p>Nombre des utilisateurs:  {{count($usersWithCellierAndListeCount)}}</p>
    count($users);
    count($celliers);
    count($listes);
    count($bouteilles);


    @if(count($usersWithCellierAndListeCount) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nombre de Celliers</th>
                    <th>Nombre de Listes</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usersWithCellierAndListeCount as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->celliers_count }}</td>
                        <td>{{ $user->listes_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('statistics.details', ['user' => $user->id]) }}">Afficher les détails</a>
                        </td>
                    </tr>
                 
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun utilisateur avec des statistiques disponible.</p>
    @endif

@endsection