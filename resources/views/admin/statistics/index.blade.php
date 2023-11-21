@extends('layouts.app')
@section('title', 'Statistiques')

@section('content')
@php
    date_default_timezone_set('America/New_York');
@endphp
<header>
    <a href="{{ route('statistics.stats-users') }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        statistiques
    </a>
</header>
<main class="nav-margin">
    <h1>Statistiques des utilisateurs</h1>
    <h3>En date du {{ date('d-m-Y') }} à {{ date('H:i') }}</h3>
    <h2>Nombre d'utilisateurs:  {{count($usersWithCellierAndListeCount)}}</h2>

    @if(count($usersWithCellierAndListeCount) > 0)
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>    
                    <th>NOM</th>
                    <th>CELLIERS</th>
                    <th>LISTES</th>
                    <th>DÉTAILS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($usersWithCellierAndListeCount as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->celliers_count }}</td>
                    <td>{{ $user->listes_count ?? 0 }}</td>
                    <td>
                        <a href="{{ route('statistics.stats-user', ['user' => $user->id]) }}">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 15V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H7" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.5 14.8L21 5.2L16.8 1L7.3 10.5L7 15L11.5 14.8Z" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $usersWithCellierAndListeCount->links() }}
    @else
        <p>Aucun utilisateur</p>
    @endif
</main>
<script src="{{ asset('js/search-users.js') }}"></script>
@endsection