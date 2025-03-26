@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">ACHAT - DETAILS</h1>
    <p class="mb-4">details de la commande</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <a href="{{route('achat.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes Achats</a>
                <a href="{{route('achat.commande')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary btn-sm mr-3"> <a class="text-white" href="#"><i class="fas fa-print text-white mr-2"></i>facture</a></button>
                <button class="btn btn-primary btn-sm"><a class="text-white" href="{{route('achat.commande')}}">retour</a></button>
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
                            <th>P.Achat</th>
                            <th>commande</th>
                            <th>Tot consi°</th>
                            <th>etat CGT</th>
                            <th>etat BTL</th>
                            <th>quantite</th>
                            <th>état</th>
                            <th>total</th>
                            <th>date</th>
                            <th>options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr>
                            <td>{{$achat['id']}}</td>
                            <td>{{$achat['article']}}</td>
                            <td>{{$achat['prix_achat']}} Ar</td>
                            <td>C-{{$achat['numero_commande']}}</td>
                            <td>{{$achat['prix'] + $achat['prix_cgt']. 'Ar'}}</td>
                            <td>
                                @if($achat['etat_cgt'] == 'non rendu')
                                <span class="badge bg-danger text-white">{{$achat['etat_cgt']}}</span>
                                @elseif($achat['etat_cgt'] == 'non consigné')
                                <span class="badge bg-success text-white">{{$achat['etat_cgt']}}</span>
                                @elseif($achat['etat_cgt'] == 'rendu')
                                <span class="badge bg-success text-white">{{$achat['etat_cgt']}}</span>
                                @else
                                <span class="badge bg-success text-white">non consigné</span>
                                @endif
                            </td>
                            <td>
                                @if($achat['etat'] == 'non rendu')
                                <span class="badge bg-danger text-white">{{$achat['etat']}}</span>
                                @elseif($achat['etat'] == 'non consigné')
                                <span class="badge bg-success text-white">{{$achat['etat']}}</span>
                                @elseif($achat['etat'] == 'rendu')
                                <span class="badge bg-success text-white">{{$achat['etat']}}</span>
                                @else
                                <span class="badge bg-success text-white">non consigné</span>
                                @endif
                            </td>

                            <td>{{$achat['quantite']}} - cageot</td>
                            <td><span class="text-success">payé</span></td>
                            <td>{{ ($achat['prix_achat'] *  $achat['quantite'] * $achat['conditionnement']) + $achat['prix'] + $achat['prix_cgt'] .' Ar' }}</td>
                            <td>{{$achat['created_at']}}</td>
                            <td>
                                <a href="#" class="ml-3" data-toggle="modal" data-target="#venteModal2{{$achat['id']}}"><i class="fas fa-edit text-warning"></i></button>
                            </td>
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
                            <td colspan="7" class="text-warning text-center">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $achats->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection