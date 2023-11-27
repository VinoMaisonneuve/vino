<!-- Un cellier et ses bouteilles -->
@extends('layouts.app')
@section('title', 'Cellier')
@section('content')
<header>
    <a href="{{ route('cellier.index') }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black" />
        </svg>
        celliers
    </a>
</header>
<main class="nav-margin">
    <h1 class="btn-modify">{{ $cellier->nom }}
        @if ($cellier->nom != 'Favoris')
        <a href="{{ route('cellier.edit', $cellier->id) }}" aria-label="Modifier nom de cellier">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 15V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H7" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.5 14.8L21 5.2L16.8 1L7.3 10.5L7 15L11.5 14.8Z" stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        @endif
    </h1>
    <a href="{{ route('ajout.index', ['cellier_id' => $cellier->id] ) }}" class="btn-arrow btn-round">
        Ajouter une bouteille
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.83728 7C1.285 7 0.83728 7.44772 0.83728 8C0.83728 8.55228 1.285 9 1.83728 9L1.83728 7ZM18.5986 8.70711C18.9891 8.31658 18.9891 7.68342 18.5986 7.29289L12.2347 0.928933C11.8441 0.538409 11.211 0.538409 10.8205 0.928933C10.4299 1.31946 10.4299 1.95262 10.8205 2.34315L16.4773 8L10.8204 13.6569C10.4299 14.0474 10.4299 14.6805 10.8204 15.0711C11.211 15.4616 11.8441 15.4616 12.2347 15.0711L18.5986 8.70711ZM1.83728 9L17.8915 9L17.8915 7L1.83728 7L1.83728 9Z" fill="white" />
        </svg>
    </a>
    <div class="link link-right">
        <p>ou</p>
        <a href="{{ route('bouteille.create', $cellier->id) }}">AJOUTER BOUTEILLE PERSONNALISÉE</a>
    </div>
    @if($cellier->bouteillesCelliers->count() > 1 || $cellier->bouteillesPersonnaliseesCelliers->count() > 1)
    <div class="form-container">
        <form>
            <div class="form-input-container">
                <label for="search_cellar">RECHERCHE DANS LE CELLIER</label>
                <input type="text" id="search_cellar" placeholder="Nom">
            </div>
        </form>
        <!-- EN DEV - fonctionne, mais ne s'applique pas encore sur les résultats de search -->
        <!-- <form action="{{ route('cellier.show', ['cellier_id' => $cellier->id]) }}" >
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
        </form> -->
    </div>
    @endif
        <div class="card-count">
            <p>                
                @if($cellier->bouteillesCelliers->count() > 0 || $cellier->bouteillesPersonnaliseesCelliers->count() > 0)
                    {{ ($cellier->quantiteTotal + $cellier->quantiteTotalPersonnalisee) }} bouteille(s)
                @else 
                    Aucune bouteille
                @endif
            </p>
        </div>
        
        @if($cellier->bouteillesCelliers->count() > 0)
            @if($cellier->bouteillesPersonnaliseesCelliers->count() > 0)
            <div class="btn-cellier-container"  id="anchor-bouteilles-saq">
                <span><a class="btn-cellier" href="#anchor-bouteilles-perso">Voir Bouteilles personnalisées ↓</a></span>
            </div>
            @endif
            <div class="card-bouteille-label">
                <span>
                    Bouteilles SAQ :
                </span>
            </div>
        @endif
        </div>
        @foreach($cellier->bouteillesCelliers as $bouteillesCelliers)
        <section class="card-bouteille" id="{{ $bouteillesCelliers->id }}" data-location="celliers">
            <picture>
                <img src="{{ $bouteillesCelliers->bouteille->srcImage }}" height="120" width="80" alt="{{ $bouteillesCelliers->bouteille->nom }}">
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
                        {{ number_format($bouteillesCelliers->bouteille->prix, 2) }}$
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
    <br>
    @if($cellier->bouteillesPersonnaliseesCelliers->count() > 0)
        @if($cellier->bouteillesCelliers->count() > 0)
            <div class="btn-cellier-container" id="anchor-bouteilles-perso">
                <span><a class="btn-cellier" href="#anchor-bouteilles-saq">Voir Bouteilles SAQ ↑</a></span>
            </div>
        @endif
        <div class="card-bouteille-label">
            <span id="bouteilles-perso">
                Bouteilles personnalisées :
            </span>
        </div>
        @foreach($cellier->bouteillesPersonnaliseesCelliers as $bouteillesPersonnaliseesCelliers)
        <section class="card-bouteille" id="{{ $bouteillesPersonnaliseesCelliers->id }}" data-location="celliers">
            <picture>
                <img src="{{ asset('assets/img/bouteille_personnalisee.webp') }}" height="120" width="80" alt="{{ $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->nom }}">
            </picture>
            <div class="card-bouteille-content">
                <div class="card-bouteille-info">
                    <a href="{{ route('personnalisee.show', ['bouteille_id' => $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->id, 'cellier_id' => $cellier->id]) }}">
                        <h2 class="bottle-name">{{ $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->nom }}</h2>
                    </a>
                    <span>
                        {{ $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->type ?? 'Type N.D.' }} | {{ $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->format ?? 'Format N.D.' }} | {{ $bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->pays ?? 'Pays N.D.' }}
                    </span>
                    <p>
                        @if ($bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->prix)
                        {{ number_format($bouteillesPersonnaliseesCelliers->bouteillePersonnalisee->prix, 2) }} $
                        @else
                        Prix N.D.
                        @endif
                    </p>
                </div>
                <div class="card-bouteille-qt">
                    <button class="btn-decrement">-</button>
                    <input type="text" value="{{ $bouteillesPersonnaliseesCelliers->quantite }}" min="0" readonly data-bouteille-personnalisee="personnalisees">
                    <button class="btn-increment">+</button>
                    <form action="{{ route('bouteille.destroy', ['bouteille_personnalisee_cellier' => $bouteillesPersonnaliseesCelliers->id, 'cellier_id' => $cellier->id]) }}" class="form-delete" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </section>
        @endforeach
    @endif
    <script src="{{ asset('js/bottleCounter.js') }}"></script>
    @if($cellier->bouteillesCelliers->count() > 1 || ($cellier->bouteillesPersonnaliseesCelliers->count() > 1))
    <!-- EN DEV -->
    <!-- <script src="{{ asset('js/sortBottles.js') }}"></script> -->
    <script src="{{ asset('js/search-cellar.js') }}"></script>
    @endif
</main>
@if(session('success'))
<div id="snackbar">
    <svg width="35" height="34" viewBox="0 0 46 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M39.3583 19.0013C40.6562 21.6749 40.9157 24.4263 40.1111 27.2816C39.9813 27.7747 39.7477 28.2679 39.5141 28.7092C38.0864 31.1751 35.8282 31.4087 33.9334 29.2802C31.9347 27.0479 31.156 24.3744 31.13 20.8702C31.0781 19.832 31.3896 18.3265 32.1943 16.9508C33.1806 15.2376 34.8938 14.7963 36.6069 15.8087C37.8528 16.5874 38.7354 17.7035 39.3583 19.0013ZM35.6984 19.6243C35.7244 18.4563 34.9457 17.3142 34.167 17.392C33.1027 17.4959 32.921 18.2746 32.947 19.183C32.973 20.3511 33.5959 21.2596 34.4525 21.2336C35.5167 21.2077 35.6984 20.4549 35.6984 19.6243Z" fill="black"/>
        <path d="M23.4728 29.4362C23.4209 32.6289 22.6422 35.4062 20.7733 37.8202C17.8142 41.6099 13.0382 42.2329 9.14468 39.4295C5.66647 36.9636 3.87545 33.5374 3.4861 29.3583C3.22653 26.5809 3.3044 23.8555 4.47246 21.2079C7.27579 14.9523 14.2582 13.7064 19.0342 18.5603C22.0712 21.6751 23.395 25.361 23.4728 29.4362ZM18.1776 33.9786C19.4236 32.577 19.8908 30.9157 19.8389 29.0728C19.761 25.8282 18.8785 22.8691 16.6462 20.4032C13.8429 17.3403 9.63786 17.8335 7.84684 21.4415C5.71838 25.7503 7.48344 32.2136 11.5067 34.8611C13.8429 36.3666 16.3607 36.0292 18.1776 33.9786Z" fill="white"/>
        <path d="M11.3772 20.4551C12.4154 20.481 13.4797 21.8048 13.4537 23.0508C13.4278 24.1929 12.675 24.9975 11.6627 24.9975C10.5206 24.9975 9.48233 23.8035 9.50829 22.5316C9.53425 21.3895 10.3908 20.4551 11.3772 20.4551Z" fill="white"/>
        <path d="M34.1932 17.4182C34.9719 17.3403 35.7247 18.4564 35.7247 19.6504C35.7247 20.4811 35.543 21.2338 34.4788 21.2598C33.6222 21.2857 32.9992 20.3772 32.9733 19.2092C32.9473 18.3007 33.103 17.522 34.1932 17.4182Z" fill="white"/>
        <path d="M43.7192 25.7502C43.7451 27.7489 43.226 30.1629 41.8762 32.3692C39.9554 35.51 36.3215 36.0291 33.622 33.5373C31.9867 32.0318 31.0263 30.1369 30.3774 28.0344C29.4689 25.1013 29.2612 22.1163 29.6765 19.0794C29.7804 18.3526 29.9621 17.6258 30.2216 16.9509C31.9088 12.2527 36.2696 11.3442 39.7737 14.9782C42.5251 17.8075 43.6932 21.2597 43.7192 25.7502ZM40.1112 27.3076C40.9158 24.4524 40.6563 21.675 39.3584 19.0274C38.7355 17.7296 37.8529 16.6135 36.581 15.8607C34.8679 14.8484 33.1547 15.2897 32.1684 17.0028C31.3637 18.3785 31.0522 19.884 31.1042 20.9223C31.1301 24.4265 31.9348 27.1 33.9075 29.3323C35.8023 31.4607 38.0606 31.2012 39.4882 28.7612C39.7737 28.2681 39.9814 27.8008 40.1112 27.3076Z" fill="white"/>
        <path d="M25.9648 29.8774C25.835 33.5893 24.9265 37.1453 22.201 40.2342C19.0862 43.7643 13.5055 44.8285 9.3005 42.6741C4.93976 40.4418 2.68152 36.756 1.48751 32.1616C0.682849 29.0468 0.864546 25.9839 1.51347 22.947C2.34408 19.2352 4.44658 16.328 7.76905 14.4331C11.6366 12.2009 17.3471 13.3949 20.7474 16.8212C24.3554 20.3772 25.835 24.738 25.9648 29.8774ZM20.7474 37.8202C22.6163 35.4322 23.395 32.6288 23.4469 29.4362C23.3691 25.361 22.0453 21.6751 19.0343 18.5862C14.2582 13.7064 7.27587 14.9523 4.47254 21.2338C3.30448 23.8555 3.22661 26.6069 3.48618 29.3842C3.84957 33.5633 5.66655 36.9636 9.1188 39.4555C13.0383 42.2329 17.7884 41.6099 20.7474 37.8202Z" fill="black"/>
        <path d="M41.5389 5.91922C41.6427 6.54219 41.5648 7.1392 40.9678 7.52855C40.3708 7.9179 39.8257 7.78811 39.3066 7.3728C37.4636 5.97114 35.5428 4.80308 33.1289 4.62138C31.0264 4.43969 30.1698 5.01074 29.5728 7.06132C29.3132 7.9179 28.8979 8.72256 27.8596 8.74852C26.8733 8.77447 26.3022 8.0996 25.9388 7.26898C25.1601 5.452 26.1984 2.46697 28.0154 1.35083C29.5209 0.416389 31.1561 -0.0248758 33.5701 0.00108098C36.4513 0.312562 39.3585 1.6104 41.1236 4.855C41.3052 5.16648 41.461 5.52987 41.5389 5.91922Z" fill="black"/>
        <path d="M19.8393 29.0728C19.8912 30.9157 19.424 32.577 18.178 33.9786C16.3351 36.0292 13.8432 36.3667 11.5331 34.8612C7.50979 32.2136 5.74473 25.7503 7.87319 21.4415C9.6642 17.8335 13.8692 17.3144 16.6725 20.4032C18.9048 22.8691 19.7873 25.8282 19.8393 29.0728ZM13.4539 23.0508C13.4799 21.8049 12.4156 20.4811 11.3774 20.4551C10.391 20.4292 9.53442 21.3896 9.50846 22.5317C9.48251 23.8036 10.5208 24.9716 11.6629 24.9976C12.6752 25.0235 13.4539 24.1929 13.4539 23.0508Z" fill="black"/>
        <path d="M16.7241 7.84004C17.1135 8.77449 17.1914 9.70893 16.2569 10.4098C15.5301 10.9808 14.8033 11.0327 13.9987 10.4357C10.9358 8.20344 7.69119 8.61875 5.19934 11.5259C4.70616 12.1229 4.23894 12.7459 3.74576 13.3429C3.14875 14.0956 2.44792 14.6926 1.4356 14.2254C0.423288 13.7582 -0.0698898 12.9795 0.00798056 11.6297C0.189678 6.93155 6.21165 2.64869 11.3251 3.81674C13.7132 4.36183 15.7118 5.45202 16.7241 7.84004Z" fill="black"/>
        <path d="M45.8995 23.6995C46.3148 27.5411 45.4322 31.0972 43.4336 34.4456C40.76 38.9102 34.1151 38.7544 30.8445 34.3418C28.0672 30.604 27.3144 25.9837 27.2365 21.0779C27.1587 19.0792 27.6778 16.4835 29.1054 14.1215C31.3377 10.4096 34.9457 9.73476 38.7613 11.5777C43.797 14.0176 45.3544 18.612 45.8995 23.6995ZM41.8762 32.3431C43.2259 30.1368 43.745 27.7228 43.7191 25.7241C43.6931 21.2596 42.5251 17.7814 39.7477 14.9261C36.2435 11.3181 31.8828 12.2007 30.1956 16.8988C29.962 17.5737 29.7543 18.3005 29.6505 19.0273C29.2352 22.0642 29.4429 25.0493 30.3514 27.9824C31.0003 30.0849 31.9607 31.9797 33.5959 33.4852C36.3214 36.003 39.9813 35.4839 41.8762 32.3431Z" fill="black"/>
    </svg>
    <span id="snackbar-message">{{ session('success') }}</span>
</div>
<script src="{{ asset('js/showToast.js')  }}"></script>
@endif
@endsection