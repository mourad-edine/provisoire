@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">VENTE</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light border-bottom shadow-sm">
            <div class="d-flex">
                <a href="{{route('vente.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes ventes</a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <div class="d-flex">

                <!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#venteModal2">Nouvelle vente</button> -->
                <button class="btn btn-primary btn-sm"><a class="text-white text-decoration-none" href="{{route('vente.page')}}">Nouvelle vente</a></button>

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
                            <th>Art.</th>
                            <th>commande</th>
                            <th>consi(CGT/BTL)</th>
                            <th>état BTL</th>
                            <th>état CGT</th>
                            <th>état</th>
                            <th>Quantité</th>
                            <!-- <th>(P.U)</th> -->
                            <th>(Prix)</th>
                            <th>total</th>
                            <th>Date vente</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td>{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>C-{{$vente['numero_commande']}}</td>
                            <td>
                                @if($vente['consignation'] && $vente['prix_cgt'])
                                {{$vente['consignation'] + $vente['prix_cgt']}} Ar
                                @elseif($vente['consignation'])
                                {{$vente['consignation']}} Ar
                                @elseif($vente['prix_cgt'])
                                {{$vente['prix_cgt']}} Ar
                                @else
                                non consi°
                                @endif
                            </td>
                            <td>
                                <span class="{{ $vente['etat'] == 'non rendu' ? 'text-danger' : '' }}">
                                    {{ $vente['etat'] ?? 'non consi°' }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $vente['etat_cgt'] == 'non rendu' ? 'text-danger' : '' }}">
                                    {{ $vente['etat_cgt'] ?? 'non consi°' }}
                                </span>
                            </td>
                            <td>
                                <p class="text-success">payé</p>
                            </td>
                            <td>{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <!-- <td>{{$vente['prix_unitaire']}} Ar</td> -->
                            <td>{{$vente['btl'] == 0 ? $vente['prix_unitaire'] + $vente['prix_consignation'] : $vente['prix_unitaire']}} Ar</td>
                            <!-- <td>
                                @php
                                if($vente['type_achat'] == 'bouteille'){
                                    $prix_total = $vente['prix_unitaire'] * $vente['quantite'];
                                    if($vente['cgt'] == 0 && $vente['btl'] == 0){
                                        $prix_total += $vente['consignation'] + $vente['prix_cgt'];
                                    }else if($vente['cgt'] == 1 && $vente['btl'] == 0){
                                        $prix_total += $vente['consignation'];
                                    }else if($vente['cgt']== 0 && $vente['btl'] == 1){
                                        $prix_total += $vente['prix_cgt'];
                                    }else{
                                        $prix_total += 0;
                                    }
                                }else if ($vente['type_achat'] === 'cageot') {
                                    $prix_total = $vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement'];
                                    if($vente['cgt'] == 0 && $vente['btl'] == 0){
                                        $prix_total += $vente['consignation'] + $vente['prix_cgt'];
                                    }else if($vente['cgt'] == 1 && $vente['btl'] == 0){
                                        $prix_total += $vente['consignation'];
                                    }else if($vente['cgt']== 0 && $vente['btl'] == 1){
                                        $prix_total += $vente['prix_cgt'];
                                    }else{
                                        $prix_total += 0;
                                    }
                                }
                                @endphp

                                {{ $prix_total }} Ar
                            </td> -->
                            <td>
                                @php
                                $prix_total = $vente['prix_unitaire'] * $vente['quantite'];

                                if ($vente['type_achat'] === 'cageot') {
                                $prix_total *= $vente['conditionnement'];
                                }

                                // Gestion des frais supplémentaires en fonction de cgt et btl
                                $prix_total += match (true) {
                                $vente['cgt'] == 0 && $vente['btl'] == 0 => $vente['consignation'] + $vente['prix_cgt'],
                                $vente['cgt'] == 1 && $vente['btl'] == 0 => $vente['consignation'],
                                $vente['cgt'] == 0 && $vente['btl'] == 1 => $vente['prix_cgt'],
                                default => 0,
                                };
                                @endphp

                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>

                            <td>{{ \Carbon\Carbon::createFromTimestamp($vente['created_at'])->format('d-m-Y') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('commande.liste.vente.detail' ,['id' => $vente['numero_commande']] )}}"><i class="fas fa-eye text-secondary"></i></a>
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
                                                            Bouteille----------------------<span>{{$vente['consignation']}} Ar</span>
                                                        </label>
                                                        @elseif($vente['etat'] == 'avec BTL')
                                                        <label class="mb-0 cursor-pointer">
                                                            Bouteille----------------------<span class="text-success">non consigné</span>
                                                        </label>
                                                        @else
                                                        <label class="mb-0 cursor-pointer">
                                                            bouteille----------------------<span class="text-success">payé</span>
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
                                                            Cageot----------------------<span>{{$vente['prix_cgt']}} Ar</span>
                                                        </label>
                                                        @elseif($vente['etat_cgt'] == 'avec CGT' || $vente['etat_cgt'] == 'non condi°')
                                                        <label class="mb-0 cursor-pointer">
                                                            Cageot----------------------<span class="text-success">non consigné</span>
                                                        </label>
                                                        @elseif($vente['etat_cgt'] == 'conditionné')
                                                        <label class="mb-0 cursor-pointer">
                                                            Cageot----------------------<span class="text-success">conditionné (payer au commande liée)</span>
                                                        </label>
                                                        @else
                                                        <label class="mb-0 cursor-pointer">
                                                            Cageot----------------------<span class="text-success">payé</span>
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
                <div class="d-flex justify-content-start mt-3">
                    {{ $ventes->links('pagination::bootstrap-4') }} <!-- ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Button trigger modal -->


<!-- Modal Nouvelle vente -->
<div class="modal fade" id="venteModal" tabindex="-1" role="dialog" aria-labelledby="venteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="venteModalLabel">Nouvelle vente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('check_bouteille').addEventListener('change', function() {
            document.getElementById('embale').disabled = !this.checked;
        });

        document.getElementById('check_cageot').addEventListener('change', function() {
            document.getElementById('embale').disabled = !this.checked;
        });
    });
</script>
@endsection