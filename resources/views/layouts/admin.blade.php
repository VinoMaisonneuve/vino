<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/dox8qou.css">
    <title>Vino - @yield('title')</title>
</head>
<body>
    <nav class="main-nav">
        <ul class="main-nav-list">
            <li class="main-nav-item">        
                <a href="{{ route('welcome') }}">
                    <figure class="container-icons-navbar active">
                        <img src="{{ asset('assets/icons/admin_users_icon.svg') }}" alt="Utilisateurs">
                        <figcaption>Utilisateurs</figcaption>
                    </figure>
                </a>
            </li>
            <li class="main-nav-item">        
                <a href="{{ route('bouteille.index') }}">
                    <figure class="container-icons-navbar">
                        <img src="{{ asset('assets/icons/add_icon.svg') }}" alt="Bouteilles">
                        <figcaption class="icons-label">Bouteilles</figcaption>
                    </figure>
                </a>
            </li>
            <li class="main-nav-item">
                <a href="{{ route('stats.index') }}">
                    <figure class="container-icons-navbar">
                        <img src="{{ asset('assets/icons/admin_stats_icon.svg') }}" alt="Statistiques">
                        <figcaption>Statistiques</figcaption>
                    </figure>
                </a>
            </li>
            <li class="main-nav-item">         
                <a href="{{ route('profil.show', Auth::user()->id) }}">
                    <figure class="container-icons-navbar">
                        <img src="{{ asset('assets/icons/profile_icon.svg') }}" alt="Profil">
                        <figcaption>Profil</figcaption>
                    </figure>
                </a>
            </li>
        </ul>
    </nav>
    @yield('content')
</body>
</html>
