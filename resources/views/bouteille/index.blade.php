@extends('layouts.app')
@section('title','Recherche')
@section('content')
    <header>
        ajouter une bouteille
    </header>
    <main class="nav-margin">
    <section class="form-ajouter-bouteille"> <!-- encadré noir (formulaires, filtres et tris) --> 
            <div class="form-container">
                <form action="" method="" id="form-search">
                    <!-- @csrf -->
                    <div class="form-input-container">
                        <label for="search">RECHERCHE</label>
                        <input type="search" id="search-input" name="search">
                    </div>
                </form>
                
            </div>
            <div class="link link-right">
                <a href="#">BOUTEILLE PERSONNALISÉE</a>
            </div>
            <div class="form-container">
                <form action="" method="" id="form-filter">
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
                        <!-- SLIDERS À IMPLÉMENTER (EN DEV - VICTOR)-->
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
                                        <input type="number" name="prix-min" value="{{ $prixMin }}" step="0.01">
                                    </div>    
                                    <div>
                                        <label for="max">Max</label>
                                        <input type="number" name="prix-max" value="{{ $prixMax }}" step="0.01">
                                    </div>    
                                </div>
                            </div>  
                        </div>
                        <!-- <div class="form-input-container">
                            <label for="alcohol-range">Degré d'alcool (%)</label>
                            <div class="form-range">
                                <div class="form-range-slider">
                                    <span class="form-range-selected"></span>
                                </div>
                                <div class="form-range-input">
                                    <input type="range" class="min" min="0" max="1000" value="0" step="1">
                                    <input type="range" class="max" min="0" max="1000" value="1000" step="1">
                                </div>
                                <div class="form-range-number">      
                                    <div>
                                        <label for="min">Min</label>
                                        <input type="number" name="min" value="0">
                                    </div>    
                                    <div>
                                        <label for="max">Max</label>
                                        <input type="number" name="max" value="1000">
                                    </div>    
                                </div>
                            </div>  
                        </div> -->
                        <!-- <div class="form-input-container">
                            <label for="sugar-range">Taux de sucre (g/L)</label>
                            <div class="form-range">
                                <div class="form-range-slider">
                                    <span class="form-range-selected"></span>
                                </div>
                                <div class="form-range-input">
                                    <input type="range" class="min" min="0" max="1000" value="0" step="1">
                                    <input type="range" class="max" min="0" max="1000" value="1000" step="1">
                                </div>
                                <div class="form-range-number">      
                                    <div>
                                        <label for="min">Min</label>
                                        <input type="number" name="min" value="0">
                                    </div>    
                                    <div>
                                        <label for="max">Max</label>
                                        <input type="number" name="max" value="1000">
                                    </div>    
                                </div>
                            </div>  
                        </div> -->

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
                            <label for="select_agentPromotion">Agent de promotion</label>
                            <select name="agentPromotion" id="select_agentPromotion">
                                <option value="">Choisir des options</option>
                                @foreach($agentPromotions as $agentPromotion)
                                    <option value="{{ $agentPromotion }}">{{ $agentPromotion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type -->
                        <!-- <div class="form-input-container">
                            <label for="select_type">Type</label>
                            <select name="type" id="select_type">
                                <option value="">Choisir des options</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div> -->

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
                <form action="" method="" id="">
                    <!-- @csrf -->
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
                        <img src="{{ $bouteille->srcImage }}" alt="{{ $bouteille->nom}}">
                    </picture>
                    <div class="card-bouteille-content">
                        <div class="card-bouteille-info">
                
                                <h2><a href="{{ route('bouteille.show',['bouteille_id'=> $bouteille->id]) }}">{{ $bouteille->nom }}</a></h2>
                
                            <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                            <p>{{$bouteille->prix}} $</p>
                        </div>
                        <a href="#" class="btn-ajouter" data-bouteille-id="{{ $bouteille->id }}">+ Ajouter</a>
                    </div>
                </section>
                @endforeach
                <div id="pagination">
                    {{ $bouteilles->onEachSide(2)->links() }}
                </div>
            </div>
        </div>

    </main>
        <!-- <div class="modal-container"> -->
            <dialog id="modal-ajouter" class="modal">
                    <h2>Confirmation d'ajout</h2>
                    <hr>
                    <form action="" class="form-modal" id="form-ajouter">
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
        <!-- </div> -->

        <script src="{{ asset('js/queryBottles.js') }}"></script>
        <script src="{{ asset('js/bottleCounterModal.js') }}"></script>
        <script src="{{ asset('js/modalAjouterBouteilleIndex.js') }}"></script>
        <script src="{{ asset('js/filterSlider.js') }}"></script>

        
    </main>
@endsection