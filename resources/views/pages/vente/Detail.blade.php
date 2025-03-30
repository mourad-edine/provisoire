@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->


    <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
    <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('commande.liste.vente')}}">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('vente.liste')}}">
                <button class="nav-link active" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes ventes
                </button>
            </a>
        </li>
      
    </ul>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary border-bottom">
            <h5 class="mb-2 text-white">VENTE - DETAILS</h5>

            <div class="d-flex justify-content-end">
                <button class="btn btn-outline-warning btn-sm mr-3"> <a class="text-white" href="{{route('pdf.download',['id' => $commande_id])}}"><i class="fas fa-print text-white mr-2"></i>facture</a></button>
                <button class="btn btn-primary btn-sm"><a class="text-white" href="{{route('commande.liste.vente')}}">retour</a></button>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-secondary">
                        <tr>
                            <th class="bg-light">ID</th>
                            <th>Article</th>
                            <th>Commande</th>
                            <th>Consi(CGT/BTL)</th>
                            <th>État BTL</th>
                            <th>État CGT</th>
                            <th>Statut</th>
                            <th>Quantité</th>
                            <th>prix</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventes as $vente)
                        @php $highlightedId = session('highlighted_id'); @endphp
                        @php
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp
                        <tr id="row-{{$vente['id']}}" class="{{ $highlightedId == $vente['id'] ? 'table-info' : '' }}">
                            <td class="fw-semibold">{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td class="text-primary fw-semibold">C-{{$vente['numero_commande']}}</td>
                            <td>
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                @if($vente['etat_client'] == 1)
                                <span class="badge bg-danger text-white border">à rendre</span>
                                @elseif($vente['etat_client'] == 0)
                                <span class="badge bg-light text-dark border">
                                    {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                </span>
                                @endif
                                @else
                                <span class="badge bg-light text-muted border">Non consigné</span>
                                @endif
                            </td>


                            <td>
                                <span class="badge {{ $vente['etat'] == 'non rendu' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat'] ?? 'Non consigné' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat_cgt'] == 'non rendu' || $vente['etat_cgt'] == 'conditionné' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat_cgt'] ?? 'Non consigné' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat_payement'] == 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                                    <i class="fas {{ $vente['etat_payement'] == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }} me-1"></i>
                                    {{ $vente['etat_payement'] == 0 ? 'Non payé' : 'Payé' }}
                                </span>
                            </td>

                            <td class="fw-semibold">{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <td>{{ number_format($vente['btl'] == 0 ? $vente['prix_unitaire'] + $vente['prix_consignation'] : $vente['prix_unitaire'], 0, ',', ' ') }} Ar</td>
                            <td>
                                @php
                                $prix_total = $vente['prix_unitaire'] * $vente['quantite'];

                                if ($vente['type_achat'] === 'cageot') {
                                $prix_total *= $vente['conditionnement'];
                                }

                                switch (true) {
                                case $vente['cgt'] == 0 && $vente['btl'] == 0:
                                $prix_total += $vente['consignation'] + $vente['prix_cgt'];
                                break;
                                case $vente['cgt'] == 1 && $vente['btl'] == 0:
                                $prix_total += $vente['consignation'];
                                break;
                                case $vente['cgt'] == 0 && $vente['btl'] == 1:
                                $prix_total += $vente['prix_cgt'];
                                break;
                                }
                                @endphp
                                @if($vente['etat_client'] == 1)
                                    <span>
                                    {{$vente['prix_unitaire'] * $vente['quantite']}} Ar
                                    </span>
                                @else
                                    <span> {{ number_format($prix_total, 0, ',', ' ') }} Ar</span>
                                @endif

                            </td>
                            <td class="text-muted">{{ optional($vente['created_at'])->format('d/m/Y') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a class="ml-3" href="#" data-toggle="modal" data-target="#venteModal2{{$vente['id']}}"><i class="fas fa-edit text-warning"></i></a>

                            </td>
                        </tr>
                        <!-- modal commencement -->
                        <!-- Modal pour le paiement de la consignation -->
                        <div class="modal fade" id="venteModal2{{$vente['id']}}" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
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
                                    <form action="{{route('payer.consignation')}}" method="POST">
                                        @csrf
                                        <!-- Corps du modal -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Section Bouteille -->
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group d-flex align-items-center">
                                                        <input type="hidden" value="{{$vente['id']}}" name="vente_id">
                                                        @if($vente['etat'] == 'non rendu')
                                                        <input type="checkbox" name="check_bouteille" id="check_bouteille{{$vente['id']}}" class="mr-2">
                                                        <label for="check_bouteille{{$vente['id']}}" class="mb-0 cursor-pointer">
                                                            Bouteille - <span>{{$vente['consignation']}} Ar</span>
                                                        </label>
                                                        @elseif($vente['etat'] == 'avec BTL')
                                                        <label class="mb-0 cursor-pointer">
                                                            Bouteille <span class="text-success">non consigné</span>
                                                        </label>
                                                        @else
                                                        <label class="mb-0 cursor-pointer">
                                                            <span class="text-success">Bouteille rendu</span>
                                                        </label>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Section Cageot -->
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group d-flex align-items-center">
                                                        <input type="hidden" value="{{$vente['consignation_id']}}" name="consignation_id">
                                                        @if($vente['etat_cgt'] == 'non rendu')
                                                        <input type="checkbox" name="check_cageot" id="check_cageot{{$vente['id']}}" class="mr-2">
                                                        <label for="check_cageot{{$vente['id']}}" class="mb-0 cursor-pointer">
                                                            <span>Cageot {{$vente['prix_cgt']}} Ar</span>
                                                        </label>
                                                        @elseif($vente['etat_cgt'] == 'avec CGT' || $vente['etat_cgt'] == 'non condi°')
                                                        <label class="mb-0 cursor-pointer">
                                                            <span class="text-success">Cageot non consigné</span>
                                                        </label>
                                                        @elseif($vente['etat_cgt'] == 'conditionné')
                                                        <label class="mb-0 cursor-pointer">
                                                            <span class="text-danger">Bouteilles conditionné en cageot (cliquer en bas pour rendre)</span>
                                                        </label>
                                                        @else
                                                        <label class="mb-0 cursor-pointer">
                                                            <span class="text-success">Cageot payé</span>
                                                        </label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pied du modal -->
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>

                                            @if($vente['etat'] == 'non rendu' || $vente['etat_cgt'] == 'non rendu')
                                            <!-- Afficher le bouton "Payer" si la bouteille ou le cageot est "non rendu" -->
                                            <button type="submit" class="btn btn-primary">Payer</button>
                                            @else
                                            <!-- Désactiver ou masquer le bouton "Payer" si aucun paiement n'est nécessaire -->
                                            <button type="button" class="btn btn-primary" disabled>Payer</button>
                                            <!-- Ou pour masquer complètement le bouton : -->
                                            <!-- <button type="submit" class="btn btn-primary d-none">Payer</button> -->
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- modal fin -->
                        @empty
                        <tr>
                            <td colspan="8" class="text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                </div>
                <div class="d-flex justify-content-start mt-3">
                    {{ $ventes->links('pagination::bootstrap-4') }} <!-- ou 'pagination::bootstrap-5' -->
                </div>
            </div>
            <div class="table-responsive">
                <p>Conditionnement</p>
                <hr>
                <img src="{{asset('assets/images/enter.png')}}" alt="" width="20" height="20">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    @if($conditionnement != null)
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Prix Cageot</th>
                            <th>Nombre Cageot</th>
                            <th>Total</th>
                            <th>État</th>
                            <th>État CGT</th>
                            <th>option</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ optional($conditionnement->conditionnement)->id ? optional($conditionnement->conditionnement)->id : 'non conditionné'}}</td>
                            <td>{{optional($conditionnement->conditionnement)->nombre_cageot ? '3000 Ar/CGT' : 'non conditionné' }}</td>
                            <td>{{optional($conditionnement->conditionnement)->nombre_cageot ?  optional($conditionnement->conditionnement)->nombre_cageot. ' CGT' : 'non conditionné'}}</td>
                            <td>{{ optional($conditionnement->conditionnement)->nombre_cageot ? optional($conditionnement->conditionnement)->nombre_cageot * 3000 .'Ar':'non conditionné' }} </td>
                            <td>{{ optional($conditionnement->conditionnement)->etat ?? 'non conditionné' }}</td>
                            <td>{{ optional($conditionnement->conditionnement)->created_at  ?? 'non conditionné' }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="#"><i class="fas fa-edit text-warning"></i></a>

                            </td>
                        </tr>
                    </tbody>
                    @else
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-warning text-center">Non conditionné</td>
                        </tr>
                    </tbody>
                    @endif
                </table>
                <div style="display: flex; justify-content: flex-end; align-items: baseline; margin: 20px 0; border-top: 1px solid #eee; padding-top: 10px;">
    <p style="margin: 0 10px 0 0; font-weight: 500; color: #666;">Total :</p>
    <p style="margin: 0; font-weight: 700; font-size: 1.2rem; color: #2c3e50;">200 000 Ar</p>
</div>

            </div>
        </div>
    </div>

</div>

<script>

</script>

@endsection