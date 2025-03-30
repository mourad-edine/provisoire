@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
    <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.commande')}}">
                <button class="nav-link  active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.liste')}}">
                <button class="nav-link" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes achats
                </button>
            </a>
        </li>
       
    </ul>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary border-bottom shadow-sm">
        <h5 class="mb-2 text-white">ACHATS</h5>

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
                            <th>total</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{$commande->id}}</td>
                            <td>{{$commande->fournisseur ? $commande->fournisseur->nom : 'Nom fournisseur'}}</td>
                            <td>{{$commande->created_at}}</td>
                            <td>{{$commande->achats_count}} </td>
                            <td>{{$commande->achats_sum_prix}} Ar</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('achat.commande.detail', ['id' => $commande->id]) }}" class="mr-3"><i class="fas fa-eye"></i></a>
                                <a href="{{route('pdf.achat' , ['id' => $commande->id])}}"><i class="fas fa-print text-warning"></i></a>
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
                                <select class="form-control select2" id="article">
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
                                <select class="form-control select2" id="fournisseur" name="fournisseur_id" required>
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
                                <label for="quantite">Quantité en cageot</label>
                                <input type="number" class="form-control" id="quantite">
                            </div>
                        </div>

                        <!-- Colonne 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateachat">Date</label>
                                <input type="date" class="form-control" id="dateachat" value="today">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <!-- Colonne 1 -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="price">Total</label>
                                <input type="number" class="form-control" id="price" min="1">
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
                                <th>Prix par cageot</th>
                                <th>Quantité</th>

                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesTable"></tbody>
                    </table>

                    <div class="modal-footer">
                        <p id="total"></p><button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Avant la fermeture du body -->
<script>
    document.getElementById('dateachat').value = new Date().toISOString().split('T')[0];

    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let highlightedRow = document.querySelector(".highlighted");
            if (highlightedRow) {
                highlightedRow.classList.remove("highlighted");
            }
        }, 10000);
    });

    document.getElementById('ajouterArticle').addEventListener('click', function() {
        let articleSelect = document.getElementById('article');
        let frnsSelect = document.getElementById('fournisseur');
        let priceInput = document.getElementById('price');

        // Vérification que le prix est saisi et valide
        if (!priceInput.value || priceInput.value <= 0) {
            alert("Veuillez saisir un prix valide.");
            priceInput.focus();
            return;
        }


        let selectedOption = articleSelect.options[articleSelect.selectedIndex];
        let selectedOptionfrns = frnsSelect.options[frnsSelect.selectedIndex];

        let articleId = selectedOption.value;
        let articleNom = selectedOption.text;
        let fnrsId = selectedOptionfrns.value;
        let condi = selectedOption.getAttribute('data-condi');
        let prix = selectedOption.getAttribute('data-prix');
        let quantite = document.getElementById('quantite').value;
        let dateachat = document.getElementById('dateachat').value;
        let price = priceInput.value;

        if (quantite <= 0) {
            alert("Veuillez saisir une quantité valide.");
            return;
        }

        // Calcul du total pour cet article
        let articleTotal = price;

        // Ajout de la ligne dans le tableau
        let newRow = `<tr>
            <td>${articleNom}</td>
            <td>${price / quantite} Ar</td>
            <td>${quantite + ' cageot (' + condi + ' bouteilles/CGT)'}</td>
            <td class="article-total">${articleTotal} Ar</td>
            <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
        </tr>`;

        document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

        // Ajout des inputs cachés
        let hiddenInputs = document.getElementById('hiddenInputs');
        let wrapper = document.createElement('div');
        wrapper.classList.add('articleInputs');
        wrapper.innerHTML = `
            <input type="hidden" name="articles[]" value="${articleId}">
            <input type="hidden" name="quantites[]" value="${quantite}">
            <input type="hidden" name="dateachat[]" value="${dateachat}">
            <input type="hidden" name="prices[]" value="${price}">
            <input type="hidden" name="fournisseurs[]" value="${fnrsId}">
        `;

        hiddenInputs.appendChild(wrapper);

        // Mise à jour du total général
        updateTotal();

        // Réinitialisation des champs (sauf le prix)
        document.getElementById('quantite').value = '';
        priceInput.value = ''; // Garde le dernier prix saisi au lieu de revenir à 0
    });

    // Suppression d'un article
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeArticle')) {
            let row = e.target.closest('tr');
            let rowIndex = Array.from(row.parentNode.children).indexOf(row);
            row.remove();

            let hiddenInputs = document.getElementById('hiddenInputs');
            let wrappers = hiddenInputs.getElementsByClassName('articleInputs');
            if (wrappers[rowIndex]) {
                wrappers[rowIndex].remove();
            }

            // Mise à jour du total après suppression
            updateTotal();
        }
    });

    // Fonction pour calculer le total général
    function updateTotal() {
        let totalElements = document.querySelectorAll('.article-total');
        let grandTotal = 0;

        totalElements.forEach(el => {
            let value = parseFloat(el.textContent.replace(' Ar', ''));
            grandTotal += value;
        });

        document.getElementById('total').textContent = `Total: ${grandTotal} Ar`;
    }
</script>
@endsection