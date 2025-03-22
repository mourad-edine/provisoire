@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">CATEGORIE</h1>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes catégorie</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">Ajouter catégorie</button>
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
                            <th>reference</th>
                            <th>nombre articles</th>
                            <th>image</th>
                            <th>date création</th>
                            <th>mise à jour</th>
                            <th>options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $categorie)
                        <tr>
                            <td>{{$categorie->id}}</td>
                            <td>{{$categorie->nom}}</td>
                            <td>{{$categorie->reference ? $categorie->reference : 'pas de reference'}}</td>
                            <td>{{$categorie->articles_count}}</td>
                            <td><img src="{{asset('assets/images/provisoire.jpg')}}" alt="" width="40" height="40"></td>
                            <td>{{$categorie->created_at}}</td>
                            <td>{{$categorie->updated_at}}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="#" data-toggle="modal" data-target="#editArticleModal{{$categorie->id}}"><i class="fas fa-edit text-secondary"></i></a>
                                <a class="ml-3" href="#" data-toggle="modal" data-target="#supprimerArticleModal{{$categorie->id}}"><i class="fas fa-trash-alt text-danger"></i></a>
                            </td>
                        </tr>
                        <div class="modal fade" id="editArticleModal{{$categorie->id}}" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addArticleModalLabel">Modifier categorie </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('categorie.update' , ['id'=> $categorie->id])}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nom">Nom categorie</label>
                                                <input value="{{$categorie->nom}}" type="text" class="form-control" id="nom" name="nom" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">enregistrer les modification</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- supprimer modal begin-->

                        <div class="modal fade" id="supprimerArticleModal{{$categorie->id}}" tabindex="-1" aria-labelledby="supprimerArticleModalLabel" aria-hidden="true">
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
                                            <p>voulez-vous vraiment supprimer cette categorie ?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <a href="{{route('delete.categorie', ['id' => $categorie->id])}}"><button type="button" class="btn btn-danger">supprimer</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- supprimer modal fin -->

                        @empty
                        <tr>
                            <td colspan="8" class="text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $categories->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
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
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter une categorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categorie.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom categorie</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkRef" name="checkRef">
                        <label for="checkCageot">Ajouter une reference</label>
                    </div>
                    <div class="form-group" id="refContainer" style="display:none;">
                        <label for="categorie">reference</label>
                        <input type="text" class="form-control" id="categorie" name="categorie">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkImage" name="checkImage">
                        <label for="checkCageot">Ajouter une image</label>
                    </div>
                    <div class="form-group" id="imageContainer" style="display:none;">
                        <label for="prix_unitaire">importer image</label>
                        <input type="file" class="form-control" id="prix_unitaire" name="prix_unitaire">
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
    document.getElementById('checkImage').addEventListener('change', function() {
        document.getElementById('imageContainer').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('checkRef').addEventListener('change', function() {
        document.getElementById('refContainer').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection