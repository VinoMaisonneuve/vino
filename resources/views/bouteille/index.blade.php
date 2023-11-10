@extends('layouts.app')
@section('title','Recherche')
@section('content')

<body>
        <header>
            ajouter une bouteille
        </header>
        <main class="nav-margin">
            <section class="form-ajouter-bouteille"> <!-- encadré noir (formulaires, filtres et tris) --> 
                <div class="form-container">
                    <form action="{{ route('bouteille.index') }}" method="GET" id="searchForm">
                          @csrf  
                        <div class="form-input-container">
                            <label for="search">RECHERCHE</label>
                            <input type="text" id="search" name="search" value="{{Request::input('search')}}">
                        </div>
                        {{--
                         <hr>
                         <details>
                            <summary>Filtrer</summary>
                            <div class="form-input-container">
                                <label for="couleur">Couleur</label>
                                <select name="couleur" id="couleur" class="filter-select">
                                    <option value="">Choisir les options</option>
                                    @foreach($couleurs as $couleur)
                                        <option value="{{ $couleur }}" @if(Request::input('couleur') == $couleur) selected @endif>{{ $couleur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="format">Format</label>
                                <select name="format" id="format">
                                    <option value="">Choisir les options</option>
                                    @foreach($formats as $format)
                                        <option value="{{ $format }}" @if(Request::input('format') == $format) selected @endif>{{ $format }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="prix">Prix</label>
                                <!-- <span>Erreur prix</span> -->
                                <div>
                                    <div>
                                        <label for="prix_min">Minimum</label>
                                        <input name="prix_min" id="prix_min" type="number"
                                               @if(Request::has('prix_min')) value="{{ Request::input('prix_min') }}" @endif>
                                        
                                    </div>
                                    <div>
                                        <label for="prix_max">Minimum</label>
                                        <input name="prix_max" id="prix_max" type="number"
                                            @if(Request::has('prix_max')) value="{{ Request::input('prix_max') }}" @endif>

                                    </div>
                                </div>
                            </div>
                            <div class="form-input-container">
                                <label for="country">Pays</label>
                                <select name="pays" id="pays">
                                    <option value="">Choisir les options</option>
                                    @foreach($lesPays as $pays)
                                        <option value="{{ $pays }}" @if(Request::input('pays') == $pays) selected @endif>{{ $pays }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="region">Région</label>
                                <select name="region" id="region">
                                    <option value="">Choisir les options</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region }}" @if(Request::input('region') == $region) selected @endif>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="millesime">Millésime</label>
                                <select name="millesime" id="millesime">
                                    <option value="">Choisir les options</option>
                                    @foreach($millesimes as $millesimeOption)
                                        <option value="{{ $millesimeOption }}" @if(Request::input('millesime') == $millesimeOption) selected @endif>{{ $millesimeOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="cepage">Cépage</label>
                                <label for="cepage">Cépage</label>
                                <select name="cepage" id="cepage">
                                    <option value="">Choisir les options</option>
                                    @foreach($cepages as $cepageOption)
                                        <option value="{{ $cepageOption }}" @if(Request::input('cepage') == $cepageOption) selected @endif>{{ $cepageOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </details>                  
                        <div class="tag-container"></div>
                    <hr>
                    --}}    
                    <div class="form-input-container">
                        <label for="sort">TRIER</label>
                        <select name="sort" id="sort">
                            <option >Choisir l'option de tri</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nom du produit (A-Z)</option>
                            <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nom du produit (Z-A)</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Prix ($-$$$)</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Prix ($$$-$)</option>
                        </select>
                </div>
                        
                        <button type="submit">Valider</button>
                    </form>
                    
                    
                </div>
                <div class="link link-right">
                    <a href="#">BOUTEILLE PERSONNALISÉE</a>
                </div>
               
            </section>
            <div class="card-count">
                <p>{{$bouteilles->total()}} bouteilles :</p> 
            </div>
            @foreach ($bouteilles as $bouteille)
            <section class="card-bouteille">
                <picture>
                    <img src="{{ $bouteille->srcImage }}" alt="{{ $bouteille->nom}}">
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
                       

                            <h2><a href="{{ route('bouteille.show',['bouteille_id'=> $bouteille->id]) }}" class="bottle-link">{{ $bouteille->nom }}</a></h2>

                           

                      
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}} $</p>
                    </div>
                    @if(!Auth::user()->hasRole("Admin"))
                    <a href="#" class="btn-ajouter" data-bouteille-id="{{ $bouteille->id }}">+ Ajouter</a>
                    @endif
                </div>
            </section>
          
            @endforeach  
             {{ $bouteilles->links() }}
        </section>
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
                                <div id="succes-ajouter"></div>
                                <div class="btn-modal-container">
                                    <button class="btn-modal-action">ajouter</button>
                                    <button class="btn-modal-cancel">annuler</button>
                                </div>
                        </form> 
                </dialog>
            <!-- </div> -->
          
            <script src="../../js/bottleCounterModal.js"></script>
            <script src="../../js/modalAjouter.js"></script>
            {{-- <script src="../../js/filterTag.js"></script>  
            <script src="../../js/sorting.js"></script> --}}
            <script src="{{asset('assets/js/search.js')}}" ></script>

           
        </main>
     

       
        
    {{-- <nav class="nav">
        <ul class="nav-list">
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container nav-active">
                        <img src="../../../public/assets/icons/home_icon.svg" alt="Accueil">
                        <figcaption>accueil</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/add_icon.svg" alt="Recherche">
                        <figcaption class="icons-label">ajouter</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/list_icon.svg" alt="Liste d'achats">
                        <figcaption>liste</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/cellars_icon.svg" alt="Celliers">
                        <figcaption>celliers</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">         
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/profile_icon.svg" alt="Profil">
                        <figcaption>profil</figcaption>
                    </figure>
                </a>
            </li>
        </ul>
    </nav>
</body>
</html> --}}
@section('scripts')
    <script src="{{ asset('asseets/js/index.js') }}"></script>
@endsection
    @endsection
</body>
</html>