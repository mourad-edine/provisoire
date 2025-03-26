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
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">ACHAT</h1>
    <p class="mb-4">Ajouter votre achat.</p>
    @php
    $highlightedId = session('highlighted_id');
    @endphp
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <a href="{{route('achat.liste')}}" class="btn btn-outline-primary btn-sm font-weight-bold mr-2 px-3 shadow-sm">Listes Achats</a>
                <a href="{{route('achat.commande')}}" class="btn btn-outline-success btn-sm font-weight-bold px-3 shadow-sm">Listes par commandes</a>
            </div>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#achatModal">Nouvel Achat</button>
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
                            <th>article</th>
                            <th>P.Achat</th>
                            <th>commande</th>
                            <th>Tot consi°</th>
                            <th>etat CGT</th>
                            <th>etat BTL</th>
                            <th>quantite</th>
                            <th>état</th>
                            <th>total</th>
                            <th>date creation</th>
                            <th>options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr id="row-{{$achat['id']}}" class="{{ $highlightedId == $achat['id'] ? 'highlighted' : '' }}">
                            <td>{{$achat['id']}}</td>
                            <td>{{$achat['article']}}</td>
                            <td>{{$achat['prix_achat']}} Ar</td>
                            <td>C-{{$achat['numero_commande']}}</td>
                            <td>{{$achat['prix'] + $achat['prix_cgt']. ' Ar'}}</td>
                            <td>
                                @if($achat['etat_cgt'] == 'non rendu')
                                <span class="badge bg-danger text-white">{{$achat['etat_cgt']}}</span>
                                @elseif($achat['etat_cgt'] == 'non consigné')
                                <span class="badge bg-success text-white">{{$achat['etat_cgt']}}</span>
                                @elseif($achat['etat_cgt'] == 'rendu')
                                <span class="badge bg-success text-white">{{$achat['etat_cgt']}}</span>
                                @else
                                <span class="badge bg-success text-white">non consigné</span>
                                @endif
                            </td>
                            <td>
                                @if($achat['etat'] == 'non rendu')
                                <span class="badge bg-danger text-white">{{$achat['etat']}}</span>
                                @elseif($achat['etat'] == 'non consigné')
                                <span class="badge bg-success text-white">{{$achat['etat']}}</span>
                                @elseif($achat['etat'] == 'rendu')
                                <span class="badge bg-success text-white">{{$achat['etat']}}</span>
                                @else
                                <span class="badge bg-success text-white">non consigné</span>
                                @endif
                            </td>
                            <td>{{$achat['quantite']}} - cageot</td>
                            <td><span class="text-success">payé</span></td>
                            <td>{{ ($achat['prix_achat'] *  $achat['quantite'] * $achat['conditionnement']) + $achat['prix'] + $achat['prix_cgt'] .' Ar' }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $achat['created_at'])->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('achat.commande.detail', ['id' => $achat['numero_commande']]) }}">
                                    <i class="fas fa-eye text-secondary"></i>
                                </a>
                                <a href="#" class="ml-3" data-toggle="modal" data-target="#venteModal2{{$achat['id']}}">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="venteModal2{{$achat['id']}}" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- En-tête du modal -->
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title" id="venteModal2Label">Payer consignation</h5>
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
                        <tr>
                            <td colspan="7" class="text-warning text-center">Pas encore de données insérées pour le moment</td>
                        </tr>

                        <!-- payer consignation modal -->


                        <!-- payer consination fin -->
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
                                <th>Prix d'achat</th>
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

        // Ajout de la ligne dans le tableau
        let newRow = `<tr>
            <td>${articleNom}</td>
            <td>${price ? price : prix} Ar</td>
            <td>${quantite + ' cageot (' + condi + ' bouteilles/CGT)'}</td>
            <td>${cageot.checked ? '<span class="text-success">Oui</span>' : prix_cgt + ' Ar / CGT'}</td>
            <td>${bouteilles.checked ? '<span class="text-success">Oui</span>' : prix_consignation + ' Ar / BTL'}</td>
            <td>${total} Ar</td>
            <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
        </tr>`;

        document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

        // Ajout des inputs cachés dans un wrapper div spécifique
        let hiddenInputs = document.getElementById('hiddenInputs');

        let wrapper = document.createElement('div'); // Création d'un wrapper pour grouper les inputs liés à un article
        wrapper.classList.add('articleInputs'); // Pour repérer facilement
        wrapper.innerHTML = `
            <input type="hidden" name="articles[]" value="${articleId}">
            <input type="hidden" name="quantites[]" value="${quantite}">
            <input type="hidden" name="dateachat[]" value="${dateachat}">
            <input type="hidden" name="prices[]" value="${price ? price : prix}">
            <input type="hidden" name="fournisseurs[]" value="${fnrsId}">
            <input type="hidden" name="bouteilles[]" value="${bouteilles.checked ? 1 : 0}">
            <input type="hidden" name="cageots[]" value="${cageot.checked ? 1 : 0}">
            <input type="hidden" name="consignations[]" value="${cageot.checked && bouteilles.checked ? 0 : 1}">
        `;

        hiddenInputs.appendChild(wrapper);
    });

    // Suppression d'un article du tableau et des inputs cachés
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeArticle')) {
            let row = e.target.closest('tr');
            let rowIndex = Array.from(row.parentNode.children).indexOf(row);
            row.remove();

            // Supprimer le wrapper div correspondant aux inputs cachés
            let hiddenInputs = document.getElementById('hiddenInputs');
            let wrappers = hiddenInputs.getElementsByClassName('articleInputs');
            if (wrappers[rowIndex]) {
                wrappers[rowIndex].remove();
            }
        }
    });
</script>

@endsection