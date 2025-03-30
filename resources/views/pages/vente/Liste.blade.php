@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<style>
    .highlighted {
        background-color: rgba(0, 255, 0, 0.3) !important;
        transition: background-color 2s ease-out;
    }
</style>

<div class="container-fluid">
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
            <h5 class="mb-2 text-white">VENTE</h5>

            <div>
                <a href="{{route('vente.page')}}" class="btn btn-primary btn-sm text-white text-decoration-none">Nouvelle vente</a>
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
                            <td>
                                @if($vente['etat_client'] == 1)
                                {{ number_format($vente['prix_unitaire'], 0, ',', ' ') }} Ar
                                @else
                                {{ number_format($vente['btl'] == 0 ? $vente['prix_unitaire'] + $vente['prix_consignation'] : $vente['prix_unitaire'], 0, ',', ' ') }} Ar
                                @endif
                            </td>
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
                                <div class="d-flex justify-content-end gap-2">

                                    <a href="{{route('commande.liste.vente.detail', ['id' => $vente['numero_commande']])}}" class="btn btn-sm btn-outline-secondary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    </a>
                                    <a class="btn btn-sm btn-outline-primary ml-2" href="#" data-toggle="modal" data-target="#venteModal2{{$vente['id']}}">
                                        <i class="fas fa-edit text-warning"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="venteModal2{{$vente['id']}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Rendre consignation</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('payer.consignation')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="vente_id" value="{{$vente['id']}}">
                                            <input type="hidden" name="consignation_id" value="{{$vente['consignation_id']}}">

                                            <div class="mb-3">
                                                @if($vente['etat'] == 'non rendu')
                                                <input type="checkbox" name="check_bouteille" id="check_bouteille{{$vente['id']}}" class="mr-2">
                                                <label for="check_bouteille{{$vente['id']}}">Bouteille - {{ number_format($vente['consignation'], 0, ',', ' ') }} Ar</label>
                                                @else
                                                <span class="text-success">Bouteille rendu</span>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                @if($vente['etat_cgt'] == 'non rendu')
                                                <input type="checkbox" name="check_cageot" id="check_cageot{{$vente['id']}}" class="mr-2">
                                                <label for="check_cageot{{$vente['id']}}">Cageot - {{ number_format($vente['prix_cgt'], 0, ',', ' ') }} Ar</label>
                                                @elseif($vente['etat_cgt'] == 'conditionné')
                                                <label class="mb-0 cursor-pointer">
                                                    <span class="text-danger">Bouteilles conditionné en cageot (payer au commande liée)</span>
                                                </label>
                                                @else
                                                <span class="text-success">Cageot rendu</span>
                                                @endif
                                            </div>
                                        </div>
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
                            <td colspan="12">Aucune vente trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $ventes->links('pagination::bootstrap-4') }} <!-- ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let highlightedRow = document.querySelector(".highlighted");
            if (highlightedRow) {
                highlightedRow.classList.remove("highlighted");
            }
        }, 10000);
    });
</script>
@endsection