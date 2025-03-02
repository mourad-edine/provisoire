@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">VENTE</h1>
    <p class="mb-4">Ajouter votre vente.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes ventes</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#achatModal">Nouvelle vente</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th>id</th>
                        <th>Désignation (article)</th>
                        <th>Numéro commande</th>
                        <th>Référence</th>
                        <th>Quantité</th>
                        <th>Prix unitaire (P.U)</th>
                        <th>Date création</th>
                        <th>Options</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Désignation (article)</th>
                            <th>Numéro commande</th>
                            <th>Quantité</th>
                            <th>Référence</th>
                            <th>Prix unitaire (P.U)</th>
                            <th>Date création</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td>{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>{{$vente['numero_commande']}}</td>
                            <td>{{$vente['reference']}}</td>
                            <td>{{$vente['quantite']}}</td>
                            <td>{{$vente['prix_unitaire']}}</td>
                            <td>{{$vente['created_at']}}</td>
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
                            <td colspan="8" class="text-warning">Pas encore de données insérées pour le moment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Nouvelle vente -->
<div class="modal fade" id="achatModal" tabindex="-1" role="dialog" aria-labelledby="achatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="achatModalLabel">Nouvel vente</h5>
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
                                <label for="client">Clients</label>
                                <select class="form-control select-search" id="client" name="client_id">
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cm">numero commande</label>
                                <input type="text" value="C0{{ $dernier->id + 1}}" class="form-control" id="cm" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Colonne 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="article">Article</label>
                                <select class="form-control select-search" id="article">
                                    @foreach($articles as $article)
                                    <option value="{{ $article->id }}" data-prix="{{ $article->prix_unitaire }}">{{ $article->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateachat">Date</label>
                                <input type="date" class="form-control" id="dateachat" value="{{ date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Colonne 2 -->
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Prix</label>
                                <input type="number" class="form-control" id="price"disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantite">Quantité</label>
                                <input type="number" class="form-control" id="quantite" min="1" value="1">
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
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesTable"></tbody>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('dateachat').value = new Date().toISOString().split('T')[0];

    document.getElementById('ajouterArticle').addEventListener('click', function() {
        let articleSelect = document.getElementById('article');
        let selectedOption = articleSelect.options[articleSelect.selectedIndex];
        let articleId = selectedOption.value;
        let articleNom = selectedOption.text;
        let prix = selectedOption.getAttribute('data-prix');
        let quantite = document.getElementById('quantite').value;
        let price = document.getElementById('price').value;

        if (quantite <= 0) {
            alert("Veuillez saisir une quantité valide.");
            return;
        }

        let total = prix * quantite;

        // Ajout de la ligne dans le tableau d'affichage
        let newRow = `<tr>
        <td>${articleNom}</td>
        <td>${prix}</td>
        <td>${quantite}</td>
        <td>${total}</td>
        <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
    </tr>`;

        document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

        // Ajout des inputs cachés dans le formulaire pour l'envoi en POST
        let hiddenInputs = document.getElementById('hiddenInputs');
        hiddenInputs.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="articles[]" value="${articleId}">
        <input type="hidden" name="quantites[]" value="${quantite}">
        <input type="hidden" name="prices[]" value="${prix}">
    `);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeArticle')) {
            let row = e.target.closest('tr');
            row.remove();

            // Supprimer les inputs cachés correspondants
            let hiddenInputs = document.getElementById('hiddenInputs').children;
            for (let i = 0; i < 3; i++) {
                hiddenInputs[hiddenInputs.length - 1].remove(); // Supprime les inputs un par un
            }
        }
    });
</script>

@endsection
