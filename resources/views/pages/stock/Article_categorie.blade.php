@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('stock.liste')}}">
                <button class="nav-link active" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes globales
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('stock.faible.liste')}}">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Stock faible
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('stock.categorie.liste')}}">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Categorie
                </button>
            </a>
        </li>
    </ul>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark">
            <h5 class="text-white">gestion de stock</h5>
            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-arrow-left mr-2"></i>Retour dashboard
</a>           </div>
        <div class="mt-3 ml-4 d-flex flex-wrap align-items-center gap-2 mb-2 mb-md-0">
            <form action="{{ route('stock.liste.id',['id'=> $categorie_id]) }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
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
                            <th>P.C</th>
                            <th>quantite</th>
                            <th>consignation</th>
                            <th>mise à jour</th>
                            <th>date creation</th>
                            <th>Ajouter</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{$article->id }}</td>
                            <td>{{$article->nom}}</td>
                            <td>{{$article->categorie_id}}</td>
                            <td>{{$article->prix_unitaire}} Ar</td>
                            <td>{{$article->prix_conditionne ? $article->prix_conditionne .' Ar' :'pas de prix'}}</td>
                            <td>
                                @php
                                $quotient = intdiv($article->quantite, $article->conditionnement); // Division entière
                                $reste = $article->quantite % $article->conditionnement; // Reste de la division
                                $affichage = $quotient;
                                @endphp

                                @if($quotient > 0)
                                <span class="text-success">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}</span>
                                @else
                                <span class="text-danger"> {{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}
                                </span>
                                @endif

                                @if($reste > 0)
                                et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}
                                @endif
                            </td>
                            <td>{{$article->prix_consignation ? $article->prix_consignation . ' Ar' : 'pas de prix'}}</td>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a class="ml-3" href="{{route('achat.page')}}"><i class="fas fa-edit text-secondary"></i></a>
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