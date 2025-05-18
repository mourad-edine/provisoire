@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <ul class="nav nav-tabs border-bottom" id="parametresTabs" role="tablist">
        <li class="nav-item me-2" role="presentation">
            <a href="{{ route('stock.liste') }}" class="nav-link {{ request()->routeIs('stock.liste') ? 'active' : '' }}">
                <i class="fas fa-warehouse me-1"></i>Listes globales
            </a>
        </li>
        <li class="nav-item me-2" role="presentation">
            <a href="{{ route('stock.faible.liste') }}" class="nav-link {{ request()->routeIs('stock.faible.liste') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle me-1"></i>Stocks faibles
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('stock.categorie.liste') }}" class="nav-link {{ request()->routeIs('stock.categorie.liste') ? 'active' : '' }}">
                <i class="fas fa-th-large me-1"></i>Catégories
            </a>
        </li>
    </ul>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark">
            <h5 class="text-white">Stock faible</h5>
            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-arrow-left mr-2"></i>Retour dashboard
</a>   
        </div>
        <div class="mt-3 ml-4 d-flex flex-wrap align-items-center gap-2 mb-2 mb-md-0">
            <form action="{{ route('stock.faible.liste') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                @csrf
                <!-- Champ de recherche principal -->
                <div class="position-relative">
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="Rechercher..." value="{{ old('search', request('search')) }}">
                </div>

                <!-- Filtres supplémentaires -->
                

                <!-- Tri des résultats -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i> Trier par
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><button class="dropdown-item" type="submit"  value="nom_asc">Nom (A-Z)</button></li>
                        <li><button class="dropdown-item" type="submit"  value="nom_desc">Nom (Z-A)</button></li>
                        <li><button class="dropdown-item" type="submit"  value="prix_asc">Prix (Croissant)</button></li>
                        <li><button class="dropdown-item" type="submit"  value="prix_desc">Prix (Décroissant)</button></li>
                        <li><button class="dropdown-item" type="submit"  value="stock_asc">Stock (Croissant)</button></li>
                        <li><button class="dropdown-item" type="submit"  value="stock_desc">Stock (Décroissant)</button></li>
                    </ul>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nom</th>
                            <th>categorie</th>
                            <th>P.Vente</th>
                            <th>P.Cageot</th>
                            <th>quantite</th>
                            <th>consignation</th>
                            <th>mise à jour</th>
                            <th>date</th>
                            <th>ajouter</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{$article->id }}</td>
                            <td>{{$article->nom}}</td>
                            <td>{{$article->categorie_id}}</td>
                            <td>{{$article->prix_unitaire}} Ar</td>
                            <td>{{$article->prix_conditionne ? $article->prix_conditionne :'pas de prix'}} Ar</td>
                            <td>
                                @php
                                $quotient = intdiv($article->quantite, $article->conditionnement); // Division entière
                                $reste = $article->quantite % $article->conditionnement; // Reste de la division
                                $affichage = $quotient;
                                @endphp
                                <span class="text-danger"> {{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }} @if($reste> 0) et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}@endif
                                </span>
                            </td>
                            <td>{{$article->prix_consignation ? $article->prix_consignation .' Ar' :'pas de prix'}}</td>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('achat.page')}}"><i class="fas fa-edit text-secondary"></i></a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="10" class="">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Pas de donnée trouvé --
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $articles->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection