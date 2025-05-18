@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')

<div class="">
    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.commande')}}">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.liste')}}">
                <button class="nav-link active" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes achats
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('achat.page')}}">
                <button class="nav-link active bg-dark text-white">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel achat
                </button>
            </a>
        </li>

    </ul>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 font-weight-bold text-white">
                <i class="fas fa-user me-2"></i>INFORMATIONS FOURNISSEUR
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nom :</strong> {{ $commande->fournisseur->nom ?? 'N/A' }}</p>
                    <p><strong>Prénom :</strong> ------</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Téléphone :</strong> {{ $commande->client->telephone ?? 'N/A' }}</p>
                    <p><strong>Email :</strong> {{ $commande->fournisseur->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Adresse :</strong> {{ $commande->client->adresse ?? 'N/A' }}</p>
                    <p><strong>Date commande :</strong> {{ $commande->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary">
            <h5 class="mb-2 text-white">ACHAT - DETAILS</h5>

            <div>
                <button class="btn btn-outline-warning btn-sm mr-3"> <a class="text-white" href="{{route('pdf.achat' , ['id' => $id])}}"><i class="fas fa-print text-white mr-2"></i>facture</a></button>
                <a href="{{ url()->previous() }}"><button class="btn btn-dark btn-sm">retour</button></a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>article</th>
                            <th>Prix unité</th>
                            <th>Prix / cageot</th>
                            <th>commande</th>
                            <th>quantite</th>
                            <th>état</th>
                            <th>total</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr>
                            <td>{{$achat['id']}}</td>
                            <td>{{$achat['article']}}</td>
                            <th>
                                {{$achat['prix_unite']}}
                            </th>
                            <td>{{$achat['prix_unite'] * $achat['conditionnement']}} </td>
                            <td>C-{{$achat['numero_commande']}}</td>

                            <td>{{$achat['quantite']}} -{{ $achat['type_achat']}}</td>
                            <td><span class="text-success">payé</span></td>
                            <td>{{ $achat['prix']  .' Ar' }}</td>
                            <td>{{$achat['created_at']}}</td>
                            <!-- <td>
                                <a href="#" class="ml-3" data-toggle="modal" data-target="#venteModal2{{$achat['id']}}"><i class="fas fa-edit text-warning"></i></button>
                            </td> -->
                        </tr>
                        <div class="modal fade" id="venteModal2{{$achat['id']}}" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- En-tête du modal -->
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title" id="venteModal2Label">Rendre consignation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Formulaire de paiement -->
                                    <form action="{{ route('payer.consignation.achat') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vente_id" value="{{ $achat['id'] }}">
                                        <input type="hidden" name="consignation_id" value="{{ $achat['consignation_id'] }}">

                                        <div class="modal-body">
                                            @php
                                            $bouteilleNonRendu = $achat['etat'] == 'non rendu';
                                            $cageotNonRendu = $achat['etat_cgt'] == 'non rendu';
                                            @endphp

                                            <!-- Section Bouteille -->
                                            <div class="form-group d-flex align-items-center">
                                                @if ($bouteilleNonRendu)
                                                <input type="checkbox" name="check_bouteille" id="check_bouteille{{ $achat['id'] }}" class="mr-2">
                                                <label for="check_bouteille{{ $achat['id'] }}" class="mb-0 cursor-pointer">
                                                    Bouteille <span class="ml-4">{{ $achat['prix'] }} Ar</span>
                                                </label>
                                                @else
                                                <label class="mb-0 cursor-pointer">
                                                    Bouteille <span class="ml-4 text-success">
                                                        {{ $achat['etat'] == 'non consigné' ? 'non consigné' : 'payé' }}
                                                    </span>
                                                </label>
                                                @endif
                                            </div>

                                            <!-- Section Cageot -->
                                            <div class="form-group d-flex align-items-center">
                                                @if ($cageotNonRendu)
                                                <input type="checkbox" name="check_cageot" id="check_cageot{{ $achat['id'] }}" class="mr-2">
                                                <label for="check_cageot{{ $achat['id'] }}" class="mb-0 cursor-pointer">
                                                    Cageot <span class="ml-4">{{ $achat['prix_cgt'] }} Ar</span>
                                                </label>
                                                @else
                                                <label class="mb-0 cursor-pointer">
                                                    Cageot <span class="ml-4 text-success">
                                                        {{ $achat['etat_cgt'] == 'non consigné' ? 'non consigné' : 'payé' }}
                                                    </span>
                                                </label>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Pied du modal -->
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" {{ !($bouteilleNonRendu || $cageotNonRendu) ? 'disabled' : '' }}>Payer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                        <td colspan="9" class="">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Pas de donnée trouvé --
                                </div>
                            </td>                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="display: flex; justify-content: flex-end; align-items: baseline; margin: 20px 0; border-top: 1px solid #eee; padding-top: 10px;margin-right : 80px;">
                    <p style="margin: 0 10px 0 0; font-weight: 500; color: #666;">Total :</p>
                    <p style="margin: 0; font-weight: 700; font-size: 1.2rem; color: #2c3e50;">
                        {{$total}} Ar
                    </p>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    {{ $achats->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection