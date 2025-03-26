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
    <h1 class="h3 mb-2 text-gray-800">VENTE</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light border-bottom shadow-sm">
            <div class="d-flex">
                <a href="{{route('vente.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes ventes</a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
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
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Article</th>
                            <th>Commande</th>
                            <th>Consi(CGT/BTL)</th>
                            <th>État BTL</th>
                            <th>État CGT</th>
                            <th>État</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventes as $vente)
                        @php $highlightedId = session('highlighted_id'); @endphp
                        @php
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp
                        <tr id="row-{{$vente['id']}}" class="{{ $highlightedId == $vente['id'] ? 'highlighted' : '' }}">
                            <td>{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>C-{{$vente['numero_commande']}}</td>
                            <td>
                                @if($vente['consignation'] || $vente['prix_cgt'])
                                {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                @else
                                Non consigné
                                @endif
                            </td>
                            <td>
                                <span class="badge text-white {{ $vente['etat'] == 'non rendu' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $vente['etat'] ?? 'Non consigné' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-white {{ $vente['etat_cgt'] == 'non rendu' || $vente['etat_cgt'] == 'conditionné' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $vente['etat_cgt'] ?? 'Non consigné' }}
                                </span>
                            </td>
                            <td><span class="text-success">Payé</span></td>
                            <td>{{$vente['quantite']}} {{$vente['type_achat']}}</td>
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
                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>
                            <td></td>
                            <td>
                                <a href="{{route('commande.liste.vente.detail', ['id' => $vente['numero_commande']])}}">
                                    <i class="fas fa-eye text-secondary"></i>
                                </a>
                                <a class="ml-3" href="#" data-toggle="modal" data-target="#venteModal2{{$vente['id']}}">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>
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