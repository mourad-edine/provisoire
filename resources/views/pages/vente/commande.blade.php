@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
    <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('commande.liste.vente')}}">
                <button class="nav-link  active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('vente.liste')}}">
                <button class="nav-link" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Listes ventes
                </button>
            </a>
        </li>
        
    </ul>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary border-bottom">
            <h5 class="mb-2 text-white">VENTE</h5>

            <div>
                <a href="{{route('vente.page')}}" class="btn btn-primary btn-sm text-white text-decoration-none">Nouvelle vente</a>
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
                            <th>sous-total</th>
                            <th>consignation</th>
                            <th>total</th>
                            <th>état</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{$commande->id}}</td>
                            <td>{{$commande->client ? $commande->client->nom : 'client passager'}}</td>
                            <td>{{$commande->created_at}}</td>
                            <td>{{$commande->ventes_count}} </td>
                            <td>{{$commande->ventes_sum_prix}}Ar</td>
                            <td>{{$commande->ventes_consignation_sum_prix}} Ar</td>
                            <td>{{$commande->ventes_sum_prix}} Ar</td>
                            <td>@if($commande->etat_commande == 'payé')
                                <span class="text-success">
                                {{$commande->etat_commande}}
                                </span>
                                @else
                                <span class="text-danger">non payé</span>
                                @endif
                            </td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('commande.liste.vente.detail', ['id' => $commande->id]) }}" class=""><i class="fas fa-eye"></i></a>
                                <a href="{{route('pdf.download' , ['id'=>$commande->id])}}" class="ml-3"><i class="fas fa-print text-warning"></i></a>
                                <a href="#" class="ml-3"><i class="fas fa-edit text-warning"  data-toggle="modal" data-target="#venteModal2{{$commande->id}}"></i></a>

                                <form action="#" method="POST" style="display:inline;">

                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="venteModal2{{$commande->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">Rendre consignation</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('regler.payement')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="commande_id" value="{{$commande->id}}">
                                            <p>voulez-vous regler le payement de cette commande {{$commande->id}}?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" >Payer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

<!-- Modal Nouvelle vente -->
<div class="modal fade" id="venteModal" tabindex="-1" role="dialog" aria-labelledby="venteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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
                                    <option value="">--client passager--</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cm">Numéro commande</label>
                                <input type="text" value="C-{{ $dernier->id + 1}}" class="form-control" id="cm" disabled>
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
                                    <option value="{{ $article->id }}" data-prix="{{ $article->prix_unitaire }}" data-condi="{{ $article->conditionnement }}" data-consignation="{{ $article->prix_consignation }}">{{ $article->nom }}</option>
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
                        <div class="col-md-12 mb-3 d-flex justify-content-start">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="checkbox" id="non">
                                <label class="form-check-label" for="non">non consingé</label>
                            </div>
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="checkbox" id="avec" disabled>
                                <label class="form-check-label" for="avec">Avec bouteille</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cgt" disabled>
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
                                <th>P.U</th>
                                <th>Prix consigné</th>
                                <th>Quantité</th>
                                <th>BTL</th>
                                <th>état</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesTable"></tbody>
                    </table>

                    <div class="modal-footer">
                        <p id="final" class="ml-5">0</p><span>Ar</span><button type="submit" class="btn btn-primary">Valider</button>
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
        const non = document.getElementById('non');
        const avec = document.getElementById('avec');
        const final = document.getElementById('final'); // Assurez-vous que cet élément existe

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

        if (non) {
            non.addEventListener("change", function() {
                if (!non.checked) {
                    avec.checked = false; // Désactive "Avec"
                    avec.disabled = true;
                } else {
                    avec.disabled = false;
                }
            });
        }

        if (avec) {
            avec.addEventListener("change", function() {
                if (!avec.checked && !non.checked) {
                    avec.checked = false;
                }
            });
        }

        if (achatUnite) achatUnite.addEventListener("change", toggleDisplay);
        if (achatCageot) {
            achatCageot.addEventListener("change", function() {
                achatUnite.checked = !achatCageot.checked;
                toggleDisplay();
            });
        }

        document.getElementById('datevente').value = new Date().toISOString().split('T')[0];

        document.getElementById('ajouterArticle').addEventListener('click', function() {
            let articleSelect = document.getElementById('article');
            let datevente = document.getElementById('datevente').value;
            let selectedOption = articleSelect.options[articleSelect.selectedIndex];

            if (!selectedOption) {
                alert("Veuillez sélectionner un article.");
                return;
            }

            let articleId = selectedOption.value || "";
            let articleNom = selectedOption.text || "";
            let prix = parseInt(selectedOption.getAttribute('data-prix'), 10) || 0;
            let conditionnement = parseInt(selectedOption.getAttribute('data-condi'), 10) || 1;
            let prix_consignation = parseInt(selectedOption.getAttribute('data-consignation'), 10) || 0;

            let quantite = achatUnite.checked ?
                parseInt(document.getElementById('quantiteUnite').value, 10) || 0 :
                parseInt(document.getElementById('quantiteCageot').value, 10) || 0;
            let types = achatUnite.checked ? '1' : '0';
            let consignation = non.checked ? 'non consigné' : 'consigné';

            if (quantite <= 0) {
                alert("Veuillez saisir une quantité valide.");
                return;
            }

            let total = avec.checked ?
                prix * quantite :
                (prix + prix_consignation) * quantite;

            let totalconsignecageot = avec.checked ?
                prix * conditionnement * quantite :
                (prix_consignation + prix) * conditionnement * quantite;

            let totalcageot = non.checked ?
                prix * quantite * conditionnement :
                totalconsignecageot;

            let totalActuel = parseInt(final.innerHTML, 10) || 0;
            final.innerHTML = totalActuel + (achatUnite.checked ? total : totalcageot);

            let newRow = `<tr data-total="${achatUnite.checked ? total : totalcageot}">
                <td>${articleNom}</td>
                <td>${prix} Ar</td>
                <td>${prix + prix_consignation} Ar</td>
                <td>${quantite} ${achatUnite.checked ? 'bouteille' : 'cageot (' + conditionnement + ' bouteilles)'}</td>
                <td>${avec.checked ? 'oui' : 'non'}</td>
                <td>${consignation} ${non.checked ? '' : prix_consignation + ' Ar/BTL'}</td>
                <td>${achatUnite.checked ? total : totalconsignecageot} Ar</td>
                <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
            </tr>`;

            document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

            let hiddenInputs = document.getElementById('hiddenInputs');
            hiddenInputs.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="articles[]" value="${articleId}">
                <input type="hidden" name="quantites[]" value="${quantite}">
                <input type="hidden" name="prices[]" value="${prix}">
                <input type="hidden" name="dateventes[]" value="${datevente}">
                <input type="hidden" name="types[]" value="${types}">
                <input type="hidden" name="consignations[]" value="${non.checked ? '1' : '0'}">
                <input type="hidden" name="bouteilles[]" value="${avec.checked ? '1' : '0'}">
            `);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeArticle')) {
                let row = e.target.closest('tr');
                let totalRow = parseInt(row.getAttribute('data-total'), 10) || 0;

                row.remove();

                let totalActuel = parseInt(final.innerHTML, 10) || 0;
                final.innerHTML = totalActuel - totalRow;

                let hiddenInputs = document.getElementById('hiddenInputs').children;
                if (hiddenInputs.length >= 7) {
                    for (let i = 0; i < 7; i++) {
                        hiddenInputs[hiddenInputs.length - 1].remove();
                    }
                }
            }
        });
    });
</script>


@endsection