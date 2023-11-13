@extends('layouts.app')
@section('title','Recherche')
@section('content')
        <header>
            fiche bouteille
        </header>
        <main class="nav-margin">
            <section class="card-bouteille">
                <picture>
                    <img src="https://www.saq.com/media/catalog/product/1/1/11097477-1_1628019647.png" alt="">
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
                        <a href="">
                            <h2>{{ $bouteille->nom}}</h2>
                        </a>
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}}  $</p>
                    </div>
                    <!-- <a href="" class="btn-ajouter">+ Ajouter</a> -->
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
                        <td><{{$bouteille->pastilleGoutTitre ?? '-'}}/td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="modal-container"> -->
                <dialog id="modal-ajouter" class="modal">
                        <h2>Confirmation d'ajout</h2>
                        <hr>
                        <form action="" class="form-modal">
                                <div class="form-radio">
                                    <input type="radio" id="location-cellier" name="location" checked >
                                    <label for="location-cellier">Celliers</label><br>
                                </div>
                                <div class="form-radio">
                                    <input type="radio" id="location-liste" name="location">
                                    <label for="location-liste">Listes</label>
                                </div>
                                <div class="form-input-container">
                                    <label for="cellier-location">DIRECTION</label>
                                    <select name="cellier-location" id="cellier-location">
                                        <option value="">Maison</option>
                                        <option value="">Cottage</option>
                                        <option value="">Bureau</option>
                                    </select>
                                </div>
                                <div class="card-bouteille-qt">
                                    <button class="btn-decrement">-</button>
                                    <input type="text" value="1" min="1" readonly>
                                    <button class="btn-increment">+</button>
                                </div>
                                <div class="btn-modal-container">
                                    <button class="btn-modal-action">ajouter</button>
                                    <button class="btn-modal-cancel">annuler</button>
                                </div>
                        </form>
                </dialog>
            <!-- </div> -->
            <script src="../../js/bottleCounterModal.js"></script>
            <script src="../../js/modalAjouter.js"></script>
        </main>
        @endsection
