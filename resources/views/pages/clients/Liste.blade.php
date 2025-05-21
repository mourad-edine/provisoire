@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-2 text-white">Clients</h5>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">
    <i class="fas fa-plus-circle mr-2"></i>Ajouter client
</button>        </div>
        <div class="d-flex flex-wrap align-items-center gap-2 mt-3 ml-3 mb-md-0">
            <form action="{{ route('client.liste') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <!-- Champ de recherche principal -->
                <div class="position-relative">
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="Rechercher..." value="{{ old('search', request('search')) }}">
                </div>

                <!-- Filtres supplémentaires -->


                <!-- Tri des résultats -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i> Trier par
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><button class="dropdown-item" type="submit" value="nom_asc">Nom (A-Z)</button></li>
                        <li><button class="dropdown-item" type="submit" value="nom_desc">Nom (Z-A)</button></li>
                        <li><button class="dropdown-item" type="submit" value="prix_asc">Prix (Croissant)</button></li>
                        <li><button class="dropdown-item" type="submit" value="prix_desc">Prix (Décroissant)</button></li>
                        <li><button class="dropdown-item" type="submit" value="stock_asc">Stock (Croissant)</button></li>
                        <li><button class="dropdown-item" type="submit" value="stock_desc">Stock (Décroissant)</button></li>
                    </ul>
                </div>
            </form>
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
                            <th>nom</th>
                            <th>numero</th>
                            <th>reference</th>
                            <th>bouteille(s)</th>
                            <th>cageot(s)</th>
                            <th>créance BTL+CGT</th>
                            <th>Reste à payer</th>
                            <th>Commande non payé</th>
                            <th>date creation</th>
                            <th>options</th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clients as $client)

                        <tr>
                            <td>{{$client['id']}}</td>
                            <td>{{$client['nom']}}
                            <td>{{$client['numero'] ? $client['numero']  :'pas de numero'}}
                            <td>{{$client['reference'] ? $client['reference']  :'pas de reference'}}
                            <td>{{$client['sum_btl']}}</td>
                            <td>{{$client['sum_cgt'] + $client['conditionnement']}}</td>
                            <td>{{ number_format($client['consignation_sum_prix'] + $client['consignation_sum_prix_cgt'] + ($client['conditionnement'] * $cgt), 0, ',', ' ') .'Ar'}}</td>
                            <td>{{$client['reste_a_payer'].' Ar'}}</td>

                            <!-- <td>{{ number_format($client['commandes_total'], 0, ',', ' ') .'Ar'}}</td> -->
                            <td ><a class="fw-bold text-{{$client['nombre_com_no_paye'] > 0 ? 'danger' : 'success'}}" href="{{route('client.commande' , ['id'=>$client['id']])}}">{{$client['nombre_com_no_paye']}}</a></td>

                            <td>{{$client['created_at']}}</td>
                            <td>
                                <a href="{{route('client.commande' , ['id'=>$client['id']])}}"><i class="fas fa-user-alt"></i></button>

                                    <a href="#" data-toggle="modal" data-target="#supprimerArticleModal{{$client['id']}}" class="ml-3"><i class="fas fa-trash-alt text-danger"></i></button>

                            </td>
                        </tr>
                        <div class="modal fade" id="supprimerArticleModal{{$client['id']}}" tabindex="-1" aria-labelledby="supprimerArticleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addArticleModalLabel">suppression </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>voulez-vous vraiment supprimer ce client ?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <a href="{{route('delete.client' , ['id' => $client['id'] ] )}}"><button type="button" class="btn btn-danger">supprimer</button></a>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>

                            <td class="text-warning" colspan="11">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Pas de donnée trouvé --
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $clients->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal d'ajout d'article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter un client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom client</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">numero</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="ref" name="ref">
                        <label for="ref">Ajouter une reference</label>
                    </div>
                    <div class="form-group" id="referenceContainer" style="display:none;">
                        <label for="reference">reference</label>
                        <input type="text" class="form-control" id="reference" name="reference">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('ref').addEventListener('change', function() {
        document.getElementById('referenceContainer').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection