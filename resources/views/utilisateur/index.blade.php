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
    </section>
    <!-- <div class="btn-container">
        <a href="{{ route('signalerErreur') }}" class="btn-action btn-round btn-red">
            Signaler un problème
        </a>
    </div>     -->
    <br>
    <div>
        <p>Afin de nous aider à améliorer votre expérience, <br>signaler tout problème:</p>
        <a href="{{ route('signalerErreur') }}" class="link" target="_blank">
            Signaler un problème
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.50098 4.77832V6.66721" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9.50098 10.4548L9.51042 10.4443" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 17.329V2.88889C1 1.84568 1.84568 1 2.88889 1H16.1111C17.1543 1 18 1.84568 18 2.88889V12.3333C18 13.3766 17.1543 14.2222 16.1111 14.2222H5.68562C5.11181 14.2222 4.56911 14.4831 4.21065 14.9311L2.00916 17.683C1.67453 18.1012 1 17.8647 1 17.329Z" stroke="black"/>
            </svg>

        </a>
    </div>

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