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
        <form action="">
            <div class="form-input-container">
                <label for="search_users">RECHERCHE</label>
                <input type="text" id="search_users" placeholder="Nom / Identifiant">
            </div>
        </form>
    </div>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>IDENTIFIANT</th>    
                    <th>NOM</th>
                    <th>RÔLE</th>
                    <th>ACTION</th>
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
                    <td><a href="{{ route('admin.show-user', $user->id) }}"><button class="btn-ajouter">Mettre à jour</button></a></td>
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