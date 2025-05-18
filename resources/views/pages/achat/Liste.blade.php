@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<style>
    .highlighted {
        background-color: rgba(0, 255, 0, 0.3) !important;
        /* Fond vert avec opacité */
        transition: background-color 2s ease-out;
    }
</style>
<div class="">
    @php
    $highlightedId = session('highlighted_id');
    @endphp
    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
    <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.commande')}}">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('achat.liste')}}">
                <button class="nav-link active" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes achats
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('achat.page')}}">
                <button class="nav-link active bg-dark text-white">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel achat
                </button>
            </a>
        </li>
        
    </ul>
    <div class="card shadow mb-4">
        
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
                            <th>article</th>
                            <th>Prix unité</th>
                            <th>Prix / cageot</th>
                            <th>commande</th>
                            <th>quantite</th>
                            <th>état</th>
                            <th>total</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr>
                            <td>{{$achat['id']}}</td>
                            <td>{{$achat['article']}}</td>
                            <th>
                                {{$achat['prix_unite']}}
                            </th>
                            <td>{{$achat['prix_unite'] * $achat['conditionnement']}} </td>
                            <td>C-{{$achat['numero_commande']}}</td>

                            <td>{{$achat['quantite']}} -{{ $achat['type_achat']}}</td>
                            <td><span class="text-success">payé</span></td>
                            <td>{{ $achat['prix']  .' Ar' }}</td>
                            <td>{{$achat['created_at']}}</td>
                            <!-- <td>
                                <a href="#" class="ml-3" data-toggle="modal" data-target="#venteModal2{{$achat['id']}}"><i class="fas fa-edit text-warning"></i></button>
                            </td> -->
                        </tr>
                        <div class="modal fade" id="venteModal2{{$achat['id']}}" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- En-tête du modal -->
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title" id="venteModal2Label">Rendre consignation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Formulaire de paiement -->
                                    <form action="{{ route('payer.consignation.achat') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vente_id" value="{{ $achat['id'] }}">
                                        <input type="hidden" name="consignation_id" value="{{ $achat['consignation_id'] }}">

                                        <div class="modal-body">
                                            @php
                                            $bouteilleNonRendu = $achat['etat'] == 'non rendu';
                                            $cageotNonRendu = $achat['etat_cgt'] == 'non rendu';
                                            @endphp

                                            <!-- Section Bouteille -->
                                            <div class="form-group d-flex align-items-center">
                                                @if ($bouteilleNonRendu)
                                                <input type="checkbox" name="check_bouteille" id="check_bouteille{{ $achat['id'] }}" class="mr-2">
                                                <label for="check_bouteille{{ $achat['id'] }}" class="mb-0 cursor-pointer">
                                                    Bouteille <span class="ml-4">{{ $achat['prix'] }} Ar</span>
                                                </label>
                                                @else
                                                <label class="mb-0 cursor-pointer">
                                                    Bouteille <span class="ml-4 text-success">
                                                        {{ $achat['etat'] == 'non consigné' ? 'non consigné' : 'payé' }}
                                                    </span>
                                                </label>
                                                @endif
                                            </div>

                                            <!-- Section Cageot -->
                                            <div class="form-group d-flex align-items-center">
                                                @if ($cageotNonRendu)
                                                <input type="checkbox" name="check_cageot" id="check_cageot{{ $achat['id'] }}" class="mr-2">
                                                <label for="check_cageot{{ $achat['id'] }}" class="mb-0 cursor-pointer">
                                                    Cageot <span class="ml-4">{{ $achat['prix_cgt'] }} Ar</span>
                                                </label>
                                                @else
                                                <label class="mb-0 cursor-pointer">
                                                    Cageot <span class="ml-4 text-success">
                                                        {{ $achat['etat_cgt'] == 'non consigné' ? 'non consigné' : 'payé' }}
                                                    </span>
                                                </label>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Pied du modal -->
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" {{ !($bouteilleNonRendu || $cageotNonRendu) ? 'disabled' : '' }}>Payer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <td colspan="9" class="">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Pas de donnée trouvé --
                                </div>
                            </td>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $achats->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>
</div>

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
                                <select class="form-control select2" id="fournisseur" name="fournisseur_id">
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