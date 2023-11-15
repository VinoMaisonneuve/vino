<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="svg" href="{{ asset('assets/icons/intitle_icon.svg')}}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/dox8qou.css">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <title>Vino - @yield('title')</title>
</head>
<body>
    @yield('content')
    <!-- Si authentifié et administrateur -->
    @auth
    @if(Auth::user()->hasRole("Admin"))
    <nav>
        <ul class="nav-admin-list">
            <li class="nav-item">        
                <a href="{{ route('admin.index') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'admin.index') active @endif">
                        <img src="{{ asset('assets/icons/admin_users_icon.svg') }}" alt="Accueil">
                        <figcaption>utilisateurs</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="{{ route('bouteille.index') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'bouteille.index') active @endif">
                        <img src="{{ asset('assets/icons/add_icon.svg') }}" alt="Recherche">
                        <figcaption class="icons-label">bouteilles</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="{{ asset('assets/icons/admin_stats_icon.svg') }}" alt="Liste d'achats">
                        <figcaption>statistiques</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">         
                <a href="{{ route('profil.show', Auth::user()->id) }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'profil.show') active @endif">
                        <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil">
                        <figcaption>profil</figcaption>
                    </figure>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Si authentifié mais pas administrateur-->
    @else
    <nav>
        <ul class="nav-list">
            <li class="nav-item">        
                <a href="{{ route('welcome') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'welcome') active @endif">
                        <img src="{{ asset('assets/icons/home_icon.svg') }}" alt="Accueil">
                        <figcaption>accueil</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="{{ route('bouteille.index') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'bouteille.index') active @endif">
                        <img src="{{ asset('assets/icons/add_icon.svg') }}" alt="Recherche">
                        <figcaption class="icons-label">ajouter</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.index') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'liste.index') active @endif">
                        <img src="{{ asset('assets/icons/list_icon.svg') }}" alt="Liste d'achats">
                        <figcaption>listes</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="{{ route('cellier.index') }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'cellier.index') active @endif">
                        <img src="{{ asset('assets/icons/cellars_icon.svg') }}" alt="Celliers">
                        <figcaption>celliers</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">         
                <a href="{{ route('profil.show', Auth::user()->id) }}">
                    <figure class="nav-icon-container @if(Route::currentRouteName() == 'profil.show') active @endif">
                        <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil">
                        <figcaption>profil</figcaption>
                    </figure>
                </a>
            </li>
        </ul>
    </nav>
    @endif
    <!-- Si pas authentifié -->
    @else
    <footer>
        © <span>vino</span> 2023. (version 1.1) - Tous droits réservés.
    </footer>
    @endauth
</body>
</html>