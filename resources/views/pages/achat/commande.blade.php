@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">ACHATS</h1>
    <p class="mb-4">liste par commande.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light border-bottom shadow-sm">
            <div class="d-flex">
                <a href="{{route('achat.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes Achats</a>
                <a href="{{route('achat.commande')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <div class="d-flex">

                <!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#venteModal">Nouvelle vente</button> -->
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#achatModal">Nouvel Achat</button>

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
                            <th>id</th>
                            <th>id client</th>
                            <th>date commande</th>
                            <th>nombre d'achat</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{$commande->id}}</td>
                            <td>{{$commande->client_id ? $commande->client_id : 'Nom fournisseur'}}</td>
                            <td>{{$commande->created_at}}</td>
                            <td>{{$commande->achats_count}} </td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('achat.commande.detail', ['id' => $commande->id]) }}" class="mr-3"><i class="fas fa-eye"></i></a>
                                <a href="#"><i class="fas fa-print text-warning"></i></a>
                                <form action="#" method="POST" style="display:inline;">

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
                <div class="d-flex justify-start-center mt-3">
                    {{ $commandes->links('pagination::bootstrap-4') }} <!-- ou 'pagination::bootstrap-5' -->
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
                                <select class="form-control select-search" id="article">
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
                                <select class="form-control select-search" id="fournisseur">
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
                                <label for="dateachat">Date</label>
                                <input type="date" class="form-control" id="dateachat" value="today" disabled>
                            </div>
                        </div>

                        <!-- Colonne 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Nouveau prix</label>
                                <input type="number" class="form-control" id="price" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Colonne 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantite">Quantité en cageot</label>
                                <input type="number" class="form-control" id="quantite" min="1" value="1" max="300">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 d-flex justify-content-start">

                            <div class="form-check mr-3">
                                <input class="form-check-input" type="checkbox" id="avec">
                                <label class="form-check-label" for="avec">Avec bouteille</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cgt">
                                <label class="form-check-label" for="cgt">avec cageot</label>
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
                                <th>CGT</th>
                                <th>BTL</th>
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
        let frnsSelect = document.getElementById('fournisseur');
        let bouteilles = document.getElementById('avec');
        let cageot = document.getElementById('cgt');

        let selectedOption = articleSelect.options[articleSelect.selectedIndex];
        let selectedOptionfrns = frnsSelect.options[frnsSelect.selectedIndex];

        let articleId = selectedOption.value;
        let articleNom = selectedOption.text;

        let fnrsId = selectedOptionfrns.value;

        let prix = selectedOption.getAttribute('data-prix');
        let condi = selectedOption.getAttribute('data-condi');
        let prix_cgt = selectedOption.getAttribute('data-prixcgt');
        let prix_consignation = selectedOption.getAttribute('data-consignation');

        let quantite = document.getElementById('quantite').value;
        let dateachat = document.getElementById('dateachat').value;
        let price = document.getElementById('price').value;

        let total = price ? (price * quantite * condi) + (condi * quantite * prix_consignation) + (prix_cgt * quantite) : (prix * condi * quantite) + (condi * quantite * prix_consignation) + (prix_cgt * quantite);

        if (bouteilles.checked) {
            total -= prix_consignation * quantite * condi;
        }
        if (cageot.checked) {
            total -= prix_cgt * quantite;
        }
        if (quantite <= 0) {
            alert("Veuillez saisir une quantité valide.");
            return;
        }



        // Ajout de la ligne dans le tableau d'affichage
        let newRow = `<tr>
        <td>${articleNom}</td>
        <td>${price  ? price : prix} Ar</td>
        <td>${quantite + 'cageot (' + condi + 'bouteilles/CGT)'} </td>
        <td>${cageot.checked ? '<span class="text-success">Oui</span>' : prix_cgt + 'Ar / CGT'}</td>
        <td>${bouteilles.checked ? '<span class="text-success">Oui</span>' : prix_consignation + 'Ar / BTL'}</td>
        <td>${total}Ar</td>
        <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
    </tr>`;

        document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

        // Ajout des inputs cachés dans le formulaire pour l'envoi en POST
        let hiddenInputs = document.getElementById('hiddenInputs');
        hiddenInputs.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="articles[]" value="${articleId}">
        <input type="hidden" name="quantites[]" value="${quantite}">
        <input type="hidden" name="dateachat[]" value="${dateachat}">
        <input type="hidden" name="prices[]" value="${price ? price : prix}">
        <input type="hidden" name="fournisseurs[]" value="${fnrsId}">
        <input type="hidden" name="bouteilles[]" value="${bouteilles.checked ? 1 : 0}">
        <input type="hidden" name="cageots[]" value="${cageot.checked  ? 1 : 0}">
        <input type="hidden" name="consignations[]" value="${cageot.checked && bouteilles.checked ? 0 : 1}">
    `);
    });

    // Suppression d'un article du tableau et des inputs cachés
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeArticle')) {
            let row = e.target.closest('tr');
            row.remove();

            // Supprimer les inputs cachés correspondants
            let hiddenInputs = document.getElementById('hiddenInputs').children;
            for (let i = 0; i < 5; i++) {
                hiddenInputs[hiddenInputs.length - 1].remove(); // Supprime les inputs un par un
            }
        }
    });
</script>
@endsection