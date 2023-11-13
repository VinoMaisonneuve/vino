<!-- Un cellier et ses bouteilles -->
@extends('layouts.app')
@section('title', 'Cellier')
@section('content')
    <header>
        <a href="{{ route('cellier.index') }}" class="btn-arrow-top">
            <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
            </svg>
            celliers
        </a>
    </header>
    <main class="nav-margin">
        <h1 class="btn-modify">{{ $cellier->nom }}
            <a href="{{ route('cellier.edit', $cellier->id) }}">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 15V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H7" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.5 14.8L21 5.2L16.8 1L7.3 10.5L7 15L11.5 14.8Z" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </h1>
        <a href="{{ route('bouteille.index') }}" class="btn-arrow btn-round">
            Ajouter une bouteille
            <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.83728 7C1.285 7 0.83728 7.44772 0.83728 8C0.83728 8.55228 1.285 9 1.83728 9L1.83728 7ZM18.5986 8.70711C18.9891 8.31658 18.9891 7.68342 18.5986 7.29289L12.2347 0.928933C11.8441 0.538409 11.211 0.538409 10.8205 0.928933C10.4299 1.31946 10.4299 1.95262 10.8205 2.34315L16.4773 8L10.8204 13.6569C10.4299 14.0474 10.4299 14.6805 10.8204 15.0711C11.211 15.4616 11.8441 15.4616 12.2347 15.0711L18.5986 8.70711ZM1.83728 9L17.8915 9L17.8915 7L1.83728 7L1.83728 9Z" fill="white"/>
            </svg>
        </a>
        @if($cellier->bouteillesCelliers->count() > 1)
        <div class="form-container" >
            <form action="">
                <div class="form-input-container">
                    <label for="search_cellar">RECHERCHE</label>
                    <input type="text" id="search_cellar" placeholder="Nom">
                </div>
            </form>
        </div>
        <div class="form-container">
            <form action="{{ route('cellier.show', ['cellier_id' => $cellier->id]) }}" method="">
                @csrf
                <div class="form-input-container">
                    <label for="sortCellier">TRIER</label>
                    <select id="sortCellier">
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nom du produit (A-Z)</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nom du produit (Z-A)</option>
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Prix ($-$$$)</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Prix ($$$-$)</option>
                    </select>
                </div>
            </form>
        </div>
        @endif
        <div class="card-count">
            <p>                
                @if($cellier->bouteillesCelliers->count() > 0)
                    {{ $cellier->quantiteTotal }} bouteille(s)
                @else 
                    Aucune bouteille
                @endif
            </p>
        </div>
        @foreach($cellier->bouteillesCelliers as $bouteillesCelliers)
        <section class="card-bouteille" id="{{ $bouteillesCelliers->id }}" data-location="celliers">
            <picture>
                <img src="{{ $bouteillesCelliers->bouteille->srcImage }}" alt="{{ $bouteillesCelliers->bouteille->nom }}">
            </picture>
            <div class="card-bouteille-content">
                <div class="card-bouteille-info">
                    <a href="{{ route('bouteille.show', ['bouteille_id' => $bouteillesCelliers->bouteille->id]) }}">
                        <h2 class="bottle-name">{{ $bouteillesCelliers->bouteille->nom }}</h2>
                    </a>
                    <span>
                        {{ $bouteillesCelliers->bouteille->type }} | {{ $bouteillesCelliers->bouteille->format }} | {{ $bouteillesCelliers->bouteille->pays }}
                    </span>
                    <p>
                        {{ number_format($bouteillesCelliers->bouteille->prix * $bouteillesCelliers->quantite, 2) }}$
                    </p>
                </div>
                <div class="card-bouteille-qt">
                    <button class="btn-decrement">-</button>
                    <input type="text" value="{{ $bouteillesCelliers->quantite }}" min="0" readonly>
                    <button class="btn-increment">+</button>
                    <form action="{{ route('bouteilleCellier.delete', ['cellier_id' => $cellier->id, 'bouteille_cellier' => $bouteillesCelliers->id]) }}" class="form-delete" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </section>
        @endforeach
        
        <script src="{{ asset('js/sortBottles.js') }}"></script>
        <script src="{{ asset('js/bottleCounter.js') }}"></script>
        <script src="{{ asset('js/search-cellar.js') }}"></script>
    </main>
@endsection