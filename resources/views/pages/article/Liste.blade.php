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
                            <th>P.Vente</th>
                            <th>P.Achat</th>
                            <th>P.cageot</th>
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

                            <td>{{ $article['prix_achat'] }} Ar</td>
                            <td>{{ $article['prix_conditionne'] ? $article['prix_conditionne'] : 'pas encore de prix' }} Ar</td>
                            <td>
                                @php
                                $quotient = intdiv($article['quantite'], $article['conditionnement']); // Division entière
                                $reste = $article['quantite'] % $article['conditionnement']; // Reste de la division
                                $affichage = $quotient;
                                @endphp
                                {{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }} @if($reste> 0) et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}@endif
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
                                <a class="text-danger ml-3" href="#" data-toggle="modal" data-target="#supprimerModal{{ $article['id'] }}">
                                    <i class="fas fa-trash-alt"></i>
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
                                        <button type="submit" class="btn btn-danger">supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="editArticleModal{{$article['id']}}" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addArticleModalLabel">Ajouter un article</h5>
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
                                                    <label for="categorie">categorie</label>
                                                    <select class="form-control" id="categorie" name="categorie_id">
                                                        <option value="{{$article['categorie_id']}}">{{$article['categorie']}}</option>
                                                        @foreach($categories as $categorie)
                                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="conditionnement">conditionnement</label>
                                                    <select class="form-control" id="conditionnement" name="conditionnement">
                                                        <option value="{{$article['conditionnement']}}">---choisir---</option>
                                                        <option value="20">cageot de 20</option>
                                                        <option value="24">cageot de 24</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix d'achat</label>
                                                <input value="{{$article['prix_achat']}}" type="number" class="form-control" id="prix_achat" name="prix_achat" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="prix_unitaire">Prix de vente</label>
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
                            <td colspan="8" class="text-center text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $articles->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
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
                            <select class="form-control" id="conditionnement" name="conditionnement">
                                <option value="20">---selectionner--</option>
                                <option value="20">cageot de 20</option>
                                <option value="24">cageot de 24</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prix_unitaire">Prix d'achat</label>
                        <input type="number" class="form-control" id="prix_vente" name="prix_vente" required>
                    </div>
                    <div class="form-group">
                        <label for="prix_unitaire">Prix de vente</label>
                        <input type="number" class="form-control" id="prix_unitaire" name="prix_unitaire" required>
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