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
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#venteModal">Nouvelle vente</button>
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
                            <th>Désignation (article)</th>
                            <th>Numéro commande</th>
                            <th>Quantité</th>
                            <th>Prix unitaire (P.U)</th>
                            <th>Date vente</th>
                            <th>Référence</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Désignation (article)</th>
                            <th>Numéro commande</th>
                            <th>Quantité</th>
                            <th>Prix unitaire (P.U)</th>
                            <th>Date vente</th>
                            <th>Référence</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td>{{$vente['id']}}</td>
                            <td>{{$vente['article']}}</td>
                            <td>C-{{$vente['numero_commande']}}</td>
                            <td>{{$vente['quantite']}}</td>
                            <td>{{$vente['prix_unitaire']}} Ar</td>
                            <td>{{$vente['created_at']}}</td>
                            <td>{{$vente['reference']  ? $vente['reference'] : 'pas de reference'}}</td>
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
<div class="modal fade" id="venteModal" tabindex="-1" role="dialog" aria-labelledby="venteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="venteModalLabel">Nouvelle vente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="venteForm" method="POST" action="{{ route('vente.store') }}">
                    @csrf
                    <div class="row">
                        <!-- Première ligne : Clients et Numéro de commande -->
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
                                <label for="cm">Numéro commande</label>
                                <input type="text" value="C0{{ $dernier->id + 1}}" class="form-control" id="cm" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Deuxième ligne : Article et Date -->
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
                                <input type="date" class="form-control" id="datevente" value="today" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Troisième ligne : Achat par unité ou cageot -->
                        <div class="col-md-6">
                            <div class="unitecontainer">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="achatUnite">
                                        <label class="form-check-label" for="achatUnite">Achat par unité</label>
                                    </div>
                                </div>
                                <div id="quantiteCageotContainer">
                                    <div class="form-group">
                                        <label for="quantiteCageot">Quantité en cageot</label>
                                        <input type="number" class="form-control" id="quantiteCageot" min="1" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="cageotcontainer">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="achatCageot" checked>
                                        <label class="form-check-label" for="achatCageot">Achat par cageot</label>
                                    </div>
                                </div>
                                <div id="quantiteUniteContainer" style="display: none;">
                                    <div class="form-group">
                                        <label for="quantiteUnite">Quantité en unité</label>
                                        <input type="number" class="form-control" id="quantiteUnite" min="1" value="1">
                                    </div>
                                </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const achatUnite = document.getElementById("achatUnite");
        const achatCageot = document.getElementById("achatCageot");
        const quantiteCageotContainer = document.getElementById("quantiteCageotContainer");
        const quantiteUniteContainer = document.getElementById("quantiteUniteContainer");

        function toggleDisplay() {
            if (achatUnite.checked) {
                quantiteUniteContainer.style.display = "block";
                quantiteCageotContainer.style.display = "none";
                achatCageot.checked = false;
            } else {
                quantiteUniteContainer.style.display = "none";
                quantiteCageotContainer.style.display = "block";
                achatCageot.checked = true;
            }
        }

        achatUnite.addEventListener("change", toggleDisplay);
        achatCageot.addEventListener("change", function() {
            achatUnite.checked = !achatCageot.checked;
            toggleDisplay();
        });

        document.getElementById('datevente').value = new Date().toISOString().split('T')[0];

        document.getElementById('ajouterArticle').addEventListener('click', function() {
            let articleSelect = document.getElementById('article');
            let datevente = document.getElementById('datevente').value;
            let selectedOption = articleSelect.options[articleSelect.selectedIndex];
            let articleId = selectedOption.value;
            let articleNom = selectedOption.text;
            let prix = selectedOption.getAttribute('data-prix');
            let quantite = achatUnite.checked ? document.getElementById('quantiteUnite').value : document.getElementById('quantiteCageot').value;

            if (quantite <= 0) {
                alert("Veuillez saisir une quantité valide.");
                return;
            }

            let total = prix * quantite;

            // Ajout de la ligne dans le tableau d'affichage
            let newRow = `<tr>
                <td>${articleNom}</td>
                <td>${prix} Ar</td>
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
                <input type="hidden" name="dateventes[]" value="${datevente}">

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
    });
</script>

@endsection