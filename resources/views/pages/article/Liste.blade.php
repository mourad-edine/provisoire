@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">BOISSON</h1>
    <p class="mb-4">Ajouter votre article.</p>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des boissons</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">Ajouter Boisson</button>
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
                            <th>Prix Unitaire (PU)</th>
                            <th>Prix Cageot (P.C)</th>
                            <th>Quantité</th>
                            <th>Date de Création</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article['id'] }}</td>
                            <td>{{ $article['nom'] }}</td>
                            <td>{{ $article['categorie'] }}</td>
                            <td>{{ $article['prix_unitaire'] }} Ar</td>
                            <td>{{ $article['prix_conditionne'] ? $article['prix_conditionne'] : 'pas encore de prix' }}</td>
                            <td>{{ $article['quantite'] }}</td>
                            <td>{{ $article['created_at'] }}</td>
                            <td>
                                <a href="#"><i class="fas fa-eye"></i></a>
                                <a href="#"><i class="fas fa-edit"></i></a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none; border:none; color:red;"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal d'ajout d'article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter un article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('articles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <label for="categorie">categorie</label>
                            <select class="form-control" id="categorie" name="categorie_id">
                                @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <label for="conditionnement">conditionnement</label>
                            <select class="form-control" id="conditionnement" name="conditionnement" >
                                <option value="20">---selectionner--</option>
                                <option value="20">cageot de 20</option>
                                <option value="24">cageot de 24</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prix_unitaire">Prix Unitaire</label>
                        <input type="number" class="form-control" id="prix_unitaire" name="prix_unitaire" required>
                    </div>
                    <div class="form-group">
                        <label for="prix_unitaire">Prix de vente</label>
                        <input type="number" class="form-control" id="prix_vente" name="prix_vente" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkCageot" name="checkCageot">
                        <label for="checkCageot">Ajouter un prix en cageot</label>
                    </div>
                    <div class="form-group" id="prixCageotContainer" style="display:none;">
                        <label for="prix_conditionne">Prix en Cageot</label>
                        <input type="number" class="form-control" id="prix_conditionne" name="prix_conditionne">
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité en cageot (facultatif <span style="color: red;">*</span> )</label>
                        <input type="number" class="form-control" id="quantite" name="quantite">
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
    document.getElementById('checkCageot').addEventListener('change', function() {
        document.getElementById('prixCageotContainer').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection