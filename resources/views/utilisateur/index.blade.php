@extends('layouts.app')
@section("title", "Profil")
@section('content')
<header>
    profil
</header>
<main class="nav-margin">
    <section>
        <h2>Mes informations</h2>
        @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="info-profil"><span>Nom :</span><span class="info-value">{{ $user->nom }}</span></div>
        <div class="info-profil"><span>Courriel :</span><span class="info-value">{{ $user->email }}</span></div>

        <div class="btn-container">
            <a href="{{ route('profil.edit', $user->id) }}" class="btn-action btn-round btn-mt">
                Modifier mon profil
            </a>
        </div>
    </section>
    <section>
        <h2>Mon compte</h2>
        <div class="btn-container">
            <a href="{{ route('logout') }}" class="btn-action btn-round btn-grey">
                Me déconnecter
            </a>
        </div>
        <div class="btn-container">
            <a href="#" class="btn-action btn-round btn-red btn-supprimer">
                Supprimer mon compte
            </a>
        </div>
        <div class="btn-container">
            <a href="{{ route('signalerErreur') }}" class="btn-action btn-round btn-red">
                Signaler un problème
            </a>
        </div>
    </section>

    <!-- Fenêtre modale de suppression de compte -->
    <dialog id="modal-supprimer" class="modal">
        <h2>Suppression de compte</h2>
        <hr>
        <p><strong>ATTENTION!</strong> Cette action est irréversible et entraînera la perte de toutes les données associées à ce compte.</p>
        <p>Veuillez entrer le mot de passe pour confirmer la suppression du compte</p>
        <form action="{{ route('profil.destroy', $user->id) }}" method="post" class="form-modal">
            @csrf
            @method('DELETE')
            <div class="form-input-container">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="btn-modal-container">
                <button class="btn-modal-action btn-red">supprimer</button>
                <button class="btn-modal-cancel btn-green">annuler</button>
            </div>
        </form>
    </dialog>
    <script src="{{ asset('js/modalSupprimer.js') }}"></script>
</main>
<footer>
    © <span>vino</span> 2023. (version 1.1) - Tous droits réservés.
</footer>
@endsection