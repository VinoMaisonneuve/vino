@extends('layouts.app')
@section('title', 'Statistiques mensuelles')

@section('content')
<h1>Statistiques mensuelles</h1>

<p>Nombre d'utilisateurs de ce mois : {{ $monthlyStatistics['user_count'] }}</p>
<p>Nombre de celliers de ce mois : {{ $monthlyStatistics['celliers_count'] }}</p>
<p>Nombre de listes de ce mois : {{ $monthlyStatistics['listes_count'] }}</p>
<p>Nombre total de bouteilles dans les celliers et les listes : {{ $monthlyStatistics['total_bottles_count'] }}</p>
<a href="{{ route('statistics.index')}}">Plus de statistiques </a>
@endcontent
