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
                            <th>numero commande</th>
                            <th>Tot consi°</th>
                            <th>etat CGT</th>
                            <th>etat BTL</th>
                            <th>quantite</th>
                            <th>état</th>
                            <th>date creation</th>
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
                                <span class="text-danger">{{$achat['etat_cgt']}}</span>
                                @elseif($achat['etat_cgt'] == 'non consigné')
                                <span class="text-success">{{$achat['etat_cgt']}}</span>
                                @else
                                <span class="text-success">non consigné</span>
                                @endif
                            </td>
                            <td>
                                @if($achat['etat'] == 'non rendu')
                                <span class="text-danger">{{$achat['etat']}}</span>
                                @elseif($achat['etat'] == 'non consigné')
                                <span class="text-success">{{$achat['etat']}}</span>
                                @else
                                <span class="text-success">non consigné</span>
                                @endif
                            </td>

                            <td>{{$achat['quantite']}} - cageot</td>
                            <td><span class="text-success">payé</span></td>
                            <td>{{$achat['created_at']}}</td>
                            <td>
                                <a href="#" class="ml-3"  data-toggle="modal" data-target="#venteModal2{{$achat['id']}}"><i class="fas fa-edit text-warning"></i></button>
                            </td>
                        </tr>
                        <div class="modal fade" id="venteModal2{{$achat['id']}}" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- En-tête du modal -->
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title" id="venteModal2Label">Payer consignation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Formulaire de paiement -->
                                    <form action="{{route('payer.consignation.achat')}}" method="POST">
                                        @csrf
                                        <!-- Corps du modal -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Section Bouteille -->
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group d-flex align-items-center">
                                                    <input type="hidden" value="{{$achat['id']}}" name="vente_id">

                                                        @if($achat['etat'] == 'non rendu')
                                                        <input type="checkbox" name="check_bouteille" id="check_bouteille{{$achat['id']}}" class="mr-2">
                                                        <label for="check_bouteille{{$achat['id']}}" class="mb-0 cursor-pointer">
                                                            Bouteille----------------------<span>{{$achat['prix']}} Ar</span>
                                                        </label>
                                                        @elseif($achat['etat'] == 'non consigné')
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
                                                       <input type="hidden" value="{{$achat['consignation_id']}}" name="consignation_id">

                                                        @if($achat['etat_cgt'] == 'non rendu')
                                                        <input type="checkbox" name="check_cageot" id="check_cageot{{$achat['id']}}" class="mr-2">
                                                        <label for="check_cageot{{$achat['id']}}" class="mb-0 cursor-pointer">
                                                            Cageot----------------------<span>{{$achat['prix_cgt']}} Ar</span>
                                                        </label>
                                                        @elseif($achat['etat_cgt'] == 'non consigné')
                                                        <label class="mb-0 cursor-pointer">
                                                            Cageot----------------------<span class="text-success">non consigné</span>
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

                                            @if($achat['etat'] == 'non rendu' || $achat['etat_cgt'] == 'non rendu')
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