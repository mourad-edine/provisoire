@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="">

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('commande.liste.vente') }}">
                <button class="nav-link" id="commandes-tab">
                    <i class="fas fa-list-alt me-2"></i> Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('vente.liste') }}">
                <button class="nav-link active">
                    <i class="fas fa-shopping-cart me-2"></i> Listes ventes
                </button>
            </a>
        </li>
        <!-- <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('paiment.all') }}">
                <button class="nav-link">
                    <i class="fas fa-history me-2"></i> Historique des paiements
                </button>
            </a>
        </li> -->
       
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('vente.page')}}">
                <button class="nav-link active bg-dark text-white">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel vente
                </button>
            </a>
        </li>
    </ul>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <!-- Card Header -->
        

        <!-- Card Body -->
        <div class="card-body p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
            @endif

            <!-- Ventes Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Article</th>
                            <th>CGT/BTL</th>
                            <th>BTL</th>
                            <th>CGT</th>
                            <th>Statut</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Total</th>
                            <th>Bénéfice</th>

                            <th class="text-end">details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $prixGlobale = 0;$deconsigneglobale = 0 ; $totalconsigne = 0; $totalbtl = 0; $totalcgt = 0; $casse = 0 ; $casse_cgt = 0 ;$rendu_btl=0 ; $rendu_cgt = 0; @endphp
                        @forelse($ventes as $vente)
                        @php
                        $highlightedId = session('highlighted_id');
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp

                        <tr id="row-{{$vente['id']}}" class="{{ $highlightedId == $vente['id'] ? 'bg-info' : '' }}">
                            <td class="fw-bold">{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                @if($vente['etat_client'] == 1)
                                <span class="badge bg-danger text-white">à rendre</span>
                                @elseif($vente['etat_client_commande'] == 2 )
                                <span class="badge bg-warning">à disposition</span>
                                @else
                                <span class="badge bg-light text-dark">
                                    {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                </span>
                                @endif
                                @else
                                <span>--</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat'] == 'non rendu' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat'] ?($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ in_array($vente['etat_cgt'], ['non rendu']) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat_cgt'] ?($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']):'--' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat_payement'] == 0 ? 'bg-danger-light text-danger' : 'bg-success-light text-success' }}">
                                    <i class="fas {{ $vente['etat_payement'] == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }} me-1"></i>
                                    {{ $vente['etat_payement'] == 0 ? '' : '' }}
                                </span>
                            </td>
                            <td class="fw-bold">{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <td>
                                {{ number_format($vente['prix_unitaire'], 0, ',', ' ') }} Ar
                                @unless($vente['etat_client'] == 1 || $vente['etat'] == 'rendu' || $vente['etat'] == 'non consigné' || !isset($vente['etat']))
                                + {{ number_format($vente['prix_consignation'], 0, ',', ' ') }} Ar
                                @endunless
                            </td>

                            <td>
                                @php
                                $prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                ? ($vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement']) + $vente['consignation'] + $vente['prix_cgt']
                                : ($vente['prix_unitaire'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt'];

                                
                                
                                @endphp

                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>
                            <td> -- </td>

                            <td class="text-end">
                                @if($vente['etat_client_commande'] != 2)
                                <a href="{{ route('commande.liste.vente.detail', ['id' => $vente['numero_commande']]) }}" class="text-primary">
    <i class="fas fa-edit"></i>
</a>

                                @endif
                            </td>
                        </tr>

                        <!-- Modal for each vente -->
                        
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-exclamation-circle me-2"></i>Aucune donnée disponible
                            </td>
                        </tr>
                        @endforelse

                        <!-- Total Row -->
                        
                       
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-start mt-3">
                    {{ $ventes->links('pagination::bootstrap-4') }}
                </div>
                
            </div>

            <!-- Conditionnement Section -->
            <div class="mt-4">
                <!-- <h5 class="d-flex align-items-center text-uppercase fw-bold mb-3">
                    <img src="{{ asset('assets/images/enter.png') }}" alt="Conditionnement" width="24" class="me-2">
                    Conditionnement
                </h5> -->
                <hr class="mt-0">

               

                <!-- Global Total -->

            </div>
        </div>
    </div>
</div>

@endsection