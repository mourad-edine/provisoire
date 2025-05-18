@extends('layouts.AdminLayout')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid" style="font-size: 0.85rem;">
    <!-- Statistiques principales -->
    <div class="row g-3">
        @php
        $cards = [
            [
                'title' => 'Nouvelle vente', 
                'value' => 'Commencer',
                'icon' => 'fa-cash-register',
                'color' => 'bg-vibrant-green',
                'text' => 'text-white',
                'link' => route('vente.page'),
                'action' => true
            ],
            [
                'title' => 'Approvisionnement', 
                'value' => 'Acheter',
                'icon' => 'fa-pallet',
                'color' => 'bg-vibrant-blue',
                'text' => 'text-white',
                'link' => route('achat.page'),
                'action' => true
            ]
        ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-xl-3 col-lg-4 col-md-6">
            @if(isset($card['link']))
            <a href="{{ $card['link'] }}" class="text-decoration-none card-hover-action">
            @endif
            
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-3 {{ $card['color'] }} {{ $card['text'] }}">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3 bg-white-30">
                            <i class="fas {{ $card['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-medium">{{ $card['title'] }}</h6>
                            <h5 class="mb-0 fw-bold">
                                {{ $card['value'] }}
                                <i class="fas fa-arrow-right ms-2 fa-xs"></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(isset($card['link']))
            </a>
            @endif
        </div>
        @endforeach
    </div>
    <div class="mt-3">

    <div class="card shadow mb-4">
        
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center bg-light">
            <!-- Barre de recherche avancée -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2 mb-md-0">
                <form action="{{ route('page.accueil') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
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

            <!-- Bouton d'ajout -->
            <div>
           
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
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>P.Vente unité</th>
                            <th>p.vente cageot/pack</th>
                            <th>P.Achat</th>
                            <th>P.Achat cageot/pack</th>
                            <th>Quantité</th>
                            <th>Date</th>
                            <th>details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article['id'] }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($article['nom'], 15) }}</td>
                            <td>{{ $article['categorie'] }}</td>
                            <td>{{ $article['prix_unitaire'] }} Ar</td>
                            <td>{{$article['prix_unitaire'] * $article['conditionnement'] . 'Ar'}}</td>
                            <!-- <td>{{ number_format($article['prix_conditionne'] ? $article['prix_conditionne'] / $article['conditionnement'] : 0, 2) }} Ar</td> -->
                            <td>{{$article['prix_achat']}}</td>
                            <!-- <td>{{ $article['prix_conditionne'] ? $article['prix_conditionne'] : 'pas de prix' }} Ar</td> -->
                            <td>{{$article['prix_achat'] * $article['conditionnement']}}</td>
                            <td>
                                @php
                                $quotient = intdiv($article['quantite'], $article['conditionnement']); // Division entière
                                $reste = $article['quantite'] % $article['conditionnement']; // Reste de la division
                                $affichage = $quotient;
                                @endphp
                                {{ $affichage }} cageot/pack{{ $affichage > 1 ? 's' : '' }} @if($reste> 0) et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}@endif
                            </td>
                            <td>
                                @if (!empty($article['created_at']))
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $article['created_at'])->format('Y-m-d') }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#editArticleModal{{$article['id']}}"><i class="fas fa-edit text-secondary"></i></a>
                                
                            </td>
                        </tr>
                        <div class="modal fade" id="supprimerModal{{$article['id']}}" tabindex="-1" role="dialog" aria-labelledby="supprimerModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="supprimerModalLabel">suppression</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>voulez-vous vraiment supprimer cette article <span class="text-warning">{{$article['nom']}} </span> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <a href="{{route('delete.article', ['id' => $article['id']])}}"><button type="submit" class="btn btn-danger">supprimer</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="editArticleModal{{$article['id']}}" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title" id="addArticleModalLabel">Modifier articles</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('articles.update') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nom">Nom</label>
                                                <input value="{{$article['nom']}}" type="text" class="form-control" id="nom" name="nom" readonly>
                                                <input type="hidden" name="id" value="{{$article['id']}}">
                                            </div>

                                            <div class="">
                                                <div class="form-group">
                                                    <label for="categorie">Catégorie</label>
                                                    <select class="form-control select2" id="categorie" name="categorie_id">
                                                        <option value="">----</option>
                                                        @foreach($categories as $categorie)
                                                        <option value="{{ $categorie->id }}" {{ $categorie->id == $article['categorie_id'] ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="conditionnement">conditionnement</label>
                                                    <select class="form-control" id="conditionnement" name="conditionnement" readonly>
                                                        <option value="{{$article['conditionnement']}}">{{$article['conditionnement']}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ml-3 mr-3 col-md-12 row">
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2" id="condi_cgt_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="cageot" readonly>
                                                    <label for="condi_cgt_{{ $article['id'] }}" class="form-label mb-0">Cageot</label>
                                                </div>
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2" id="condi_pack_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="pack" {{ $article['prix_consignation'] == 0 ? 'checked' : '' }} readonly>
                                                    <label for="condi_pack_{{ $article['id'] }}" class="form-label mb-0">Pack</label>
                                                </div>
                                                <div class="mb-3 col-md-6 d-flex align-items-center">
                                                    <input readonly type="radio" class="form-check-input me-2 condi_jet_radio" data-id="{{ $article['id'] }}" id="condi_jet_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="jet" {{ $article['prix_consignation'] > 0 && ($article['prix_cgt'] == 0 || $article['prix_cgt'] == null) ? 'checked' : '' }} >
                                                    <label for="condi_jet_{{ $article['id'] }}" class="form-label mb-0">BTL consigné / Emb jetable</label>
                                                </div>

                                            </div>

                                            <div class="form-group mt-2" id="consignation_field_{{ $article['id'] }}">
                                                <label for="diff_{{ $article['id'] }}">Prix consignation</label>
                                                <input type="number" class="form-control" id="diff_{{ $article['id'] }}" name="diff_{{ $article['id'] }}" value="{{ $article['prix_consignation'] ?? '' }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix d'achat unité</label>
                                                <input value="{{number_format($article['prix_achat'], 2, '.', '')}}" type="number" class="form-control" id="prix_achat" name="prix_achat" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix de vente unité</label>
                                                <input value="{{$article['prix_unitaire']}}" type="number" class="form-control" id="prix_unitaire" name="prix_unitaire" readonly>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">fermer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="10" class="">
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
                    {{ $articles->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Graphique des ventes -->
    <div class="row g-3 mt-3">
        <!-- Meilleures Ventes -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-trophy me-2 text-warning"></i> Meilleures ventes</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold" style="width: 70%">Produit</th>
                                    <th class="text-end pe-4 py-3 text-uppercase small fw-bold" style="width: 30%">Ventes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($meilleur as $meilleu)
                                <tr class="border-top border-bottom">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium text-dark">{{ $meilleu->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 py-3 fw-bold text-primary">
                                        {{ number_format($meilleu->achats_count, 0, ',', ' ') }}
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-top border-bottom">
                                    <td colspan="2" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle me-2"></i>Aucune donnée de vente disponible
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($meilleur) > 0)
                <div class="card-footer bg-white border-0 py-2 px-4">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i> Mis à jour à {{ now()->format('H:i') }}
                    </small>
                </div>
                @endif
            </div>
        </div>

        <!-- Stocks Faibles -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-exclamation-triangle me-2 text-danger"></i> Stocks faibles</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold" style="width: 50%">Produit</th>
                                    <th class="text-end py-3 text-uppercase small fw-bold" style="width: 20%">Stock</th>
                                    <th class="text-end pe-4 py-3 text-uppercase small fw-bold" style="width: 30%">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faible as $faib)
                                <tr class="border-top border-bottom">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm rounded-circle me-3 d-flex align-items-center justify-content-center bg-light-{{ $faib->quantite < 5 ? 'danger' : ($faib->quantite < 10 ? 'warning' : 'secondary') }}">
                                                <i class="fas fa-box-open text-{{ $faib->quantite < 5 ? 'danger' : ($faib->quantite < 10 ? 'warning' : 'secondary') }}"></i>
                                            </div>
                                            <span class="fw-medium text-dark">{{ $faib->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end py-3 fw-bold {{ $faib->quantite < 5 ? 'text-danger' : ($faib->quantite < 10 ? 'text-warning' : 'text-secondary') }}">
                                        {{ number_format($faib->quantite, 0, ',', ' ') }}
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        @if($faib->quantite < 5)
                                        <span class="badge bg-danger text-white bg-opacity-15 text-danger px-3 py-1">URGENT</span>
                                        @elseif($faib->quantite < 10)
                                        <span class="badge bg-warning text-white bg-opacity-15 text-warning px-3 py-1">ALERTE</span>
                                        @else
                                        <span class="badge bg-secondary text-white bg-opacity-15 text-secondary px-3 py-1">NORMAL</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-top border-bottom">
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="fas fa-check-circle me-2 text-success"></i>Tous les stocks sont suffisants
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($faible) > 0)
                <div class="card-footer bg-white border-0 py-2 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i> Dernière mise à jour
                        </small>
                        <a href="{{ route('achat.page') }}" class="btn btn-sm btn-danger px-3">
                            <i class="fas fa-plus me-1"></i>Approvisionner
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>

<style>
   :root {
    --vibrant-green: #6bbf59; /* Vert adouci */
    --vibrant-blue: #5a9bd4;  /* Bleu adouci */
}

.bg-vibrant-green {
    background-color: var(--vibrant-green);
}

.bg-vibrant-blue {
    background-color: var(--vibrant-blue);
}

.btn-vibrant-blue {
    background-color: var(--vibrant-blue);
    border-color: var(--vibrant-blue);
    color: white;
}

.btn-vibrant-blue:hover {
    background-color: #4a8ac2;
    border-color: #4a8ac2;
}

    
    .bg-white-30 {
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .card-hover-action .card {
        transition: all 0.3s ease;
    }
    
    .card-hover-action:hover .card {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
    }
    
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }

     /* Styles pour les tableaux */
     .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table thead th {
        border-bottom: 2px solid #e9ecef;
        border-top: none;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .table tbody tr.border-top {
        border-top: 1px solid #e9ecef;
    }
    
    .table tbody tr.border-bottom {
        border-bottom: 1px solid #e9ecef;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .avatar-sm {
        width: 36px;
        height: 36px;
    }
</style>

@endsection