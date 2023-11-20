@extends('layouts.app')
@section('title', 'Statistiques')

@section('content')
@php
    date_default_timezone_set('America/New_York');
@endphp
<header>
    statistiques
</header>
<main class="nav-margin">
    <h2>Statistiques globales | En date du {{date('Y-m-d H:i')}}</h2>
    <p>Nombre d'utilisateurs:  {{count($usersWithCellierAndListeCount)}}</p>
    count($users);
    count($celliers);
    count($listes);
    count($bouteilles); 

    {{-- <div class="form-container">
        <form id="searchForm" action="{{ route('admin.search-users') }}" method="GET">
            <div class="form-input-container">
                <label for="search_users">RECHERCHE</label>
                <input type="text" id="search_users" name="search_users" placeholder="Nom / Identifiant">
            </div>
        </form>
    </div> --}}
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
        {{-- {{ $usersWithCellierAndListeCount->links() }} --}}
    </div>
           
    {{-- <thead>
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
        </table> --}}
    @else
        <p>Aucun utilisateur avec des statistiques disponible.</p>
    @endif
</main>
<script src="{{ asset('js/search-users.js') }}"></script>
@endsection