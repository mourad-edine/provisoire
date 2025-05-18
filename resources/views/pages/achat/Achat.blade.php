<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">

    <style>
        body {
            font-family: 'montserrat', sans-serif;
            padding-top: 60px;
            /* Compensation for fixed navbar */
            background-color: #f8f9fa;
        }

        /* Navbar styles */
        .main-navbar {
            background-color: #330705 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-dark .navbar-brand,
        .navbar-dark .nav-link,
        .navbar-dark .dropdown-item {
            color: #fff !important;
            font-weight: 600;
        }

        .navbar-dark .nav-link:hover,
        .navbar-dark .nav-link:focus {
            color: #f0ad4e !important;
        }

        .navbar-dark .dropdown-menu {
            background-color: #343a40;
            border: none;
        }

        .navbar-dark .dropdown-item:hover {
            background-color: #495057;
        }

        i {
            margin-right: 5px;
            color: #f0ad4e;
        }

        /* Select2 and modal fixes */
        .select2-container {
            z-index: 1060 !important;
        }

        .select2-dropdown {
            z-index: 1061 !important;
        }

        .modal {
            z-index: 1070 !important;
        }

        .modal-backdrop {
            z-index: 1060 !important;
        }

        /* Content styles */
        .main-content {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-top: 20px;
        }

        /* Form elements */
        .form-select.form-control-lg {
            height: 46px;
            padding: 0.5rem;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        /* Article sections */
        .article-section {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .remove-article {
            cursor: pointer;
            color: #dc3545;
        }

        .total-price {
            font-weight: bold;
            font-size: 1.1em;
            color: #28a745;
        }

        .price-details {
            font-size: 0.9em;
            color: #6c757d;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #000;
                padding: 10px;
                margin-top: 10px;
                border-radius: 5px;
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Main Navigation -->
    <nav style="z-index: 1063;" class="navbar navbar-expand-lg navbar-dark main-navbar fixed-top">
        <div class="container-fluid">
            

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('page.accueil')}}">
                            <i class="fas fa-home"></i>
                            Accueil
                        </a>
                    </li>

                    <!-- User Space Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userSpaceDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            Espace utilisateur
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{route('article.liste')}}">
                                    <i class="fas fa-glass-martini-alt"></i> Boissons
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('categorie.liste')}}">
                                    <i class="fas fa-tags"></i> Catégories
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('commande.liste.vente')}}">
                                    <i class="fas fa-cash-register"></i> commandes ventes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('achat.commande')}}">
                                    <i class="fas fa-cash-register"></i> commandes achats
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('depense')}}">
                                    <i class="fas fa-cash-register"></i>Dépense divers
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('vente.page')}}">
                                    <i class="fas fa-cash-register"></i> Ventes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('achat.page')}}">
                                    <i class="fas fa-shopping-cart"></i> Achats
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Clients & Suppliers -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="clientsDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-users"></i>
                            Clients & Fournisseurs
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{route('client.liste')}}">
                                    <i class="fas fa-users"></i> Clients
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('fournisseur.liste')}}">
                                    <i class="fas fa-truck"></i> Fournisseurs
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stat')}}">
                        <i class="fas fa-chart-bar"></i>
                        Statistique des ventes
                        </a>
                    </li>
                    <!-- Other Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('parametre')}}">
                            <i class="fas fa-cog"></i>
                            Paramètres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stock.liste')}}">
                            <i class="fas fa-boxes"></i>
                            Stock
                        </a>
                    </li>
                </ul>

                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-5 card shadow mb-4 border rounded p-3 position-relative" style="font-size: 0.9rem;">
        <div class="card-header bg-dark text-white d-flex justify-content-between mb-4">
            <h5 class="mb-0 text-white"><i class="fas fa-cash-register me-2"></i> Nouvelle achat</h5>
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left me-1 text-white"></i>Retour
            </a>
        </div>
        <form id="achatForm" method="POST" action="{{ route('achat.store') }}">
            @csrf

            <div class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label for="numero_commande" class="form-label">Numéro de commande</label>
                    <input type="text" class="form-control" id="numero_commande" name="numero" required>
                </div>
                <div class="col-md-4">
                    <label for="dateachat" class="form-label">Date</label>
                    <input type="date" class="form-control" id="dateachat" name="dateachat" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fournisseur" class="form-label">Fournisseur</label>
                    <select class="form-control select2" id="fournisseur" name="fournisseur_id" required>
                        @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <style>
        .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.3rem;
        display: block;
    }
        .form-control, .form-select {
        border: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
        background-color: white;
        font-size: 0.95rem;
        height: calc(1.5em + 0.75rem + 2px);
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        border-color: #80bdff;
    }
    
    .form-control[readonly] {
        background-color: #e9ecef;
        font-weight: 600;
        color: #212529;
    }
    
    </style>
            <div id="articlesContainer">
                <!-- Premier article -->
                <div class=" article-section mb-4 border rounded p-3 position-relative">
                    <div class="row g-3 align-items-end ">
                        <div class="col-md-3">
                            <label>Article</label>
                            <select class="form-control select2 article-select" data-index="0">
                                @foreach($articles as $article)
                                <option value="{{ $article->id }}"
                                    data-prix="{{ $article->prix_achat }}"
                                    data-condi="{{ $article->conditionnement }}"
                                    data-prixcgt="{{ $article->prix_cgt }}"
                                    data-consignation="{{ $article->prix_consignation }}">
                                    {{ $article->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Quantité (cageots)</label>
                            <input type="number" class="form-control quantite-input" data-index="0" min="1">
                        </div>
                        <div class="col-md-2">
                            <label>Quantité (unité)</label>
                            <input type="number" class="form-control quantiteunite-input" data-index="0" min="1">
                        </div>
                        <div class="col-md-2">
                            <label>Total (Ar)</label>
                            <input type="number" class="form-control total-input" data-index="0">
                        </div>
                        <div class="col-md-2">
                            <label>Prix unité (Ar)</label>
                            <input type="number" class="form-control prixunite-input" data-index="0" min="1" step="0.01" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <button type="button" class="btn btn-secondary" id="ajouterArticleBtn">
                    <i class="fas fa-plus text-white"></i> Ajouter un article
                </button>
                <div class="fs-5">
                    <span id="grandTotal">0</span> Ar
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" id="validerCommande">
                    <i class="fas fa-check-circle me-1"></i> Valider la commande
                </button>
            </div>

            <div id="hiddenInputs"></div>
        </form>
    </div>


    <!-- Modal de validation -->
    <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <!-- En-tête du modal -->
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title font-weight-bold" id="validationModalLabel">
                        <i class="fas fa-check-circle mr-2"></i>Confirmation de commande
                    </h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Corps du modal -->
                <div class="modal-body py-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                        <h5 class="font-weight-bold">Voulez-vous valider cette commande ?</h5>
                    </div>

                    <div class="alert bg-light  py-2 mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Montant total:</span>
                            <div><span class="h5 mb-0 text-dark font-weight-bold" id="modalTotal">0</span><span class="ml-2">Ar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pied de page du modal -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-dark" id="confirmSubmit">
                        <i class="fas fa-check mr-1"></i> Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialisation de Select2
            $('.select2').select2();

            // Variables pour suivre les index des articles
            let articleIndex = 0;

            // Fonction pour calculer le prix unitaire
            function calculatePricePerUnit(index) {
                const quantiteCageot = parseFloat($(`.quantite-input[data-index="${index}"]`).val()) || 0;
                const quantiteUnite = parseFloat($(`.quantiteunite-input[data-index="${index}"]`).val()) || 0;
                const total = parseFloat($(`.total-input[data-index="${index}"]`).val()) || 0;
                const selectedOption = $(`.article-select[data-index="${index}"] option:selected`);
                const conditionnement = parseFloat(selectedOption.data('condi')) || 1;

                let prixUnite = 0;
                
                if (quantiteCageot > 0) {
                    // Calcul pour achat par cageot
                    prixUnite = total / (quantiteCageot * conditionnement);
                } else if (quantiteUnite > 0) {
                    // Calcul pour achat par unité
                    prixUnite = total / quantiteUnite;
                }

                if (prixUnite > 0) {
                    $(`.prixunite-input[data-index="${index}"]`).val(prixUnite.toFixed(2));
                } else {
                    $(`.prixunite-input[data-index="${index}"]`).val('');
                }

                updateGrandTotal();
            }

            // Fonction pour mettre à jour le total général
            function updateGrandTotal() {
                let grandTotal = 0;

                $('.total-input').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });

                $('#grandTotal').text(grandTotal.toFixed(2));
                $('#modalTotal').text(grandTotal.toFixed(2));
            }

            // Fonction pour gérer l'exclusivité entre quantité cageot et unité
            function handleQuantiteExclusivity(index) {
                const quantiteCageot = $(`.quantite-input[data-index="${index}"]`);
                const quantiteUnite = $(`.quantiteunite-input[data-index="${index}"]`);

                if (quantiteCageot.val() && quantiteCageot.val() > 0) {
                    quantiteUnite.val('').prop('disabled', true);
                } else if (quantiteUnite.val() && quantiteUnite.val() > 0) {
                    quantiteCageot.val('').prop('disabled', true);
                } else {
                    quantiteCageot.prop('disabled', false);
                    quantiteUnite.prop('disabled', false);
                }
            }

            // Écouteurs d'événements
            $(document).on('input', '.quantite-input, .quantiteunite-input, .total-input', function() {
                const index = $(this).data('index');
                handleQuantiteExclusivity(index);
                calculatePricePerUnit(index);
            });

            $(document).on('change', '.article-select', function() {
                const index = $(this).data('index');
                $(`.prixunite-input[data-index="${index}"]`).val('');
                const currentTotal = $(`.total-input[data-index="${index}"]`).val() || '';
                $(`.total-input[data-index="${index}"]`).val(currentTotal);
                updateGrandTotal();
            });

            // Ajout d'un nouvel article
            $('#ajouterArticleBtn').click(function() {
                articleIndex++;

                const newArticleHtml = `
                <div class="article-section mb-4 border rounded p-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label>Article</label>
                            <select class="form-control select2 article-select" data-index="${articleIndex}">
                                @foreach($articles as $article)
                                <option value="{{ $article->id }}" 
                                    data-prix="{{ $article->prix_achat }}" 
                                    data-condi="{{ $article->conditionnement }}" 
                                    data-prixcgt="{{ $article->prix_cgt }}" 
                                    data-consignation="{{ $article->prix_consignation }}">
                                    {{ $article->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Quantité (cageots)</label>
                            <input type="number" class="form-control quantite-input" data-index="${articleIndex}" min="1" value="">
                        </div>
                        <div class="col-md-2">
                            <label>Quantité (unité)</label>
                            <input type="number" class="form-control quantiteunite-input" data-index="${articleIndex}" min="1" value="">
                        </div>
                        <div class="col-md-2">
                            <label>Total (Ar)</label>
                            <input type="number" class="form-control total-input" data-index="${articleIndex}" min="0" step="0.01" value="">
                        </div>
                        <div class="col-md-2">
                            <label>Prix unité (Ar)</label>
                            <input type="number" class="form-control prixunite-input" data-index="${articleIndex}" min="0" step="0.01" readonly>
                        </div>
                        
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn remove-article" data-index="${articleIndex}" title="Supprimer l'article">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>
                `;

                $('#articlesContainer').append(newArticleHtml);
                $(`.article-select[data-index="${articleIndex}"]`).select2();
                updateGrandTotal();
                handleQuantiteExclusivity(articleIndex);
            });

            // Suppression d'un article
            $(document).on('click', '.remove-article', function() {
                const index = $(this).data('index');
                $(this).closest('.article-section').remove();
                updateGrandTotal();
            });

            // Validation de la commande
            $('#validerCommande').click(function() {
                let isValid = true;
                $('.article-section').each(function() {
                    const index = $(this).find('.article-select').data('index');
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const total = $(this).find('.total-input').val();

                    if ((!quantite || quantite <= 0) && (!quantiteunite || quantiteunite <= 0) || !total || total <= 0) {
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    alert("Veuillez remplir tous les champs requis pour chaque article (quantité et total)");
                    return;
                }

                prepareHiddenInputs();
                const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
                validationModal.show();
            });

            // Confirmation finale
            $('#confirmSubmit').click(function() {
                $('#achatForm').submit();
            });

            // Fonction pour préparer les inputs cachés
            function prepareHiddenInputs() {
                $('#hiddenInputs').empty();

                $('.article-section').each(function(index) {
                    const sectionIndex = $(this).find('.article-select').data('index');
                    const articleId = $(this).find('.article-select').val();
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const prixUnite = $(this).find('.prixunite-input').val();
                    const total = $(this).find('.total-input').val();

                    $('#hiddenInputs').append(`
                    <input type="hidden" name="articles[]" value="${articleId}">
                    <input type="hidden" name="quantites[]" value="${quantite}">
                    <input type="hidden" name="quantitesunite[]" value="${quantiteunite ? quantiteunite : 0}">
                    <input type="hidden" name="prices[]" value="${prixUnite}">
                    <input type="hidden" name="totals[]" value="${total}">
                `);
                });

                $('#hiddenInputs').append(`
                <input type="hidden" name="fournisseur_id" value="${$('#fournisseur').val()}">
                <input type="hidden" name="dateachat" value="${$('#dateachat').val()}">
                <input type="hidden" name="numero_commande" value="${$('#numero_commande').val()}">
            `);
            }

            // Initialisation du premier article
            handleQuantiteExclusivity(0);
        });
    </script>
</body>
</html>