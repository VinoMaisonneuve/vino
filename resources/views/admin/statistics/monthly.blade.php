@extends('layouts.app')
@section('title', 'Statistiques mensuelles')

@section('content')
<header>
    statistiques
</header>
<main class="nav-margin">
    <section class="admin-monthly-stats">
        <h1>Statistiques mensuelles pour le mois de {{ $month }}</h1>
        <div class="info-profil">
            <span>Nombre d'utilisateurs :</span><span class="info-value">{{ $monthlyStatistics['user_count'] }}</span>
        </div>
        <div class="info-profil">
            <span>Nombre de celliers :</span><span class="info-value">{{ $monthlyStatistics['celliers_count'] }}</span>
        </div>
        <div class="info-profil">
            <span>Nombre de listes :</span><span class="info-value">{{ $monthlyStatistics['listes_count'] }}</span>
        </div>
        <div class="info-profil">
            <span>Nombre de bouteilles :</span><span class="info-value">{{ $monthlyStatistics['total_bottles_count'] }}</span>
        </div>
        <div class="btn-container">
            <a href="{{ route('statistics.stats-users')}}" class="btn-action btn-round btn-mt">Plus de statistiques</a>
        </div>
    </section>
</main>
@endsection
