@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Ajouter votre client
        .</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes catégorie</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">Ajouter client</button>
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
                            <th>date creation</th>
                            <th>options</th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clients as $client)

                        <tr>
                            <td>{{$client->id}}</td>
                            <td>{{$client->nom}}
                            <td>{{$client->numero ? $client->numero  :'pas de numero'}}
                            <td>{{$client->reference ? $client->reference  :'pas de reference'}}
                            <td>{{$client->created_at}}
                            <td>
                                <a href="#" data-toggle="modal" data-target="#supprimerArticleModal{{$client->id}}"><i class="fas fa-trash-alt text-danger"></i></button>
                            </td>
                        </tr>
                        <div class="modal fade" id="supprimerArticleModal{{$client->id}}" tabindex="-1" aria-labelledby="supprimerArticleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addArticleModalLabel">suppression </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <p>voulez-vous vraiment supprimer ce client ?</p>
                                                <input value="{{$client->nom}}" type="hidden" class="form-control" id="nom" name="nom" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">supprimer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-warning">pas encore de donné inséré pour le moment</td>
                            <td></td>
                            <td></td>
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