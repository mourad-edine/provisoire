@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('stock.liste')}}">
                <button class="nav-link " id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes globales
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('stock.faible.liste')}}">
                <button class="nav-link active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Stock faibles
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
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary">
            <h5 class="text-white">Stock faible</h5>
            <button class="btn btn-primary btn-sm">retour</button>
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
                            <th>image</th>
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
                            <td><img src="{{asset('assets/images/bouteille.png')}}" alt="" width="20" height="20"></td>
                            <td>{{$article->prix_consignation ? $article->prix_consignation .' Ar' :'pas de prix'}}</td>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('achat.liste')}}"><i class="fas fa-edit text-secondary"></i></a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-warning">pas encore de donné inséré pour le moment</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $articles->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>

</div>
@endsection