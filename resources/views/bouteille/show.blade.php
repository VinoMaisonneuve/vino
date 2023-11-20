@extends('layouts.app')
@section('title','Recherche')
@section('content')
        <header>
            <a href="{{ route('bouteille.index') }}" class="btn-arrow-top">
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
                </svg>
                bouteilles
            </a>
        </header>
        <main class="nav-margin">
            <section class="card-bouteille fiche-main-info">
                <picture>
                    <img src="{{ $bouteille->srcImage }}" alt="{{ $bouteille->nom }}" class="zoomable-image" id="zoomableImage">
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
                        <a href="">
                            <h2>{{ $bouteille->nom}}</h2>
                        </a>
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}}  $</p>
                    </div>
                    @if(!Auth::user()->hasRole("Admin"))
                    <a href="#" class="btn-ajouter" data-bouteille-id="{{ $bouteille->id }}">+ Ajouter</a>
                    @endif
                </div>
            </section>
            <table>
                <tbody>
                    <tr>
                        <th>Appellation</th>
                        <td>{{ $bouteille->nom ?? '-'}}</td>
                    </tr>
                        <tr>
                        <th>Millésime</th>
                        <td>{{$bouteille->millesime ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Degré d'alcool</th>
                        <td>{{$bouteille->degre ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Couleur</th>
                        <td>{{$bouteille->couleur ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Producteur</th>
                        <td>{{$bouteille->producteur ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{$bouteille->type ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Cépage</th>
                        <td>{{ $bouteille->cepage ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Région</th>
                        <td>{{$bouteille->region ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Pastille de goût</th>
                        <td>{{$bouteille->pastilleGoutTitre ?? '-'}}</td>
                    </tr>
                </tbody>
            </table>
            @if(!Auth::user()->hasRole("Admin"))
            @if(!$commentaire)
            <section>
                <h2>Ajouter une note</h2>
                <form action="{{ route('comment.store', ['bouteille_id' => $bouteille->id]) }}" method="post" id="comment">
                    @csrf
                    <div class="form-input-container">
                        <label for="comment"></label>
                        <input type="text" id="body" name="comment" placeholder="NOTE">
                        @error('comment')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-button">
                        <button type="submit" class="btn-submit">ajouter</button>
                    </div>
                </form>
            </section>
            @else
            <section>
                <h2>Note</h2>
                @if(session()->has('successMessage'))
                    <div>
                        {{ session('successMessage') }}
                    </div>
                @endif
                <div class="form-container">
                    <form action="{{ route('comment.update', ['commentaire' => $commentaire->id]) }}" method="post" id="comment">
                        @csrf
                        @method('put')
                        <div class="form-input-container">
                            <label for="comment"></label>
                            <input type="text" id="body" name="comment" value="{{ $commentaire->corps }}">
                            @error('comment')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <p><span>Ajouté le: </span>{{ $commentaire->updated_at->setTimezone('America/Toronto') }}</p>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn-submit">modifier</button>
                        </div>
                    </form> 
                </div>
                <form action="{{ route('comment.destroy', ['commentaire' => $commentaire->id]) }}" method="post" id="supprimerCommentaire">
                    @method('delete')
                    @csrf
                    <div class="form-button">
                        <button type="submit" form="supprimerCommentaire" class="link btn-supprimer">supprimer</button>
                    </div>
                </form>
            </section>
            <!-- Modale suppression -->
            <dialog id="modal-supprimer" class="modal">
                <h2>Suppression de la note</h2>
                <hr>
                <p>Êtes-vous certain de vouloir supprimer la note?</p>
                <form action="{{ route('comment.destroy', ['commentaire' => $commentaire->id]) }}" method="post" class="form-modal" id="supprimerCommentaire">
                    @csrf
                    @method('DELETE')
                    <div class="btn-modal-container">
                        <button type="submit" form="supprimerCommentaire" class="btn-modal-action btn-red">oui, supprimer</button>
                        <button class="btn-modal-cancel btn-green">annuler</button>
                    </div>
                </form>
            </dialog>
            @endif
            @endif

            <!-- Zoom de l'image (EN DEV - VICTOR) -->
            <dialog id="zoomModal" class="modal">
                <span class="modal-close" id="modalClose">&times;</span>
                <img src="{{ $bouteille->bigImageUrl() }}" alt="{{ $bouteille->nom }}" class="modal-content">
            </dialog>

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

            <script src="../../js/bottleCounterModal.js"></script>
            <script src="../../js/modalAjouter.js"></script>
            <script src="{{ asset('js/modalSupprimer.js') }}"></script>
            <script src="{{ asset('js/zoom.js')  }}"></script> <!-- (EN DEV - VICTOR) -->
        </main>
        @endsection
