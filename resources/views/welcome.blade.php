@extends('layouts.app')
@section('title', 'Bienvenue')
@section('content')
<header>
    vino
</header>
@auth
@if(Auth::user()->hasRole("Admin"))
<!-- En attendant -->
<main class="nav-margin">
    <h1>Bienvenue sur l'interface d'administration {{ Auth::user()->nom}}!</h1>
</main>
@else
<main class="nav-margin">
    <h1>Bonjour {{ Auth::user()->nom }}!</h1>
    <section>
        <h2>Mes celliers</h2>
        <div class="card-container-stats">
            <div class="card-container-total">
                <h3>total</h3>
                <div>
                    <span>{{ number_format($totalPrixCelliers, 2, '.', '') }} $</span>
                </div>
            </div>
            <div class="card-container-qt">
                <h3>quantité</h3>
                <div>
                    <span>{{ $totalQuantiteCelliers }} x 
                        <svg width="12" height="30" viewBox="0 0 12 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.64 1.25C6.38 1.25 6.94 1.33 7.29 1.4V11.01C7.29 11.26 7.45 11.47 7.68 11.54C7.78 11.57 7.89 11.61 7.99 11.65C8.16 11.72 8.33 11.81 8.49 11.91C8.65 12.01 8.79 12.12 8.93 12.25C9.61 12.86 10.03 13.75 10.03 14.71V24.65C10.03 25.5 9.69 26.33 9.09 26.93C9.04 26.98 8.99 27.03 8.93 27.07C8.79 27.2 8.64 27.31 8.48 27.4C8.32 27.5 8.14 27.59 7.95 27.65C7.59 27.8 7.2 27.87 6.81 27.87H4.47C3.61 27.87 2.8 27.54 2.19 26.93C1.58 26.32 1.25 25.5 1.25 24.65V14.71C1.25 13.26 2.22 11.96 3.6 11.54C3.84 11.47 4 11.26 4 11.01V1.4C4.34 1.33 4.91 1.25 5.64 1.25ZM5.64 0C4.74 0 4.07 0.11 3.75 0.18L2.75 0.39V10.52C1.1 11.24 0 12.89 0 14.71V24.65C0 25.83 0.48 26.98 1.31 27.81C2.15 28.65 3.28 29.12 4.47 29.12H6.81C7.36 29.12 7.89 29.02 8.38 28.82C8.63 28.74 8.88 28.62 9.12 28.47C9.33 28.35 9.53 28.2 9.72 28.04C9.83 27.95 9.92 27.87 9.97 27.81C10.8 26.98 11.28 25.83 11.28 24.65V14.71C11.28 13.42 10.73 12.18 9.76 11.32C9.57 11.15 9.37 10.99 9.15 10.85C8.95 10.72 8.74 10.61 8.54 10.53V0.37L7.54 0.17C7.14 0.0900001 6.49 0 5.64 0Z" fill="black"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="btn-container">
            <a href="{{ route('cellier.index') }}" class="btn-arrow btn-round">
                Voir mes celliers
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.83728 7C1.285 7 0.83728 7.44772 0.83728 8C0.83728 8.55228 1.285 9 1.83728 9L1.83728 7ZM18.5986 8.70711C18.9891 8.31658 18.9891 7.68342 18.5986 7.29289L12.2347 0.928933C11.8441 0.538409 11.211 0.538409 10.8205 0.928933C10.4299 1.31946 10.4299 1.95262 10.8205 2.34315L16.4773 8L10.8204 13.6569C10.4299 14.0474 10.4299 14.6805 10.8204 15.0711C11.211 15.4616 11.8441 15.4616 12.2347 15.0711L18.5986 8.70711ZM1.83728 9L17.8915 9L17.8915 7L1.83728 7L1.83728 9Z" fill="white"/>
                </svg>
            </a>
        </div>
    </section>
    <section>
        <h2>Mes listes d'achats</h2>
        <div class="card-container-stats">
            <div class="card-container-total">
                <h3>total</h3>
                <div>
                    <span>{{ number_format($totalPrixListes, 2) }}</span>
                </div>
            </div>
            <div class="card-container-qt">
                <h3>quantité</h3>
                <div>
                    <span>{{ $totalQuantiteListes }} x 
                        <svg width="12" height="30" viewBox="0 0 12 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.64 1.25C6.38 1.25 6.94 1.33 7.29 1.4V11.01C7.29 11.26 7.45 11.47 7.68 11.54C7.78 11.57 7.89 11.61 7.99 11.65C8.16 11.72 8.33 11.81 8.49 11.91C8.65 12.01 8.79 12.12 8.93 12.25C9.61 12.86 10.03 13.75 10.03 14.71V24.65C10.03 25.5 9.69 26.33 9.09 26.93C9.04 26.98 8.99 27.03 8.93 27.07C8.79 27.2 8.64 27.31 8.48 27.4C8.32 27.5 8.14 27.59 7.95 27.65C7.59 27.8 7.2 27.87 6.81 27.87H4.47C3.61 27.87 2.8 27.54 2.19 26.93C1.58 26.32 1.25 25.5 1.25 24.65V14.71C1.25 13.26 2.22 11.96 3.6 11.54C3.84 11.47 4 11.26 4 11.01V1.4C4.34 1.33 4.91 1.25 5.64 1.25ZM5.64 0C4.74 0 4.07 0.11 3.75 0.18L2.75 0.39V10.52C1.1 11.24 0 12.89 0 14.71V24.65C0 25.83 0.48 26.98 1.31 27.81C2.15 28.65 3.28 29.12 4.47 29.12H6.81C7.36 29.12 7.89 29.02 8.38 28.82C8.63 28.74 8.88 28.62 9.12 28.47C9.33 28.35 9.53 28.2 9.72 28.04C9.83 27.95 9.92 27.87 9.97 27.81C10.8 26.98 11.28 25.83 11.28 24.65V14.71C11.28 13.42 10.73 12.18 9.76 11.32C9.57 11.15 9.37 10.99 9.15 10.85C8.95 10.72 8.74 10.61 8.54 10.53V0.37L7.54 0.17C7.14 0.0900001 6.49 0 5.64 0Z" fill="black"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="btn-container">
            <a href="{{ route('liste.index') }}" class="btn-arrow btn-round">
                Voir mes liste d'achats
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.83728 7C1.285 7 0.83728 7.44772 0.83728 8C0.83728 8.55228 1.285 9 1.83728 9L1.83728 7ZM18.5986 8.70711C18.9891 8.31658 18.9891 7.68342 18.5986 7.29289L12.2347 0.928933C11.8441 0.538409 11.211 0.538409 10.8205 0.928933C10.4299 1.31946 10.4299 1.95262 10.8205 2.34315L16.4773 8L10.8204 13.6569C10.4299 14.0474 10.4299 14.6805 10.8204 15.0711C11.211 15.4616 11.8441 15.4616 12.2347 15.0711L18.5986 8.70711ZM1.83728 9L17.8915 9L17.8915 7L1.83728 7L1.83728 9Z" fill="white"/>
                </svg>
            </a>
        </div>
    </section>
    <section>
        <h2>Derniers ajouts</h2>
        <div class="carousel-container">
            <div class="carousel-slides">
                <div class="carousel-slide">
                    <img src="https://www.saq.com/media/catalog/product/1/1/11794344-1_1637193034.png" alt="Produit 1" />
                    <a href="#">Titre Produit 1</a>
                </div>
                <div class="carousel-slide">
                    <img src="https://www.saq.com/media/catalog/product/1/1/11888682-1_1606406165.png" alt="Produit 2" />
                    <a href="#">Titre Produit 2</a>
                </div>
                <div class="carousel-slide">
                    <img src="https://www.saq.com/media/catalog/product/1/5/15179138-1_1697549583.png" alt="Produit 2" />
                    <a href="#">Titre Produit 3</a>
                </div>
            </div>
            <button class="carousel-btn btn-prev">‹</button>
            <button class="carousel-btn btn-next">›</button>
        </div>
    </section>
    <div>
        <p>Pour trouver un SAQ le plus proche,<br>
            consulter ce lien externe Google Maps:</p>
        <a href="https://www.google.com/maps/search/saq/" class="link" target="_blank">
            Localiser un saq 
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.85709 0.642858C6.85709 0.472361 6.92482 0.308848 7.04538 0.188289C7.16594 0.0677295 7.32945 0 7.49995 0L11.3571 0C11.5337 0 11.694 0.0711429 11.8105 0.186857L11.8114 0.188572L11.8131 0.189429C11.933 0.309836 12.0002 0.472924 12 0.642858V4.50001C12 4.6705 11.9322 4.83401 11.8117 4.95457C11.6911 5.07513 11.5276 5.14286 11.3571 5.14286C11.1866 5.14286 11.0231 5.07513 10.9025 4.95457C10.782 4.83401 10.7142 4.6705 10.7142 4.50001V2.19429L5.38281 7.52572C5.26094 7.63928 5.09976 7.7011 4.93321 7.69816C4.76667 7.69522 4.60777 7.62775 4.48999 7.50997C4.3722 7.39219 4.30474 7.23328 4.3018 7.06674C4.29886 6.9002 4.36068 6.73901 4.47423 6.61715L9.80567 1.28572H7.49995C7.32945 1.28572 7.16594 1.21799 7.04538 1.09743C6.92482 0.976868 6.85709 0.813354 6.85709 0.642858Z" fill="black" stroke="black" stroke-width="0.000359551"/>
                <path d="M1.92857 3.00007C1.75808 3.00007 1.59456 3.0678 1.474 3.18836C1.35344 3.30892 1.28572 3.47243 1.28572 3.64293V10.0715C1.28572 10.4264 1.57372 10.7144 1.92857 10.7144H8.35715C8.52765 10.7144 8.69116 10.6466 8.81172 10.5261C8.93228 10.4055 9.00001 10.242 9.00001 10.0715V6.64293C9.00001 6.47244 9.06774 6.30892 9.1883 6.18836C9.30886 6.0678 9.47237 6.00007 9.64287 6.00007C9.81336 6.00007 9.97688 6.0678 10.0974 6.18836C10.218 6.30892 10.2857 6.47244 10.2857 6.64293V10.0715C10.2857 10.583 10.0825 11.0735 9.72086 11.4352C9.35918 11.7969 8.86864 12.0001 8.35715 12.0001H1.92857C1.41708 12.0001 0.926544 11.7969 0.564866 11.4352C0.203188 11.0735 0 10.583 0 10.0715V3.64293C0 3.13144 0.203188 2.6409 0.564866 2.27922C0.926544 1.91754 1.41708 1.71436 1.92857 1.71436H5.35715C5.52764 1.71436 5.69116 1.78208 5.81172 1.90264C5.93228 2.0232 6.00001 2.18672 6.00001 2.35721C6.00001 2.52771 5.93228 2.69122 5.81172 2.81178C5.69116 2.93234 5.52764 3.00007 5.35715 3.00007H1.92857Z" fill="black" stroke="black" stroke-width="0.000359551"/>
            </svg>
        </a>
    </div>
    <script src="{{ asset('js/carousel.js') }}"></script>
</main>
@endif
@else
<main>
    <div class="welcome">
        <h1 class="welcome-title">Bienvenue chez <span class="welcome-vino">vino</span>!</h1>
        <p class="welcome-text">L'outil le plus simple et efficace pour gérer vos celliers et vos achats SAQ.</p>
    </div>
    <picture class="welcome-image-container">
        <img src="{{ asset('assets/img/img_connexion.jpeg') }}" alt="Bouteille au marché" class="welcome-img">
    </picture>
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    @if(isset($successMessage))
        <div>
            {{ $successMessage }}
        </div>
    @endif
    @if($errors->has('erreur'))
        <div>
            {{ $errors->first('erreur') }}
        </div>
    @endif
    <div class="form-container">
        <form action="{{ route('login.authentication') }}" method="post" id="login">
            @csrf
            <div class="form-input-container">
                <label for="email">EMAIL</label>
                <input type="text" id="email" name="email">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-input-container">
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-forgot-psw link">
                <a href="{{ route('password.forgot') }}">MOT DE PASSE OUBLIÉ</a>
            </div>
            <button type="submit" form="login" class="btn-submit">CONNECTER</button>
            <div class="link">
                <a href="{{ route('register') }}">CRÉER UN COMPTE</a>
            </div>
        </form>
    </div>
</main>
@endauth
@endsection