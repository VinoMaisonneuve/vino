@extends('layouts.app')
@section('title','Ajouter')
@section('content')
<header>
    ajouter une bouteille
</header>
<main class="nav-margin">
    <section class="form-ajouter-bouteille">
        <div class="form-container">
            <form id="form-search" class="form-mb">
                <div class="form-input-container">
                    <label for="search-input">RECHERCHE</label>
                    <input type="search" id="search-input" name="search">
                </div>
            </form>
            
        </div>
        <div class="form-container">
            <form id="form-filter">
                <hr>
                <details>
                    <summary>Filtrer</summary>
                    <button type="button" id="reset-filters" class="btn-reset">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.87593 4.23905C3.00136 2.30224 5.0986 1 7.5 1C11.0899 1 14 3.91015 14 7.5C14 11.0899 11.0899 14 7.5 14C3.91015 14 1 11.0899 1 7.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 5H1V1" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Réinitialiser les filtres
                    </button>
                    <div class="form-input-container">
                        <label for="prix-range">Prix ($)</label>
                        <div class="form-range">
                            <div class="form-range-slider">
                                <span class="form-range-selected"></span>
                            </div>
                            <div class="form-range-input">
                                <input type="range" class="min" name="range-min" min="{{ $prixMin }}" max="{{ $prixMax }}" value="{{ $prixMin }}" step="0.01">
                                <input type="range" class="max" name="range-max" min="{{ $prixMin }}" max="{{ $prixMax }}" value="{{ $prixMax }}" step="0.01">
                            </div>
                            <div class="form-range-number">      
                                <div>
                                    <label for="min">Min</label>
                                    <input type="number" id="min" name="prix-min" value="{{ $prixMin }}" step="0.01">
                                </div>    
                                <div>
                                    <label for="max">Max</label>
                                    <input type="number" id="max" name="prix-max" value="{{ $prixMax }}" step="0.01">
                                </div>    
                            </div>
                        </div>  
                    </div>

                    <!-- Couleur -->
                    <div class="form-input-container">
                        <label for="select_couleur">Couleur</label>
                        <select name="couleur" id="select_couleur">
                            <option value="">Choisir des options</option>
                            @foreach($couleurs as $couleur)
                                <option value="{{ $couleur }}">{{ $couleur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pays -->
                    <div class="form-input-container">
                        <label for="select_pays">Pays</label>
                        <select name="pays" id="select_pays">
                            <option value="">Choisir des options</option>
                            @foreach($pays as $paysOne)
                                <option value="{{ $paysOne }}">{{ $paysOne }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Format -->
                    <div class="form-input-container">
                        <label for="select_format">Format</label>
                        <select name="format" id="select_format">
                            <option value="">Choisir des options</option>
                            @foreach($formats as $format)
                                <option value="{{ $format }}">{{ $format }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Désignation -->
                    <div class="form-input-container">
                        <label for="select_designation">Désignation</label>
                        <select name="designation" id="select_designation">
                            <option value="">Choisir des options</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation }}">{{ $designation }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Producteur -->
                    <div class="form-input-container">
                        <label for="select_producteur">Producteur</label>
                        <select name="producteur" id="select_producteur">
                            <option value="">Choisir des options</option>
                            @foreach($producteurs as $producteur)
                                <option value="{{ $producteur }}">{{ $producteur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Agent Promotion -->
                    <div class="form-input-container">
                        <label for="select_agentPromotion">Agent promotionnel</label>
                        <select name="agentPromotion" id="select_agentPromotion">
                            <option value="">Choisir des options</option>
                            @foreach($agentPromotions as $agentPromotion)
                                <option value="{{ $agentPromotion }}">{{ $agentPromotion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Millésime -->
                    <div class="form-input-container">
                        <label for="select_millesime">Millésime</label>
                        <select name="millesime" id="select_millesime">
                            <option value="">Choisir des options</option>
                            @foreach($millesimes as $millesime)
                                <option value="{{ $millesime }}">{{ $millesime }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cépage -->
                    <div class="form-input-container">
                        <label for="select_cepage">Cépage</label>
                        <select name="cepage" id="select_cepage">
                            <option value="">Choisir des options</option>
                            @foreach($cepages as $cepage)
                                <option value="{{ $cepage }}">{{ $cepage }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Région -->
                    <div class="form-input-container">
                        <label for="select_region">Région</label>
                        <select name="region" id="select_region">
                            <option value="">Choisir une option</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                </details>                        
                <div id="tag-container" class="tag-container">
                </div>
            </form>
        </div>
        <div class="form-container">
            <hr>
            <form>
                <div class="form-input-container">
                    <label for="sort">TRIER</label>
                    <select name="sort" id="sort">
                        <option value="name-asc">Nom du produit (A-Z)</option>
                        <option value="name-desc">Nom du produit (Z-A)</option>
                        <option value="price-asc">Prix ($-$$$)</option>
                        <option value="price-desc">Prix ($$$-$)</option>
                    </select>
                </div>
            </form>
        </div>
    </section>
    <div class="card-container">
        <div id="search-results" class="card-results-container">
            <div class="card-count">
                <p>{{$bouteilles->total()}} bouteilles :</p>
            </div>

            @include('partials.bouteilles')

            @foreach ($bouteilles as $bouteille)
            <section class="card-bouteille">
                <picture>
                    <img src="{{ $bouteille->srcImage }}" height="120" width="80" loading="lazy" alt="{{ $bouteille->nom}}">
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
            
                            <h2><a href="{{ route('bouteille.show',['bouteille_id'=> $bouteille->id]) }}">{{ $bouteille->nom }}</a></h2>
            
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}} $</p>
                    </div>
                    @if(!Auth::user()->hasRole("Admin"))
                    <a href="#" class="btn-ajouter" data-bouteille-id="{{ $bouteille->id }}">+ Ajouter</a>
                    @endif
                </div>
            </section>
            @endforeach
            <div id="pagination">
                {{ $bouteilles->onEachSide(2)->links() }}
            </div>
        </div>
    </div>
<!-- Fenêtre modale de confirmation d'ajout -->
<dialog id="modal-ajouter" class="modal">
    <h2>Confirmation d'ajout</h2>
    <hr>
    <form class="form-modal" id="form-ajouter">
        <div class="form-radio">
            <input type="radio" id="location-cellier" name="location" checked >
            <label for="location-cellier">Celliers</label><br>
        </div>
        <div class="form-radio">
            <input type="radio" id="location-liste" name="location">
            <label for="location-liste">Listes</label>
        </div>
        <div class="form-input-container">
            <label for="select-location" id="label-location">Choisir le cellier</label>
            <select name="select-location" id="select-location">
                @forelse ($celliers as $cellier)
                    <option value="{{ $cellier->id }}">{{ $cellier->nom }}</option>
                @empty 
                    <option value="">Vous n'avez aucun cellier</option>
                @endforelse
            </select>
        </div>
        <div class="card-bouteille-qt">
            <button class="btn-decrement">-</button>
            <input type="text" value="1" min="1" id="quantite-bouteille" readonly>
            <button class="btn-increment">+</button>
        </div>
        <div class="btn-modal-container">
            <button class="btn-modal-action">ajouter</button>
            <button class="btn-modal-cancel">annuler</button>
        </div>
    </form>
</dialog>
<!-- Scripts JavaScript -->
<script src="{{ asset('js/queryBottles.js') }}" defer></script>
<script src="{{ asset('js/bottleCounterModal.js') }}" defer></script>
<script src="{{ asset('js/modalAjouterBouteilleIndex.js') }}" defer></script>
<script src="{{ asset('js/filterSlider.js') }}" defer></script>

</main>
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
    <span id="snackbar-message"></span> <!-- Élément pour le message toast -->
</div>
@endsection