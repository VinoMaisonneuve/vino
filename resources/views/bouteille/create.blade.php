<!-- Création d'une bouteille personnalisée -->
@extends('layouts.app')
@section('title','Bouteille personnalisée')
@section('content')
        <header>
            <a href="{{ route('cellier.show', ['cellier_id' => $cellier_id]) }}" class="btn-arrow-top">
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
                </svg>
                celliers
            </a>
        </header>
        <main class="nav-margin">
            <section>
                <h1 class="form-h1">
                    Ajouter une bouteille personnalisée
                </h1>
                <hr>
                <div class="form-container">
                    <form action="{{ route('bouteillePersonnalisee.store', ['cellier_id' => $cellier_id]) }}" method="post" id="ajouterBouteilleExistante">
                        @csrf
                        <div class="form-input-container">
                            <label for="nom">Choisir la bouteille personnalisée</label>
                            <select name="bouteille_id" id="select-location">
                                @forelse ($bouteilles as $bouteille)
                                    <option value="{{ $bouteille->id }}">{{ $bouteille->nom }}</option>
                                @empty
                                    <option value="">Vous n'avez aucune bouteille personnalisée</option>
                                @endforelse
                            </select>
                        </div>
                        @if ($bouteilles->isNotEmpty())
                        <div class="card-bouteille-qt">
                            <button class="btn-decrement">-</button>
                            <input type="text" value="1" min="0" name="quantite" readonly>
                            <button class="btn-increment">+</button>
                        </div>
                        @endif
                        <div class="form-button">
                            <button type="submit" form="ajouterBouteilleExistante" class="btn-submit" @if($bouteilles->isEmpty()) disabled @endif>Ajouter au cellier</button>
                        </div>
                    </form>
                </div>
            </section>
            <section>
                <h1 class="form-h1">
                    Créer une bouteille
                </h1>
                <div class="form-container">
                    <form action="{{ route('bouteille.store', ['cellier_id' => $cellier_id]) }}" method="post" id="ajouterBouteille">
                        @csrf
                        <div class="form-input-container">
                            <label for="nom">Nom de la bouteille</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
                            @if ($errors->has('nom'))
                                <div class="error-message">{{ $errors->first('nom') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="type">Type</label>
                            <input type="text" id="type" name="type" value="{{ old('type') }}">
                            @if ($errors->has('type'))
                                <div class="error-message">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="format">Format</label>
                            <input type="text" id="format" name="format" value="{{ old('format') }}">
                            @if ($errors->has('format'))
                                <div class="error-message">{{ $errors->first('format') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="prix">Prix</label>
                            <input type="text" id="prix" name="prix" value="{{ old('prix') }}">
                            @if ($errors->has('prix'))
                                <div class="error-message">{{ $errors->first('prix') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="pays">Pays</label>
                            <input type="text" id="pays" name="pays" value="{{ old('pays') }}">
                            @if ($errors->has('pays'))
                                <div class="error-message">{{ $errors->first('pays') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="region">Région</label>
                            <input type="text" id="region" name="region" value="{{ old('region') }}">
                            @if ($errors->has('region'))
                                <div class="error-message">{{ $errors->first('region') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="producteur">Producteur</label>
                            <input type="text" id="producteur" name="producteur" value="{{ old('producteur') }}">
                            @if ($errors->has('producteur'))
                                <div class="error-message">{{ $errors->first('producteur') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="cepage">Cépage</label>
                            <input type="text" id="cepage" name="cepage" value="{{ old('cepage') }}">
                            @if ($errors->has('cepage'))
                                <div class="error-message">{{ $errors->first('cepage') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="degre">Degré d'alcool</label>
                            <input type="text" id="degre" name="degre" value="{{ old('degre') }}">
                            @if ($errors->has('degre'))
                                <div class="error-message">{{ $errors->first('degre') }}</div>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <label for="millesime">Millésime</label>
                            <input type="text" id="millesime" name="millesime" value="{{ old('millesime') }}">
                            @if ($errors->has('millesime'))
                                <div class="error-message">{{ $errors->first('millesime') }}</div>
                            @endif
                        </div>
                        <div class="form-button">
                            <button type="submit" form="ajouterBouteille" class="btn-submit">Créer bouteille</button>
                        </div>
                    </form>
                </div>
            </section>
            <script src="{{ asset('js/bottleCounterModal.js') }}"></script>
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
