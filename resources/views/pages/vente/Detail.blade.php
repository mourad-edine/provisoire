@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">VENTE</h1>
    <p class="mb-4">Details de la commande</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light border-bottom shadow-sm">
            <div class="d-flex">
                <a href="{{route('vente.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes ventes</a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <div class="d-flex">
                <a href="{{route('pdf.download',['id' => $commande_id])}}" class="btn btn-secondary btn-sm rounded shadow-sm d-flex align-items-center mr-3">
                    <i class="fas fa-print text-white mr-2"></i> Facture
                </a>
                <a href="{{route('commande.liste.vente')}}" class="btn btn-primary btn-sm rounded shadow-sm d-flex align-items-center">
                    Retour
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Désignation</th>
                            <th>commande</th>
                            <th>consignation</th>
                            <th>état</th>
                            <th>Quantité</th>
                            <!-- <th>(P.U)</th> -->
                            <th>(P.Consigné)</th>
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
                            <td>{{$vente['consignation'] ? $vente['consignation'] .' Ar': 'non consigné'}}</td>
                            <td>{{$vente['etat']}}</td>
                            <td>{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <!-- <td>{{$vente['prix_unitaire']}} Ar</td> -->
                            <td>{{$vente['prix_unitaire'] + $vente['prix_consignation']}} Ar</td>
                            <td>
                                @if($vente['type_achat'] === 'cageot')
                                {{ ($vente['prix_unitaire'] + $vente['prix_consignation']) * $vente['quantite'] * $vente['conditionnement'] }}Ar
                                @else
                                {{ ($vente['prix_unitaire'] + $vente['prix_consignation']) * $vente['quantite'] }} Ar
                                @endif
                            </td>
                            <td>{{$vente['created_at']}}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('pdf.download' , ['id'=>$commande_id])}}"><i class="fas fa-print text-warning"></i></a>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>

</script>

@endsection