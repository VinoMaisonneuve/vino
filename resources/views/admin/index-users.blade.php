@extends('layouts.app')
@section("title", "Liste d'utilisateurs")
@section('content')
<header>
    utilisateurs
</header>
<main class="nav-margin">
    <div class="btn-submit">
        <a href="{{ route('admin.create-user') }}">ajouter un utilisateur</a>
    </div>
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-container">
        <form id="searchForm" action="{{ route('admin.search-users') }}" method="GET">
            <div class="form-input-container">
                <label for="search_users">RECHERCHE</label>
                <input type="text" id="search_users" name="search_users" placeholder="Nom / Identifiant">
            </div>
        </form>
    </div>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>    
                    <th>NOM</th>
                    <th>RÔLE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="user-row">
                    <td class="user-id">{{ $user->id }}</td>
                    <td class="user-name">{{ $user->nom }}</td>
                    @if($user->getRoleNames()->first() == "Admin")
                        <td>Administrateur</td>
                    @else
                        <td>Utilisateur</td>
                    @endif
                    <td>
                        <a href="{{ route('admin.show-user', $user->id) }}">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 15V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H7" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.5 14.8L21 5.2L16.8 1L7.3 10.5L7 15L11.5 14.8Z" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </td>    
                </tr>
                @empty
                <p>Aucun utilisateur</p>
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</main>
<script src="{{ asset('js/search-users.js') }}"></script>
@endsection