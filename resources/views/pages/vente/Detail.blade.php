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
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('paiment.boissons' ,['id' => $commande_id ]) }}">
                <button class="nav-link">
                    <i class="fas fa-history me-2"></i> Historique des paiements
                </button>
            </a>
        </li>
        @if($exist == true)
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('vente.rendu' ,['id' => $commande_id ]) }}">
                <button class="nav-link">
                    <i class="fas fa-list me-2"></i>Article à rendre
                </button>
            </a>
        </li>
        @endif
        @if($commande->etat_client == 2)
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('rendre.boissons',['id' => $commande_id ]) }}">
                <button class="nav-link">
                    <i class="fas fa-file-alt me-2"></i> Compte rendu
                </button>
            </a>
        </li>
        @endif
        @if($commande->etat_commande == 'non payé' && $commande->etat_client != 2)
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="#" data-toggle="modal" data-target="#payement">
                <button class="nav-link active bg-success text-white">
                    <i class="fas fa-credit-card me-2 text-white"></i> Payement
                </button>
            </a>
        </li>
        @endif
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('vente.page')}}">
                <button class="nav-link active bg-dark text-white">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel vente
                </button>
            </a>
        </li>
    </ul>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 font-weight-bold text-white">
                <i class="fas fa-user me-2"></i>INFORMATIONS CLIENT
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nom :</strong> {{ $commande->client->nom ?? 'N/A' }}</p>
                    <p><strong>État commande :</strong>
                        <span class="ml-2 text-{{ $commande->etat_commande == 'non payé' ? 'danger' : 'success' }}">
                            {{ $commande->etat_commande }}
                        </span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p><strong>Téléphone :</strong> {{ $commande->client->telephone ?? 'N/A' }}</p>
                    <p><strong>Email :</strong> {{ $commande->client->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Adresse :</strong> {{ $commande->client->adresse ?? 'N/A' }}</p>
                    <p><strong>Date commande :</strong> {{ $commande->created_at}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Card -->
    <div class="card shadow-sm">
        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white py-3">
            <h5 class="mb-0 font-weight-bold text-white">
                <i class="fas fa-receipt me-2"></i>VENTE - DETAILS C-{{$commande->id}}
            </h5>
            <div class="d-flex gap-2">
                <a href="{{route('pdf.download',['id' => $commande_id])}}" class="btn btn-warning btn-sm text-white">
                    <i class="fas fa-print me-1 text-white"></i>Facture
                </a>
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left me-1 text-white"></i>Retour
                </a>
            </div>
        </div>

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
                            <th class="text-end">Actions</th>
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
                                <span class="fw-bold text-danger">à rendre</span>
                                @elseif($vente['etat_client_commande'] == 2 )
                                <span class="fw-bold text-danger">à disposition</span>
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

                                if($commande->etat_client == 1) {
                                $prix_total -= $vente['consignation'] + $vente['prix_cgt'];
                                }
                                $prix_total_deconsigne = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                ? ($vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement'])
                                : ($vente['prix_unitaire'] * $vente['quantite']);
                                $casse += $vente['casse'];
                                $casse_cgt += $vente['casse_cgt'];
                                $rendu_cgt += $vente['rendu_cgt'];
                                $rendu_btl += $vente['rendu_btl'];
                                $prix_total_consigne = $vente['consignation'] + $vente['prix_cgt'];
                                $totalbtl += $vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation'];
                                $totalcgt += $vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt'];
                                $totalconsigne += $prix_total_consigne;
                                $deconsigneglobale += $prix_total_deconsigne;
                                $prixGlobale += $prix_total;
                                @endphp

                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>
                            <td class="text-end">
                                @if($vente['etat_client_commande'] != 2)
                                <a href="#" data-toggle="modal" data-target="#venteModal2{{$vente['id']}}" class="text-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal for each vente -->
                        <div class="modal fade" id="venteModal2{{$vente['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-3">
                                    <div class="modal-header bg-dark text-white border-bottom-0">
                                        <h5 class="modal-title">Déconsignation</h5>
                                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('payer.consignation') }}" method="POST">
                                        @csrf
                                        <div class="modal-body px-4 py-3">

                                            <!-- Champs cachés -->
                                            <input type="hidden" name="vente_id" value="{{ $vente['id'] }}">
                                            <input type="hidden" name="commande_id" value="{{ $vente['numero_commande'] }}">
                                            <input type="hidden" name="consignation_id" value="{{ $vente['consignation_id'] }}">
                                            <input type="hidden" name="article_id" value="{{ $vente['article_id'] }}">
                                            <input type="hidden" name="total_btl" value="{{ $vente['prix_consignation'] != 0 ? $vente['consignation'] / $vente['prix_consignation'] : 0 }}">
                                            <input type="hidden" name="total_cgt" value="{{ $vente['consi_cgt'] != 0 ? $vente['prix_cgt'] / $vente['consi_cgt'] : 0 }}">

                                            <!-- Section bouteilles et cageots -->
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label fw-bold">Bouteilles</label>
                                                    <div class="form-check mb-2">

                                                        <input class="form-check-input" type="checkbox" name="check_bouteille" id="check_bouteille{{$vente['id']}}" {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'disabled' : '') : 'disabled' }}>
                                                        <label class="form-check-label" for="check_bouteille{{$vente['id']}}">
                                                            À rendre - {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation']) : 0 }}
                                                        </label>
                                                    </div>
                                                    <input type="number" name="quantite_buteille" class="form-control" placeholder="Quantité" min="0" step="1"
                                                        {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label fw-bold">Cageots</label>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="check_cageot" id="check_cageot{{$vente['id']}}" {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'disabled' : '') : 'disabled' }}>
                                                        <label class="form-check-label" for="check_cageot{{$vente['id']}}">
                                                            À rendre - {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt']) : 0 }}
                                                        </label>
                                                    </div>
                                                    <input type="number" name="quantite_cageot" class="form-control" placeholder="Quantité" min="0" step="1"
                                                        {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                                </div>
                                            </div>

                                            <!-- Casse -->
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label fw-bold">Casse - Bouteilles</label>
                                                    <!-- <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="check_bouteille_casse" id="check_bouteille_casse{{$vente['id']}}">
                                <label class="form-check-label" for="check_bouteille_casse{{$vente['id']}}">
                                    Casse ou perte
                                </label>
                            </div> -->
                                                    <input type="number" name="casse" class="form-control" placeholder="Quantité cassée" min="0" step="1" {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label fw-bold">Casse - Cageots</label>
                                                    <input type="number" name="cageot_casse" class="form-control" placeholder="Quantité cassée" min="0" step="1" {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                                </div>
                                            </div>

                                            <!-- État rendu -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="alert {{ $vente['etat'] == 'avec BTL' ? 'alert-warning' : 'alert-success' }}">
                                                        <strong>Bouteille :</strong>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <div class="alert {{ in_array($vente['etat_cgt'], ['avec CGT', 'non condi°']) ? 'alert-warning' : 'alert-success' }}">
                                                        <strong>Cageot</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer border-top-0 px-4 pb-4">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                            @php
                                            $disabled = true;

                                            if ($vente['prix_consignation'] != 0 && $vente['consi_cgt'] != 0) {
                                            $ratio1 = $vente['consignation'] / $vente['prix_consignation'];
                                            $ratio2 = $vente['prix_cgt'] / $vente['consi_cgt'];

                                            if (!($ratio1 == 0 && $ratio2 == 0)) {
                                            $disabled = false;
                                            }
                                            }
                                            @endphp

                                            <button type="submit" class="btn btn-primary" {{ $disabled ? 'disabled' : '' }}>Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-exclamation-circle me-2"></i>Aucune donnée disponible
                            </td>
                        </tr>
                        @endforelse

                        <!-- Total Row -->
                        <tr class="table-active fw-bold">
                            <td colspan="" class="text-end"></td>
                            <td>Cageot rendu</td>
                            <td>{{$rendu_cgt}}</td>
                            <td colspan="2">Bouteille rendu</td>
                            <td>{{$rendu_btl}}</td>
                            <td></td>
                            <td colspan="">Total :</td>
                            <td colspan="2">{{ number_format($prixGlobale, 0, ',', ' ') }} Ar</td>

                        </tr>
                        <tr class="table-active fw-bold">
                            <td colspan="" class="text-end"></td>
                            <td>Bouteille cassé :</td>
                            <td>{{$casse}}</td>
                            <td colspan="2">Bouteille consigné :</td>
                            <td>{{$totalbtl}}</td>
                            <td></td>
                            <td>Total déconsigné:</td>
                            <td colspan="2">{{ number_format($deconsigneglobale, 0, ',', ' ') }} Ar</td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td colspan="" class="text-end"></td>
                            <td>Cageot endomagé / perdu :</td>
                            <td>{{$casse_cgt}}</td>
                            <td colspan="2">Cageot consigné :</td>
                            <td>{{$totalcgt + optional($conditionnement->conditionnement)->nombre_cageot}}</td>
                            <td></td>
                            <td>Total consignation:</td>
                            <td colspan="2">{{ number_format($totalconsigne + (optional($conditionnement->conditionnement)->nombre_cageot * $cgt), 0, ',', ' ') }} Ar</td>
                        </tr>
                        @php
                        // Calcul sécurisé avec gestion des valeurs nulles
                        $nombreCageots = optional($conditionnement->conditionnement)->nombre_cageot ?? 0;
                        $valeurCageots = $nombreCageots * ($cgt ?? 0);
                        $totalConsigne = ($totalconsigne ?? 0) + $valeurCageots;
                        $montantTotal = ($deconsigneglobale - $reste < 0 ? 0 : $deconsigneglobale - $reste) + $totalConsigne;
                            @endphp
                            <tr class="table-active fw-bold">
                            <td colspan="6" class="text-end"></td>
                            <td></td>
                            <td colspan="" class="text-danger">
                                @if($commande->etat_commande == 'non payé' && $totalConsigne > 0)
                                Reste à payer
                                @elseif($commande->etat_commande == 'payé' && $totalConsigne > 0)
                                <span class="text-success">Bouteille déconsignable</span>

                                @elseif($commande->etat_commande == 'non payé' && $totalConsigne == 0)
                                <span class="text-danger">Reste à payer</span>
                                @else
                                <span class="text-success">reglé</span>
                                @endif
                            </td>
                            <!-- <td colspan="2">{{ number_format($deconsigneglobale - $reste, 0, ',', ' ') }} Ar</td> -->
                            <td colspan="2" class="text-end pe-4 fw-bold">


                                <!-- Affichage détaillé -->
                                <div class="d-flex flex-column">
                                    <span>{{ $deconsigneglobale - $reste < 0 ? 0 : $deconsigneglobale - $reste }} Ar (déconsigne)</span>
                                    <span class="text-success">+ {{ number_format($totalconsigne ?? 0, 0, ',', ' ') }} Ar (consigne bouteilles)</span>
                                    @if($nombreCageots > 0)
                                    <span class="text-info">+ {{ number_format($valeurCageots, 0, ',', ' ') }} Ar ({{ $nombreCageots }} cageots)</span>
                                    @endif
                                    <div class="border-top mt-1 pt-1">
                                        <span class="fw-bolder">= {{ number_format($montantTotal, 0, ',', ' ') }} Ar (total)</span>
                                    </div>
                                </div>
                            </td>
                            </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
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

                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        @if($conditionnement != null)
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Prix Cageot</th>
                                <th>Nombre Cageot</th>
                                <th>Total</th>
                                <th>État</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ optional($conditionnement->conditionnement)->id ?? 'N/A' }}</td>
                                <td>{{ optional($conditionnement->conditionnement)->id ? $cgt .' Ar/CGT' : 'N/A' }}</td>
                                <td>{{ optional($conditionnement->conditionnement)->nombre_cageot ? optional($conditionnement->conditionnement)->nombre_cageot. ' CGT' : 'N/A' }}</td>
                                <td>{{ optional($conditionnement->conditionnement)->nombre_cageot ? number_format(optional($conditionnement->conditionnement)->nombre_cageot * $cgt, 0, ',', ' ') .' Ar' : 'N/A' }}</td>
                                <td>{{ optional($conditionnement->conditionnement)->etat ?? 'N/A' }}</td>
                                <td>{{ optional($conditionnement->conditionnement)->created_at ? optional($conditionnement->conditionnement)->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    @if(optional($conditionnement->conditionnement)->id)
                                    <a href="#" data-toggle="modal" data-target="#venteModal2" class="text-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle me-2"></i>Aucun conditionnement enregistré
                                </td>
                            </tr>
                        </tbody>
                        @endif
                        <tr class="table-active fw-bold">
                            <td colspan="6" class="text-end uppercase">Total globale :</td>
                            <td class=""><span class="">@if($commande->etat_client == 1)
                                    {{ number_format($prixGlobale, 0, ',', ' ') }} Ar
                                    @else
                                    {{ number_format(optional($conditionnement->conditionnement)->id ? $prixGlobale + ($cgt * optional($conditionnement->conditionnement)->nombre_cageot) : $prixGlobale, 0, ',', ' ') }} Ar
                                    @endif</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Global Total -->

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="venteModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Déconsignaton cageot</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{(route('payer.condi'))}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="commande_id" value="{{$commande_id}}">
                    <p>Confirmer cette action?</p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">rendre</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="payement" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">regler payement</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{route('regler.payement')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="commande_id" value="{{$commande_id}}">
                    <input type="hidden" name="montant_total"
                        value="{{$deconsigneglobale}}">
                    <input type="hidden" name="montant_tot"
                        value="{{$montantTotal}}">
                    <input type="hidden" name="totalconsigne"
                        value="{{$totalconsigne + (optional($conditionnement->conditionnement)->nombre_cageot * $cgt)}}">
                    @if($deconsigneglobale - $reste <= 0)
                        <p class="text-danger">Le payement a déjà pour l'eau a déjà été fait.</p>
                        @else
                        <p>voulez-vous regler le payement de cette commande {{$commande_id}}? somme restant à payer <span class="text-danger">{{$deconsigneglobale - $reste}}</span> Ar </p>
                        <input type="number" name="somme" class="form-control" placeholder="montant" max="{{$prixGlobale - $reste}}">
                        @endif
                        <div class="m-5 form-group">
                            <input type="checkbox" id="all" name="all" class="form-check-input">
                            <label for="all">Tout regler en Argent (Avec BTL + CGT) <br>
                                <span class="fw-bold text-success">{{$montantTotal}} Ar</span>
                            </label>
                        </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Payer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('input[type="checkbox"][name="check_bouteille_casse"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const modalBody = this.closest('.modal-body');
                const venteId = this.id.replace('check_bouteille_casse', '');

                const inputCasse = modalBody.querySelector(`#bouteille_casse_input${venteId}`);
                const cageotContainer = modalBody.querySelector('#cageot_container');
                const bouteilleContainer = modalBody.querySelector('#bouteille_container');
                const titre = modalBody.querySelector('#titre');
                const cageotCasseContainer = modalBody.querySelector(`#cageot_casse_container${venteId}`);

                if (inputCasse && cageotContainer && bouteilleContainer && cageotCasseContainer) {
                    const isChecked = this.checked;
                    inputCasse.style.display = isChecked ? 'block' : 'none';
                    cageotContainer.style.display = isChecked ? 'none' : 'block';
                    bouteilleContainer.style.display = isChecked ? 'none' : 'block';
                    cageotCasseContainer.style.display = isChecked ? 'block' : 'none';
                    titre.style.display = isChecked ? 'block' : 'none';
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la checkbox "Tout régler"
        const allCheckbox = document.getElementById('all');
        const sommeInput = document.querySelector('input[name="somme"]');

        if (allCheckbox && sommeInput) {
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Remplir automatiquement avec le montant max quand "Tout régler" est coché
                    sommeInput.value = '';
                    sommeInput.readOnly = true;
                } else {
                    sommeInput.value = '';
                    sommeInput.readOnly = false;
                }
            });

            // Validation du montant saisi
            sommeInput.addEventListener('input', function() {
                const max = parseFloat(this.max);
                const value = parseFloat(this.value) || 0;

                if (value > max) {
                    this.value = max;
                    alert(`Le montant ne peut pas dépasser ${max} Ar`);
                }
            });
        }

        // Gestion soumission du formulaire
        const paymentForm = document.querySelector('.modal-body').closest('form');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                const reste = parseFloat("{{$deconsigneglobale - $reste}}");

                if (reste > 0) {
                    const montantSaisi = parseFloat(sommeInput.value) || 0;
                    if (montantSaisi <= 0) {
                        e.preventDefault();
                        alert('Veuillez saisir un montant valide');
                        return;
                    }
                }

                // Afficher un loader pendant le traitement
                const submitBtn = paymentForm.querySelector('[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            });
        }
    });
</script>


@endsection