@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="bg-dark card-header">
            <h5 class="mb-2 text-white">BOISSON</h5>
        </div>
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center bg-light">
            <!-- Barre de recherche avancée -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2 mb-md-0">
                <form action="{{ route('article.liste') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">
                    <i class="fas fa-plus-circle mr-2"></i>Ajouter boisson
                </button>
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
                            <th>Options</th>
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
                                <a class="text-danger ml-3 text-danger" href="#" data-toggle="modal" data-target="#supprimerModal{{ $article['id'] }}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
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
                                                <input value="{{$article['nom']}}" type="text" class="form-control" id="nom" name="nom" required>
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
                                                    <select class="form-control" id="conditionnement" name="conditionnement">
                                                        <option value="{{$article['conditionnement']}}">{{$article['conditionnement']}}</option>
                                                        <option value="48">Emballage de 48</option>
                                                        <option value="24">Emballlage de 24</option>
                                                        <option value="20">Emballlage de 20</option>
                                                        <option value="12">Emballlage de 12</option>
                                                        <option value="6">Emballlage de 6</option>
                                                        <option value="8">Emballlage de 8</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ml-3 mr-3 col-md-12 row">
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2" id="condi_cgt_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="cageot" {{ ($article['prix_consignation'] > 0 && $article['prix_cgt']) > 0 ? 'checked' : '' }}>
                                                    <label for="condi_cgt_{{ $article['id'] }}" class="form-label mb-0">Cageot</label>
                                                </div>
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2" id="condi_pack_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="pack" {{ $article['prix_consignation'] == 0 ? 'checked' : '' }}>
                                                    <label for="condi_pack_{{ $article['id'] }}" class="form-label mb-0">Pack</label>
                                                </div>
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2 condi_jet_radio" data-id="{{ $article['id'] }}" id="condi_jet_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="jet" {{ $article['prix_consignation'] > 0 && ($article['prix_cgt'] == 0 || $article['prix_cgt'] == null) ? 'checked' : '' }}>
                                                    <label for="condi_jet_{{ $article['id'] }}" class="form-label mb-0">Emb. jetable</label>
                                                </div>
                                                @if($article['prix_consignation'] > 0)
                                                <div class="mb-3 col-md-3 d-flex align-items-center">
                                                    <input type="radio" class="form-check-input me-2" id="reini_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="pack">
                                                    <label for="reini_{{ $article['id'] }}" class="form-label mb-0">Réinitialiser</label>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="diff_{{ $article['id'] }}">Prix consignation</label>
                                                <input type="number" class="form-control" value="{{ $article['prix_consignation'] ?? '' }}" readonly name="prix_consignation">
                                            </div>
                                            <div class="form-group mt-2">
                                                <label for="diff_{{ $article['id'] }}">Nouveau prix consignation</label>
                                                <input type="number" class="form-control" id="diff_{{ $article['id'] }}" name="diff_{{ $article['id'] }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix d'achat unité</label>
                                                <input value="{{number_format($article['prix_achat'], 2, '.', '')}}" type="number" class="form-control" id="prix_achat" name="prix_achat" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix de vente unité</label>
                                                <input value="{{$article['prix_unitaire']}}" type="number" class="form-control" id="prix_unitaire" name="prix_unitaire" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">enregistrer modification</button>
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


<!-- Modal d'ajout d'article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter un article</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('articles.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du boisson</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <select class="form-control select2" id="categorie" name="categorie_id" required>
                                    <option value=""></option>
                                    @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="conditionnement" class="form-label">Conditionnement</label>
                                <select class="form-control select2" id="conditionnement" name="conditionnement" required>
                                    <option value="">---Sélectionner---</option>
                                    <option value="48">Emballage de 48</option>
                                    <option value="24">Emballlage de 24</option>
                                    <option value="20">Emballlage de 20</option>
                                    <option value="12">Emballlage de 12</option>
                                    <option value="6">Emballlage de 6</option>
                                    <option value="8">Emballlage de 8</option>
                                </select>
                            </div>
                        </div>
                        <div class="ml-3 mr-3 col-md-12 row">
                            <div class="mb-3 col-md-3 d-flex align-items-center">
                                <input type="radio" class="form-check-input me-2" id="condi_cgts" name="choix" value="cageot" checked>
                                <label for="condi_cgts" class="form-label mb-0">Cageot</label>
                            </div>
                            <div class="mb-3 col-md-3 d-flex align-items-center">
                                <input type="radio" class="form-check-input me-2" id="condi_packs" name="choix" value="pack">
                                <label for="condi_packs" class="form-label mb-0">Pack</label>
                            </div>
                            <div class="mb-3 col-md-6 d-flex align-items-center">
                                <input type="radio" class="form-check-input me-2" id="condi_jet" name="choix" value="jet">
                                <label for="condi_jet" class="form-label mb-0">BTL consigné / Emb jetable</label>
                            </div>
                        </div>
                        <div class="form-group" id="consignation_field_add">
                            <label for="diff">Prix consignation</label>
                            <input type="number" class="form-control" id="diff" name="diff">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="checkCageot" name="checkCageot">
                                <label class="form-check-label" for="checkCageot">
                                    Ajouter un prix en cageot
                                </label>
                            </div>
                            <div class="" id="prix_achatcontainer" style="display: none;">
                                <div class="mb-3">
                                    <label for="prix_achat" class="form-label">Prix d'achat unité</label>
                                    <input type="number" class="form-control" id="prix_achat" name="prix_achat" step="0.01">
                                </div>
                            </div>
                            <div id="prixCageotContainer" style="display:none;">
                                <div class="mb-3">
                                    <label for="prix_conditionne" class="form-label">Prix d'achat cageot (facultatif <span class="text-danger">*</span>)</label>
                                    <input type="number" class="form-control" id="prix_conditionne" name="prix_conditionne" step="0.01">
                                </div>
                            </div>
                            <div id="quantiteContainer" style="display:none;">
                                <div class="mb-3">
                                    <label for="quantite" class="form-label">quantité initiale ( facultatif <span class="text-danger">*</span>)</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" step="0.01" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gestion des radios dans le modal d'ajout
        const choixRadios = document.querySelectorAll('input[name="choix"]');


        // Gestion des radios dans les modals d'édition
        document.querySelectorAll('[id^="condi_jet_"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const id = this.dataset.id;
                const field = document.getElementById(`consignation_field_${id}`);
                field.style.display = 'block';
            });
        });

        // Masquer les champs de consignation quand un autre choix est sélectionné


        // Gestion de la checkbox pour afficher/masquer les champs de prix
        document.getElementById('checkCageot').addEventListener('change', function() {
            document.getElementById('prixCageotContainer').style.display = this.checked ? 'block' : 'none';
            document.getElementById('prix_achatcontainer').style.display = this.checked ? 'block' : 'none';
            document.getElementById('quantiteContainer').style.display = this.checked ? 'block' : 'none';
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pour chaque modal d'édition
    document.querySelectorAll('[id^="editArticleModal"]').forEach(modal => {
        const id = modal.id.replace('editArticleModal', '');
        
        // Gestion du changement de radio
        const radios = modal.querySelectorAll(`input[name="choix_${id}"]`);
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                const reiniDiv = modal.querySelector(`#reini_${id}`).closest('div.mb-3');
                
                // Masquer "Réinitialiser" si "Pack" est sélectionné
                if (this.value === 'pack') {
                    reiniDiv.style.display = 'none';
                } else {
                    reiniDiv.style.display = 'flex';
                }
            });
        });

        // Initialiser l'état au chargement
        const checkedRadio = modal.querySelector(`input[name="choix_${id}"]:checked`);
        const reiniDiv = modal.querySelector(`#reini_${id}`).closest('div.mb-3');
        if (checkedRadio && checkedRadio.value === 'pack') {
            reiniDiv.style.display = 'none';
        }
    });
});
</script>
@endsection