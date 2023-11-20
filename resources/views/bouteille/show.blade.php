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
            <section class="card-bouteille fiche-main-info {{ $bouteille->couleur == 'Blanc' ? 'bg-jaune' : ($bouteille->couleur == 'Rouge' ? 'bg-rouge' : ($bouteille->couleur == 'Rosé' ? 'bg-rose' : '')) }}">
                <picture class="fiche-picture" id="zoomableImage">
                    <img src="{{ $bouteille->srcImage }}" alt="{{ $bouteille->nom }}" class="zoomable-image">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.25 9.75H9.75M9.75 9.75H12.25M9.75 9.75V7.25M9.75 9.75V12.25" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 16L21 21" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 9.75C1 14.5825 4.91751 18.5 9.75 18.5C12.1704 18.5 14.3614 17.5173 15.9454 15.929C17.524 14.3461 18.5 12.162 18.5 9.75C18.5 4.91751 14.5825 1 9.75 1C4.91751 1 1 4.91751 1 9.75Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
                        <h2>{{ $bouteille->nom}}</h2>
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}}  $</p>
                    </div>
                    <a href="#" class="btn-ajouter" data-bouteille-id="{{ $bouteille->id }}">+ Ajouter</a>
                </div>
            </section>
            <table>
                <tbody>
                    <tr>
                        <th>Producteur</th>
                        <td>{{$bouteille->producteur ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Région</th>
                        <td>{{$bouteille->region ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Désignation réglementée</th>
                        <td>{{$bouteille->designation ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Agent promotionnel</th>
                        <td>{{$bouteille->agentPromotion ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Cépage</th>
                        <td>{{ $bouteille->cepage ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Degré d'alcool</th>
                        <td>{{$bouteille->degre ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Taux de sucre</th>
                        <td>{{$bouteille->tauxSucre ?? '-'}}</td>
                    </tr>
                    <!-- <tr>
                        <th>Appellation</th>
                        <td>{{ $bouteille->nom ?? '-'}}</td>
                    </tr>
                        <tr>
                        <th>Millésime</th>
                        <td>{{$bouteille->millesime ?? '-'}}</td>
                    </tr> -->
                    <!-- <tr>
                        <th>Couleur</th>
                        <td>{{$bouteille->couleur ?? '-'}}</td>
                    </tr> -->

                    <!-- <tr>
                        <th>Type</th>
                        <td>{{$bouteille->type ?? '-'}}</td>
                    </tr> -->
                    <!-- <tr>
                        <th>Pastille de goût</th>
                        <td>{{$bouteille->pastilleGoutTitre ?? '-'}}</td>
                    </tr> -->
                    <tr>
                        <th>Disponibilité</th>
                        <td>            
                            <!-- <p>Consulter ce lien externe SAQ: <br> -->
                            <a href="{{ $bouteille->lienProduit }}" class="link" target="_blank">
                                Voir lien produit SAQ
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.85709 0.642858C6.85709 0.472361 6.92482 0.308848 7.04538 0.188289C7.16594 0.0677295 7.32945 0 7.49995 0L11.3571 0C11.5337 0 11.694 0.0711429 11.8105 0.186857L11.8114 0.188572L11.8131 0.189429C11.933 0.309836 12.0002 0.472924 12 0.642858V4.50001C12 4.6705 11.9322 4.83401 11.8117 4.95457C11.6911 5.07513 11.5276 5.14286 11.3571 5.14286C11.1866 5.14286 11.0231 5.07513 10.9025 4.95457C10.782 4.83401 10.7142 4.6705 10.7142 4.50001V2.19429L5.38281 7.52572C5.26094 7.63928 5.09976 7.7011 4.93321 7.69816C4.76667 7.69522 4.60777 7.62775 4.48999 7.50997C4.3722 7.39219 4.30474 7.23328 4.3018 7.06674C4.29886 6.9002 4.36068 6.73901 4.47423 6.61715L9.80567 1.28572H7.49995C7.32945 1.28572 7.16594 1.21799 7.04538 1.09743C6.92482 0.976868 6.85709 0.813354 6.85709 0.642858Z" fill="black" stroke="black" stroke-width="0.000359551"/>
                                    <path d="M1.92857 3.00007C1.75808 3.00007 1.59456 3.0678 1.474 3.18836C1.35344 3.30892 1.28572 3.47243 1.28572 3.64293V10.0715C1.28572 10.4264 1.57372 10.7144 1.92857 10.7144H8.35715C8.52765 10.7144 8.69116 10.6466 8.81172 10.5261C8.93228 10.4055 9.00001 10.242 9.00001 10.0715V6.64293C9.00001 6.47244 9.06774 6.30892 9.1883 6.18836C9.30886 6.0678 9.47237 6.00007 9.64287 6.00007C9.81336 6.00007 9.97688 6.0678 10.0974 6.18836C10.218 6.30892 10.2857 6.47244 10.2857 6.64293V10.0715C10.2857 10.583 10.0825 11.0735 9.72086 11.4352C9.35918 11.7969 8.86864 12.0001 8.35715 12.0001H1.92857C1.41708 12.0001 0.926544 11.7969 0.564866 11.4352C0.203188 11.0735 0 10.583 0 10.0715V3.64293C0 3.13144 0.203188 2.6409 0.564866 2.27922C0.926544 1.91754 1.41708 1.71436 1.92857 1.71436H5.35715C5.52764 1.71436 5.69116 1.78208 5.81172 1.90264C5.93228 2.0232 6.00001 2.18672 6.00001 2.35721C6.00001 2.52771 5.93228 2.69122 5.81172 2.81178C5.69116 2.93234 5.52764 3.00007 5.35715 3.00007H1.92857Z" fill="black" stroke="black" stroke-width="0.000359551"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
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

            <!-- Zoom de l'image (EN DEV - VICTOR) -->
            <dialog id="zoomModal" class="modal">
                <span class="modal-close" id="modalClose">×</span>
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
            <!-- <script src="{{ asset('js/modalSupprimer.js') }}"></script> -->
            <script src="{{ asset('js/zoom.js')  }}"></script>
        </main>
        @endsection
