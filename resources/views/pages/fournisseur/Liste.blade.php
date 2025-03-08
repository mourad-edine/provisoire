@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Ajouter votre fournisseur
        .</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes catégorie</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addArticleModal">Ajouter fournisseur</button>
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
                        @forelse($fournisseurs as $fournisseur)

                        <tr>
                            <td>{{$fournisseur->id}}</td>
                            <td>{{$fournisseur->nom}}
                            <td>{{$fournisseur->numero ? $fournisseur->numero  :'pas de numero'}}
                            <td>{{$fournisseur->reference ? $fournisseur->reference  :'pas de reference'}}
                            <td>{{$fournisseur->date_entre}}
                            <td>
                                <!-- Icônes d'options -->
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
            </div>
        </div>
    </div>

</div>


<!-- Modal d'ajout d'article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter un fournisseur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fournisseur.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom fournisseur</label>
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
