<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        * {
            font-weight: 700;
            color: #000;
        }

        .sidebar .nav-item .nav-link span {
            color: #fff;
        }

        .sidebar .sidebar-brand .sidebar-brand-text {
            color: white;
        }

        /* Correction pour Select2 dans les modals */
        .select2-container {
            z-index: 1051 !important;
            /* Doit être inférieur au z-index du modal */
        }

        .select2-dropdown {
            z-index: 1052 !important;
            /* Doit être légèrement supérieur au container mais inférieur au modal */
        }

        /* Augmentation du z-index pour le modal et son fond */
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* Correction pour le dropdown du select2 dans les modals */
        .modal-open .select2-container {
            z-index: 1051 !important;
        }

        .modal-open .select2-dropdown {
            z-index: 1052 !important;
        }

        .modal-open .select2-container--default .select2-selection--single,
        .modal-open .select2-container--default .select2-selection--multiple {
            background-color: #f8f9fa !important;
            /* Couleur de fond assombrie */
            opacity: 0.8 !important;
            /* Légère transparence pour l'effet "désactivé" */
        }

        /* Style pour le dropdown (liste déroulante) */
        .modal-open .select2-dropdown {
            background-color: #f8f9fa !important;
            opacity: 0.9 !important;
        }

        /* Style pour les options dans le dropdown */
        .modal-open .select2-results__option {
            background-color: #f8f9fa !important;
        }

        /* Style spécifique pour le fond du modal */
        .modal-backdrop {
            background-color: #000 !important;
            opacity: 0.5 !important;
        }

        .sidebar {
            width: 10rem !important;
            background-color: #000;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('page.accueil')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wine-bottle fa-2x text-gray-300"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Boissons</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="{{route('page.accueil')}}">
                    <i class="fas fa-home"></i>
                    <span>Page d'accueil</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Espace utilisateur</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('article.liste')}}">
                    <i class="fas fa-glass-martini-alt"></i>
                    <span>Boissons</span>
                </a>
                <a class="nav-link collapsed" href="{{route('categorie.liste')}}">
                    <i class="fas fa-tags"></i>
                    <span>Catégories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('commande.liste.vente')}}">
                    <i class="fas fa-cash-register"></i>
                    <span>Ventes</span>
                </a>
                <a class="nav-link collapsed" href="{{route('achat.liste')}}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Achats</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Clients et fournisseurs</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('client.liste')}}">
                    <i class="fas fa-users"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('fournisseur.liste')}}">
                    <i class="fas fa-truck"></i>
                    <span>Fournisseurs</span>
                </a>
                <a class="nav-link collapsed" href="{{route('parametre')}}">
                    <i class="fas fa-cog"></i> <!-- Icône de paramètres -->
                    <span>Paramètres</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('stock.liste')}}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Gestion de stock</span>
                </a>

            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <i class="fas fa-laugh-wink"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Se déconnecter') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>



                <!-- component -->
                <div class="container-fluid">

                    <!-- Page Heading -->



                    <!-- Modal Nouvelle vente -->
                    <section id="venteSection ">
                        <div class="card shadow mb-4 p-4">
                            <form id="venteForm" method="POST" action="{{ route('vente.store') }}">
                                @csrf
                                <div class="row">
                                    <!-- Première ligne : Clients et Numéro de commande -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Clients</label>
                                            <select class="form-control select2" id="client" name="client_id">
                                                <option value="">--client occasionnel--</option>
                                                @foreach($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cm">Numéro commande</label>
                                            <input
                                                type="text"
                                                value="C-{{ $dernier ? $dernier->id + 1 : 0 }}"
                                                class="form-control"
                                                id="cm"
                                                disabled>
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
                                                <option value="{{ $article->id }}" data-prix="{{ $article->prix_unitaire }}" data-condi="{{ $article->conditionnement }}" data-consignation="{{ $article->prix_consignation }}" data-prixcgt="{{$article->prix_cgt}}">{{ $article->nom }}</option>
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
                                            <div class="col-md-12 mb-3 d-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="achatUnite" checked>
                                                    <label class="form-check-label" for="achatUnite">Achat par unité</label>
                                                </div>
                                                <div class="form-check cageotcontainer ml-3">
                                                    <input class="form-check-input" type="checkbox" id="achatCageot">
                                                    <label class="form-check-label" for="achatCageot">Achat par cageot/pack</label>
                                                </div>
                                            </div>
                                            <div id="quantiteCageotContainer" style="display: none;">
                                                <div class="form-group">
                                                    <label for="quantiteCageot">Quantité en cageot</label>
                                                    <input type="number" class="form-control" id="quantiteCageot" min="1">
                                                </div>
                                            </div>
                                            <div id="quantiteUniteContainer">
                                                <div class="form-group">
                                                    <label for="quantiteUnite">Quantité en unité</label>
                                                    <input type="number" class="form-control" id="quantiteUnite" min="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- contenu -->
                                    </div>
                                    <div class="col-md-12 mb-3 d-flex justify-content-start">

                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" id="avec">
                                            <label class="form-check-label" for="avec">Avec bouteille</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="cgt" disabled>
                                            <label class="form-check-label" for="cgt">avec cageot</label>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12 mb-3 d-flex form-check ml-3">
                                        <input class="form-check-input" type="checkbox" id="unite" name="unites">
                                        <label class="form-check-label" for="unite">conditionner unité</label>
                                    </div> -->
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
                                            <th>Cgt</th>
                                            <th>BTL</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="articlesTable"></tbody>
                                </table>
                                <div class="form-footer d-flex justify-content-end">
                                    <p id="final" class="mr-3">0</p>
                                    <span class="mr-3">Ar</span>

                                    <button type="button"
                                        data-toggle="modal"
                                        data-target="#venteModal2"
                                        class="btn btn-primary"
                                        id="final2">
                                        Valider
                                    </button>
                                </div>

                                <div class="modal fade" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <!-- En-tête du modal -->
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title font-weight-bold" id="venteModal2Label">Configuration de la commande</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Corps du modal -->
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    <!-- Section Informations -->
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded">
                                                                <span class="font-weight-bold">Total unités :</span>
                                                                <span class="text-success font-weight-bold" id="tot">0</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section Options -->
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <h6 class="border-bottom pb-2 mb-3">Options de conditionnement</h6>

                                                            <!-- Option 1: Choix du nombre de cageots -->
                                                            <div class="form-group row align-items-center">
                                                                <div class="col-sm-8">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="choix" name="choix">
                                                                        <label class="form-check-label" for="choix">
                                                                            Définir manuellement le nombre de cageots
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-8" id="choix_content" style="display: none;">
                                                                    <input type="number" class="form-control form-control-sm" name="embale" id="embale" placeholder="Nombre">
                                                                </div>
                                                            </div>

                                                            <!-- Option 2: Non consigné -->
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="fidele" name="fidele">
                                                                    <label class="form-check-label" for="fidele">
                                                                        Non consigné (BTL + CGT)
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- Option 3: Paiement -->
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="payer" name="payer">
                                                                    <label class="form-check-label" for="payer">
                                                                        Paiement immédiat
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="disposition" name="disposition">
                                                                    <label class="form-check-label" for="disposition">
                                                                        à disposition
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section Informations conditionnement (optionnelle) -->
                                                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Cageot de 24 : <span class="text-warning font-weight-bold" id="c24">0</span></span>
                                    <span>Débordement : <span class="text-warning font-weight-bold" id="reste1">0</span> BTL</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Cageot de 20 : <span class="text-warning font-weight-bold" id="c20">0</span></span>
                                    <span>Débordement : <span class="text-warning font-weight-bold" id="reste2">0</span> BTL</span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                                                </div>
                                            </div>

                                            <!-- Pied de page du modal -->
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i> Annuler
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-check mr-1"></i> Valider
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>

                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const achatUnite = document.getElementById("achatUnite");
                        const achatCageot = document.getElementById("achatCageot");
                        const quantiteCageotContainer = document.getElementById("quantiteCageotContainer");
                        const quantiteUniteContainer = document.getElementById("quantiteUniteContainer");
                        const non = document.getElementById('non');
                        const avec = document.getElementById('avec');
                        const final = document.getElementById('final');
                        const final2 = document.getElementById('final2');
                        const final3 = document.getElementById('final3');
                        const tot = document.getElementById('tot');
                        const c24 = document.getElementById('c24');
                        const c20 = document.getElementById('c20');
                        const reste1 = document.getElementById('reste1');
                        const reste2 = document.getElementById('reste2');
                        const choix_content = document.getElementById('choix_content');
                        const choix = document.getElementById('choix');
                        const embale = document.getElementById('embale');

                        const uni = document.getElementById('unite'); // Assurez-vous que cet élément existe
                        // Assurez-vous que cet élément existe

                        const cgt_checkbox = document.getElementById('cgt');
                        const unite = document.getElementById('unite');
                        const vars = 1;

                        function toggleDisplay() {
                            if (achatUnite.checked) {
                                quantiteUniteContainer.style.display = "block";
                                quantiteCageotContainer.style.display = "none";
                                achatCageot.checked = false;
                                cgt_checkbox.checked = false;
                                cgt_checkbox.disabled = true;
                            } else {
                                quantiteUniteContainer.style.display = "none";
                                quantiteCageotContainer.style.display = "block";
                                achatCageot.checked = true;
                                cgt_checkbox.disabled = false;

                            }
                        }

                        if (uni) {
                            uni.addEventListener("change", function() {
                                if (uni.checked) {
                                    // Show final2 and hide final3
                                    final2.style.display = 'none';
                                    final3.style.display = 'block';
                                } else {
                                    // Hide final2 and show final3
                                    final2.style.display = 'block';
                                    final3.style.display = 'none';
                                }
                            });
                        }
                        if (choix) {
                            choix.addEventListener("change", function() {
                                if (choix.checked) {
                                    choix_content.style.display = 'block';
                                } else {
                                    // Hide final2 and show final3
                                    choix_content.style.display = 'none';
                                }
                            });
                        }


                        // if (avec) {
                        //     avec.addEventListener("change", function() {
                        //         if (!avec.checked && !non.checked) {
                        //             avec.checked = false;
                        //         }
                        //     });
                        // }

                        if (achatUnite) achatUnite.addEventListener("change", toggleDisplay);
                        if (achatCageot) {
                            achatCageot.addEventListener("change", function() {
                                achatUnite.checked = !achatCageot.checked;
                                toggleDisplay();
                            });
                        }

                        document.getElementById('datevente').value = new Date().toISOString().split('T')[0];
                        let totalQuantiteUnite = 0;

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
                            let prixcgt = parseInt(selectedOption.getAttribute('data-prixcgt'), 10) || 0;

                            let quantite = achatUnite.checked ?
                                parseInt(document.getElementById('quantiteUnite').value, 10) || 0 :
                                parseInt(document.getElementById('quantiteCageot').value, 10) || 0;
                            let types = achatUnite.checked ? '1' : '0';
                            let consignation = 'consigné';
                            const prix_cgt = prixcgt;

                            if (quantite <= 0) {
                                alert("Veuillez saisir une quantité valide.");
                                return;
                            }
                            totalQuantiteUnite += (achatUnite.checked) ? (prix_consignation != 0 ? quantite : 0) : 0;
                            tot.innerHTML = totalQuantiteUnite;
                            let total = avec.checked ?
                                prix * quantite :
                                (prix + prix_consignation) * quantite;
                            // // c20.innerHTML = Math.ceil(totalQuantiteUnite / 20);
                            // // c24.innerHTML = Math.ceil(totalQuantiteUnite / 24);
                            // reste2.innerHTML = totalQuantiteUnite < 20 ? 0 : totalQuantiteUnite % 20;
                            // reste1.innerHTML = totalQuantiteUnite < 24 ? 0 : totalQuantiteUnite % 24;

                            let totalenvoie = Math.ceil(totalQuantiteUnite / 24);
                            let totalconsignecageot = avec.checked ?
                                (cgt_checkbox.checked ? prix * conditionnement * quantite : (prix * conditionnement * quantite) + (prixcgt * quantite)) :
                                (cgt_checkbox.checked ? (prix_consignation + prix) * conditionnement * quantite : ((prix_consignation + prix) * conditionnement * quantite) + (prix_cgt * quantite));
                            let totalcageot = vars ?
                                (prix + prix_consignation) * quantite * conditionnement + (prix_cgt * quantite) :
                                totalconsignecageot;

                            let totalActuel = parseInt(final.innerHTML, 10) || 0;
                            final.innerHTML = totalActuel + (achatUnite.checked ? total : totalconsignecageot);

                            let newRow = `<tr data-tot=${achatUnite.checked ? quantite : 0} data-total="${achatUnite.checked ? total : totalconsignecageot}" data-id="${articleId}">
                <td>${articleNom}</td>
                <td>${prix} Ar</td>
                <td>${prix + prix_consignation} Ar</td>
                <td >${quantite} ${achatUnite.checked ? 'bouteille' : 'cageot/pack (' + conditionnement + ' bouteilles / CGT / PACK)'}</td>
                <td>${achatUnite.checked ? 'non conditionné' : (cgt_checkbox.checked ? '<span class="text-success">oui</span>(non consigné)' : '<span class="text-danger">non</span>('+prixcgt+'/ CGT)')}</td>
                <td>${avec.checked ? '<span class="text-success">oui</span>(non consigné)' : '<span class="text-danger">non</span>('+prix_consignation+' Ar/BTL)'}</td>
                <td>${achatUnite.checked ? total : totalconsignecageot} Ar</td>
                <td><button type="button" class="btn btn-danger btn-sm removeArticle">X</button></td>
            </tr>`;

                            document.getElementById('articlesTable').insertAdjacentHTML('beforeend', newRow);

                            let hiddenInputs = document.getElementById('hiddenInputs');
                            hiddenInputs.insertAdjacentHTML('beforeend', `
                <div class="hidden-group" data-id="${articleId}">
                    <input type="hidden" name="articles[]" value="${articleId}">
                    <input type="hidden" name="quantites[]" value="${quantite}">
                    <input type="hidden" name="prices[]" value="${prix}">
                    <input type="hidden" name="dateventes[]" value="${datevente}">
                    <input type="hidden" name="types[]" value="${types}">
                    <input type="hidden" name="consignations[]" value="${avec.checked && cgt_checkbox.checked ? '1' : '0'}">
                    <input type="hidden" name="bouteilles[]" value="${avec.checked ? '1' : '0'}">
                    <input type="hidden" name="cageots[]" value="${cgt_checkbox.checked ? '1' : '0'}">
                    <input type="hidden" name="quantite_embale" value="${totalenvoie}">

                </div>
            `);
                            // Réinitialiser les champs après ajout
                            document.getElementById('quantiteUnite').value = "";
                            document.getElementById('quantiteCageot').value = "";
                            articleSelect.dispatchEvent(new Event('change'));
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target.classList.contains('removeArticle')) {
                                let row = e.target.closest('tr');
                                let totalRow = parseInt(row.getAttribute('data-total'), 10) || 0;
                                let articleId = row.getAttribute('data-id');
                                let tots = parseInt(row.getAttribute('data-tot'), 10) || 0;
                                // Supprimer la ligne du tableau
                                row.remove();

                                // Mettre à jour le total final
                                let totalActuel = parseInt(final.innerHTML, 10) || 0;
                                final.innerHTML = totalActuel - totalRow;
                                totalQuantiteUnite -= tots;
                                tot.innerHTML = totalQuantiteUnite;
                                // Supprimer les inputs cachés associés
                                let hiddenGroup = document.querySelector(`.hidden-group[data-id="${articleId}"]`);
                                if (hiddenGroup) {
                                    hiddenGroup.remove();
                                }
                            }
                        });

                    });
                </script>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto"></div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialisation basique du select
            $('#article').select2({
                theme: 'bootstrap-5',
                placeholder: "Rechercher un article...",
                allowClear: true
            });

            // Initialisation avec AJAX
            $('#client').select2({
                theme: 'bootstrap-5',
                placeholder: "Rechercher un client...",
                allowClear: true
            });

            // Événement lorsqu'une ville est sélectionnée
            $('#villeSelect').on('select2:select', function(e) {
                var data = e.params.data;
                console.log('Ville sélectionnée:', data);
            });
        });
    </script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

</body>

</html>