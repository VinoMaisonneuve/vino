@extends('layouts.app')
@section('title', 'Utilisateur')
@section('content')
<header>
    <a href="{{ route('admin.index') }}" class="btn-arrow-top">
        <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.4247 7C17.977 7 18.4247 7.44772 18.4247 8C18.4247 8.55228 17.977 9 17.4247 9L17.4247 7ZM0.498398 8.70711C0.107874 8.31658 0.107874 7.68342 0.498398 7.29289L6.86236 0.928933C7.25288 0.538409 7.88605 0.538409 8.27657 0.928933C8.6671 1.31946 8.6671 1.95262 8.27657 2.34315L2.61972 8L8.27657 13.6569C8.6671 14.0474 8.6671 14.6805 8.27657 15.0711C7.88605 15.4616 7.25288 15.4616 6.86236 15.0711L0.498398 8.70711ZM17.4247 9L1.20551 9L1.20551 7L17.4247 7L17.4247 9Z" fill="black"/>
        </svg>
        utilisateurs
    </a>
</header>
<main class="nav-margin">
    <section class="admin-user-section">
        <h2>Informations de l'utilisateur</h2>
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="info-profil"><span>Nom :</span><span class="info-value">{{ $user->nom }}</span></div>
        <div class="info-profil"><span>Rôle :</span><span class="info-value">{{ $user->getRoleNames()->first() == "Admin" ? 'Administrateur' : 'Utilisateur' }}</span></div>
        <div class="info-profil"><span>Courriel :</span><span class="info-value">{{ $user->email }}</span></div>
        <div class="info-profil">
          <span>Courriel vérifié :</span><span class="info-value">
            @if(empty($user->email_verified_at))
              Non
            @else
                {{ $user->email_verified_at }}
            @endif
          </span>
        </div>
        <div class="info-profil"><span>Mot de passe :</span><span class="info-value">{{ $user->password }}</span></div>
        <div class="info-profil"><span>Date de création :</span><span class="info-value" readonly>{{ $user->created_at }}</span></div>
        <div class="info-profil"><span>Date de modification :</span><span class="info-value" readonly>{{ $user->updated_at }}</span></div>

        <div class="btn-container">
            <a href="{{ route('admin.edit-user', $user->id) }}" class="btn-action btn-round btn-mt">
                Modifier le compte
            </a>
        </div>
        <div class="btn-container">
            <a href="{{ route('admin.destroy-user', $user->id) }}" class="btn-action btn-round btn-red btn-supprimer">
                Supprimer le compte
            </a>
        </div>
    </section>
    <dialog id="modal-supprimer" class="modal">
        <h2>Suppression de compte</h2>
        <hr>
        <p><strong>ATTENTION!</strong> Cette action est irréversible et entraînera la perte de toutes les données associées à ce compte.</p>
        <p>Veuillez entrer votre mot de passe administrateur pour confirmer la suppression du compte</p>
        <form action="{{ route('admin.destroy-user', $user->id) }}" method="post" class="form-modal">
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
@endsection