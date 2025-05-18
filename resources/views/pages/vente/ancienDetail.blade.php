@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid p-0">

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
                <button class="nav-link active bg-primary text-white">
                    <i class="fas fa-credit-card me-2"></i> Payer
                </button>
            </a>
        </li>
        @endif
    </ul>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white py-3">
            <h5 class="mb-0 font-weight-bold text-white">
                <i class="fas fa-receipt me-2"></i>VENTE - DETAILS
            </h5>
            <div class="d-flex gap-2">
                <a href="{{route('pdf.download',['id' => $commande_id])}}" class="btn btn-warning btn-sm text-white">
                    <i class="fas fa-print me-1 text-white"></i>Facture
                </a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left me-1 text-white"></i>Retour
                </a>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Ventes Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Article</th>
                            <th>Num</th>
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
                        @php $prixGlobale = 0;$deconsigneglobale = 0 ; $totalconsigne = 0; $totalbtl = 0; $totalcgt = 0; @endphp
                        @forelse($ventes as $vente)
                        @php
                        $highlightedId = session('highlighted_id');
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp

                        <tr id="row-{{$vente['id']}}" class="{{ $highlightedId == $vente['id'] ? 'bg-info' : '' }}">
                            <td class="fw-bold">{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td class="text-primary fw-bold">C-{{$vente['numero_commande']}}</td>
                            <td>
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                @if($vente['etat_client'] == 1)
                                <span class="badge bg-danger text-white">à rendre</span>
                                @elseif($vente['etat_client_commande'] == 2)
                                <span class="badge bg-warning">à disposition</span>
                                @else
                                <span class="badge bg-light text-dark">
                                    {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                </span>
                                @endif
                                @else
                                <span class="badge bg-light text-muted">Non consigné</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat'] == 'non rendu' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat'] ?$vente['etat'] .'-'. ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : 'non consigné' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ in_array($vente['etat_cgt'], ['non rendu', 'conditionné']) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                    {{ $vente['etat_cgt'] ? $vente['etat_cgt'] .'-'.  ($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']):'non consigné' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $vente['etat_payement'] == 0 ? 'bg-danger-light text-danger' : 'bg-success-light text-success' }}">
                                    <i class="fas {{ $vente['etat_payement'] == 0 ? 'fa-times-circle text-danger' : 'fa-check-circle text-success' }} me-1"></i>
                                    {{ $vente['etat_payement'] == 0 ? 'Non payé' : 'Payé' }}
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
                                $prix_total_deconsigne = ($vente['type_achat'] === 'cageot')
                                ? ($vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement'])
                                : ($vente['prix_unitaire'] * $vente['quantite']);

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
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white">Rendre consignation</h5>
                                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('payer.consignation') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="vente_id" value="{{ $vente['id'] }}">
                                            <input type="hidden" name="commande_id" value="{{ $vente['numero_commande'] }}">
                                            <input type="hidden" name="consignation_id" value="{{ $vente['consignation_id'] }}">
                                            <input type="hidden" name="article_id" value="{{ $vente['article_id'] }}">

                                            <!-- Bouteille Section -->
                                            <div class="mb-3">
                                                @if($vente['etat'] == 'non rendu')
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="check_bouteille" id="check_bouteille{{$vente['id']}}">
                                                    <label class="form-check-label" for="check_bouteille{{$vente['id']}}">
                                                        Bouteille - {{ $vente['consignation'] }} Ar ({{ $vente['consignation'] / $vente['prix_consignation']}} bouteille(s))
                                                    </label>
                                                </div>
                                                <input type="number" name="quantite_buteille" class="form-control" placeholder="nombre de bouteille à rendre" max="{{ $vente['consignation'] / $vente['prix_consignation']}}">
                                                @else
                                                <p class="text-{{ $vente['etat'] == 'avec BTL' ? 'muted' : 'success' }}">
                                                    Bouteille {{ $vente['etat'] == 'avec BTL' ? 'non consignée' : 'rendue' }}
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Cageot Section -->
                                            <div class="mb-3">
                                                @if($vente['etat_cgt'] == 'non rendu')
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="check_cageot" id="check_cageot{{$vente['id']}}">
                                                    <label class="form-check-label" for="check_cageot{{$vente['id']}}">
                                                        Cageot - {{ $vente['prix_cgt'] }} Ar ({{$vente['prix_cgt'] / $vente['consi_cgt'] }} cageot(s))
                                                    </label>
                                                </div>
                                                <input type="number" name="quantite_cageot" class="form-control" placeholder="nombre cageot à rendre" max="{{$vente['prix_cgt'] / $vente['consi_cgt'] }}">
                                                @else
                                                <p class="text-{{ in_array($vente['etat_cgt'], ['avec CGT', 'non condi°']) ? 'muted' : 'success' }}">
                                                    @if($vente['etat_cgt'] == 'conditionné')
                                                    <span class="text-danger">Bouteilles conditionnées en cageot</span>
                                                    @else
                                                    Cageot {{ in_array($vente['etat_cgt'], ['avec CGT', 'non condi°']) ? 'non consigné' : 'payé' }}
                                                    @endif
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                            @if($bouteilleNonRendu || $cageotNonRendu)
                                            <button type="submit" class="btn btn-primary">Rendre</button>
                                            @else
                                            <button type="button" class="btn btn-primary" disabled>Rendre</button>
                                            @endif
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
                            <td colspan="8" class="text-end"></td>
                            
                            <td>Total :</td>
                            <td colspan="2">{{ number_format($prixGlobale, 0, ',', ' ') }} Ar</td>

                        </tr>
                        <tr class="table-active fw-bold">
                            <td colspan="4" class="text-end"></td>
                            <td></td>
                            <td colspan="2">Bouteille consigné :</td>
                            <td>{{$totalbtl}}</td>
                            <td>Total déconsigné:</td>
                            <td colspan="2">{{ number_format($deconsigneglobale, 0, ',', ' ') }} Ar</td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td colspan="4" class="text-end"></td>
                            <td></td>
                            <td colspan="2">Cageot consigné :</td>
                            <td>{{$totalcgt + optional($conditionnement->conditionnement)->nombre_cageot}}</td>
                            <td>Total consignation:</td>
                            <td colspan="2">{{ number_format($totalconsigne + (optional($conditionnement->conditionnement)->nombre_cageot * $cgt), 0, ',', ' ') }} Ar</td>
                        </tr>
                        @if($commande->etat_commande == 'non payé')
                            <tr class="table-active fw-bold">
                            <td colspan="8" class="text-end"></td>
                            <td>Reste à payer :</td>
                            <td colspan="2" class="text-danger">{{ number_format($deconsigneglobale - $reste, 0, ',', ' ') }} Ar</td>
                        </tr>
                        @endif
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
                            <td class="">@if($commande->etat_client == 1)
                                {{ number_format($prixGlobale, 0, ',', ' ') }} Ar
                                @else
                                {{ number_format(optional($conditionnement->conditionnement)->id ? $prixGlobale + ($cgt * optional($conditionnement->conditionnement)->nombre_cageot) : $prixGlobale, 0, ',', ' ') }} Ar
                                @endif
                            </td>
                        </tr>
                        <!-- <tr class="table-active fw-bold">
                            <td colspan="6" class="text-end uppercase">Reste à payer:</td>
                            <td class="texte-danger">
                                <span class="text-danger">{{
                                    optional($conditionnement->conditionnement)->id 
                                    ? number_format($prixGlobale + ($cgt * optional($conditionnement->conditionnement)->nombre_cageot) - $reste, 0, ',', ' ') 
                                    : number_format($prixGlobale - $reste, 0, ',', ' ') 
                                }} Ar</span>
                            </td>
                            </td>
                        </tr> -->
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
            <div class="modal-header bg-light">
                <h5 class="modal-title">Rendre cageot</h5>
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
            <div class="modal-header bg-light">
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
                        value="{{ $deconsigneglobale}}">
                    <p>voulez-vous regler le payement de cette commande {{$commande_id}}? somme restant à payer <span class="text-danger">{{$deconsigneglobale - $reste}}</span> Ar </p>
                    <input type="number" name="somme" class="form-control" placeholder="montant" max="{{$prixGlobale - $reste}}" required>

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

</script>

@endsection