@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">VENTE</h1>
    <p class="mb-4">Details de la commande</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><a href="{{route('vente.liste')}}">Listes ventes</a> --- <a href="{{route('commande.liste.vente')}}">Listes par commandes</a></h6>
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary btn-sm mr-3"> <a href="{{route('pdf.download')}}"><i class="fas fa-print text-white"></i></a>
                    <a class="text-white" href="{{route('pdf.download')}}">facture</a></button>
                <button class="btn btn-primary btn-sm"><a class="text-white" href="{{route('commande.liste.vente')}}">retour</a></button>

            </div>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Désignation</th>
                            <th>Numéro commande</th>
                            <th>Quantité</th>
                            <th>Prix unitaire (P.U)</th>
                            <th>Date vente</th>
                            <th>total</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td>{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>C-{{$vente['numero_commande']}}</td>
                            <td>{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <td>{{$vente['prix_unitaire']}} Ar</td>
                            <td>{{$vente['created_at']}}</td>
                            <td>{{$vente['reference'] ? $vente['reference'] : 'pas de reference'}}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="#"><i class="fas fa-print"></i></a>
                                <form action="#" style="display:inline;">
                                    <button type="submit" style="background:none; border:none; color:red;"><i class="fas fa-trash-alt"></i></button>
                                </form>
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