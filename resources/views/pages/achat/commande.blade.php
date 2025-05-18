@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
    <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.commande')}}">
                <button class="nav-link  active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.liste')}}">
                <button class="nav-link" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes achats
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('achat.page')}}">
                <button class="nav-link active bg-dark text-white">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel achat
                </button>
            </a>
        </li>
       
    </ul>
    <div class="card shadow mb-4">
    <div class="p-3 mb-3 bg-light rounded shadow-sm">
            <form method="GET" action="{{ route('achat.commande') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="search" class="form-label">Nom|numero commande</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="date_debut" class="form-label">Date début</label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="date_fin" class="form-label">Date fin</label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="tri" class="form-label">Trier par date</label>
                    <select name="tri" id="tri" class="form-control">
                        <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                        <option value="asc" {{ request('tri') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100"><i class="fa fa-search"></i>Rechercher</button>
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
                            <th>numero_commande</th>
                            <th>id fournisseur</th>
                            <th>date commande</th>
                            <th>nombre d'achat</th>
                            <th>total</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{$commande->id}}</td>
                            <td>{{$commande->numero ? $commande->numero : 'pas de numero'}}</td>
                            <td>{{$commande->fournisseur ? $commande->fournisseur->nom : 'Nom fournisseur'}}</td>
                            <td>{{$commande->created_at}}</td>
                            <td>{{$commande->achats_count}} </td>
                            <td>{{$commande->achats_sum_prix}} Ar</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('achat.commande.detail', ['id' => $commande->id]) }}" class="mr-3"><i class="fas fa-eye"></i></a>
                                <a href="{{route('pdf.achat' , ['id' => $commande->id])}}"><i class="fas fa-print text-warning"></i></a>
                                <form action="#" method="POST" style="display:inline;">

                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                        <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pas de donnée trouvé -- 
                    </div>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{$commandes->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Nouvel Achat -->
<!-- Modal Nouvel Achat -->
<div class="modal fade" id="achatModal" tabindex="-1" role="dialog" aria-labelledby="achatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="achatModalLabel">Nouvel Achat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="achatForm" method="POST" action="{{ route('achat.store') }}">
                    @csrf

                    <div class="row">
                        <!-- Colonne 1 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="article">Article</label>
                                <select class="form-control select2" id="article">
                                    @foreach($articles as $article)
                                    <option value="{{ $article->id }}" data-prix="{{ $article->prix_achat }}" data-condi="{{$article->conditionnement}}" data-prixcgt="{{ $article->prix_cgt }}" data-consignation="{{$article->prix_consignation}}">{{ $article->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        

                        <!-- Colonne 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fournisseur">Fournisseur</label>
                                <select class="form-control select2" id="fournisseur" name="fournisseur_id" required>
                                    <option value="">--choisir fournisseur--</option>
                                    @foreach($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Colonne 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantite">Quantité en cageot</label>
                                <input type="number" class="form-control" id="quantite">
                            </div>
                        </div>

                        <!-- Colonne 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateachat">Date</label>
                                <input type="date" class="form-control" id="dateachat" value="today">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <!-- Colonne 1 -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="price">Total</label>
                                <input type="number" class="form-control" id="price" min="1">
                            </div>
                        </div>
                    </div>


                    <button type="button" class="btn btn-success" id="ajouterArticle">Ajouter</button>

                    <!-- Conteneur caché pour stocker les valeurs envoyées en POST -->
                    <div id="hiddenInputs"></div>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Prix par cageot</th>
                                <th>Quantité</th>

                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesTable"></tbody>
                    </table>

                    <div class="modal-footer">
                        <p id="total"></p><button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Avant la fermeture du body -->

@endsection