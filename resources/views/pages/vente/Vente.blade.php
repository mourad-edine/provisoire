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
    <style>
        .form-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-control,
        .form-select {
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            background-color: white;
            font-size: 0.95rem;
            height: calc(1.5em + 0.75rem + 2px);
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #80bdff;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
            font-weight: 600;
            color: #212529;
        }
    </style>
    <!-- fin sidebar -->
    <div class="container-fluid py-4" style="font-size: 0.9rem;">
        <div class="card shadow container p-3">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <h5 class="mb-0 text-white"><i class="fas fa-cash-register me-2"></i> Nouvelle vente</h5>
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left me-1 text-white"></i>Retour
                </a>
            </div>
            <div class="card-body">
                <form id="venteForm" action="{{ route('vente.store') }}" method="POST">
                    @csrf

                    <!-- Section Client -->
                    <div class="row mb-4">


                        <div class="col-md-3">
                            <label for="client_id" class="form-label">Client existant</label>
                            <select class="form-select form-control-lg searchable-select" id="client_id" name="client_id"
                                style="height: 46px; padding-top: 0.5rem; padding-bottom: 0.5rem;" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="nouveau_client" class="form-label">Nouveau client</label>
                            <input type="text" class="form-control" name="nouveau" id="nouveau_client" disabled>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" id="toggle_nouveau_client" class="btn btn-primary" title="Créer un nouveau client">
                                <i class="bi bi-plus-lg text-white"></i> <!-- Si tu utilises Bootstrap Icons -->
                                <!-- ou simplement : ➕ -->
                                <span style="font-size: 1rem;color : white;">+</span>
                            </button>
                        </div>
                        <div class="col-md-3">
                            <label for="date_vente" class="form-label">Date</label>
                            <input type="text" class="form-control" id="date_vente" value="{{ now()->format('d/m/Y') }}" readonly>
                        </div>
                        <input type="hidden" name="total_non_consignee" id="total_non_consignee">
                        <input type="hidden" name="tot_glob" id="tot_glob">
                        <div class="col-md-2">
                            <label for="numero_commande" class="form-label">N° Commande</label>
                            <input type="text" class="form-control" id="numero_commande" value="C-{{ str_pad(($dernier->id ?? 0) + 1, 5, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                    </div>

                    <hr>

                    <!-- Section Articles -->
                    <div id="articles-container">
                        <!-- Premier article -->
                        <div class="article-section" data-index="0">
                            <div class="row align-items-end mb-3">
                                <!-- Article -->
                                <div class="col-md-2">
                                    <label class="form-label">Article</label>
                                    <select class="form-select searchable-select article-select" name="articles[0][id]" required>
                                        <option value="">Sélectionner un article</option>
                                        @foreach($articles as $article)
                                        <option value="{{ $article->id }}"
                                            data-prix="{{ $article->prix_unitaire }}"
                                            data-consignation="{{ $article->prix_consignation }}"
                                            data-cgt="{{ $article->prix_cgt }}"
                                            data-conditionnement="{{ $article->conditionnement }}"
                                            data-quantite="{{ $article->quantite }}">

                                            {{ $article->nom }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Prix unitaire -->
                                <div class="col-md-1">
                                    <label class="form-label">P.U</label>
                                    <input type="number" class="form-control prix-unitaire" name="articles[0][prix_unitaire]" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">P.cgt</label>
                                    <input type="number" class="form-control prix-cgt" name="articles[0][prix_cgt]" readonly>
                                </div>

                                <div class="col-md-1">
                                    <label class="form-label">Qt.CGT</label>
                                    <input type="number" class="form-control stock-cageots" name="articles[0][stock_cageots]" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Qt.BTL</label>
                                    <input type="number" class="form-control stock-unites" name="articles[0][stock_unites]" readonly>
                                </div>
                                <!-- Quantité cageot -->
                                <div class="col-md-1">
                                    <label class="form-label">Cageot/pack</label>
                                    <input type="number" class="form-control quantite-cageot" name="articles[0][quantite_cageot]" min="0">
                                </div>

                                <!-- Quantité unité -->
                                <div class="col-md-1">
                                    <label class="form-label">Unité</label>
                                    <input type="number" class="form-control quantite-unite" name="articles[0][quantite_unite]" min="0">
                                </div>

                                <!-- Avec cageot -->
                                <div class="col-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input avec-cageot" type="checkbox" name="articles[0][avec_cageot]" id="avec_cageot_0" checked>
                                        <label class="form-check-label" for="avec_cageot_0">Cageot</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input avec-bouteille" type="checkbox" name="articles[0][avec_bouteille]" id="avec_bouteille_0" checked>
                                        <label class="form-check-label" for="avec_bouteille_0">Bouteille</label>
                                    </div>
                                </div>

                                <!-- Avec bouteille -->
                                <!-- <div class="col-md-1">
                                
                            </div> -->

                                <!-- Prix total -->
                                <div class="col-md-2 text-end">
                                    <label class="form-label">Total</label>
                                    <div class="total-price fw-bold" data-index="0">0.00 Ar</div>
                                    <div class="price-details small text-muted" data-index="0"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-12">
                            <button type="button" id="add-article" class="btn btn-secondary">
                                <i class="fas fa-plus me-2"></i> Ajouter un article
                            </button>
                        </div>
                    </div>

                    <hr>

                    <!-- Total général -->
                    <div class="row mb-4">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <h5>Total général:</h5>
                                <h5 id="global-total">0.00 Ar</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal"
                            data-target="#venteModal2"
                            class="btn btn-primary"
                            id="final2">
                            <i class="fas fa-check-circle me-2"></i> Valider la vente
                        </button>
                    </div>
                    <div class="modal fade" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- En-tête du modal -->
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title font-weight-bold" id="venteModal2Label">
                                        <i class="fas fa-cogs mr-2"></i>Configuration avancée de la commande
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <!-- Corps du modal -->
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <!-- Section Résumé -->
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="card border-secondary h-100">
                                                    <div class="card-header bg-secondary text-white py-2">
                                                        <h6 class="mb-0"><i class="fas fa-boxes mr-2"></i>Résumé des quantités</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center py-2">
                                                            <span class="font-weight-bold">Total unités :</span>
                                                            <span class="badge badge-dark badge-pill py-2 px-3" id="tot">0</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card border-secondary h-100">
                                                    <div class="card-header bg-secondary text-white py-2">
                                                        <h6 class="mb-0"><i class="fas fa-receipt mr-2"></i>Total global</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center py-2">
                                                            <span class="font-weight-bold">Montant final :</span>
                                                            <span class="h5 mb-0 font-weight-bold" id="global-total-modal">0 Ar</span>
                                                        </div>
                                                        <div id="empty-cageots-supplement" style="display: none;" class="text-right small mt-1">
                                                            <span class="text-muted">dont supplément cageots: </span>
                                                            <span class="text-warning font-weight-bold">0 Ar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Section Options -->
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0"><i class="fas fa-tools mr-2"></i>Options de conditionnement</h6>
                                            </div>
                                            <div class="card-body">
                                                <!-- Option Cageots vides -->
                                                <div class="form-group row mb-4">
                                                    <div class="col-sm-8">
                                                        <div class="custom-control custom-switch mb-2">
                                                            <input type="checkbox" class="custom-control-input" id="choix" name="choix" style="cursor : pointer;">
                                                            <label class="custom-control-label font-weight-bold" for="choix" style="cursor : pointer;">Ajouter des cageots vides</label>
                                                        </div>
                                                        <div id="choix_content" style="display: none;" class="pl-4">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="embale" id="embale" placeholder="Nombre de cageots">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text bg-light">unités</span>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted">Prix par cageot: <span id="cageot-unit-price">0</span> Ar</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Options de paiement -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="fidele" name="fidele" style="cursor : pointer;">
                                                                <label class="custom-control-label" for="fidele" style="cursor : pointer;">
                                                                    <i class="fas fa-user-check mr-1"></i> Mode non consigné
                                                                </label>
                                                                <small class="form-text text-muted">(Bouteilles + Cageots)</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="payer" name="payer" style="cursor : pointer;">
                                                                <label class="custom-control-label" for="payer" style="cursor : pointer;">
                                                                    <i class="fas fa-money-bill-wave mr-1"></i> Paiement immédiat
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-0">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="disposition" name="disposition" style="cursor : pointer;">
                                                                <label class="custom-control-label" for="disposition" style="cursor : pointer;">
                                                                    <i class="fas fa-archive mr-1 text-warning"></i> À disposition
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="paiement-fields" style="display: none;" class="mt-3 p-3 border rounded bg-light">
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label for="montant-recu">Montant reçu (Ar)</label>
                                                                <input type="number" class="form-control" id="montant-recu" name="montant_recu">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="montant-rendu">Montant à rendre (Ar)</label>
                                                                <input type="number" class="form-control" id="montant-rendu" name="montant_rendu" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pied de page du modal -->
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i> Annuler
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check-circle mr-1"></i> Confirmer la configuration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Template pour les nouveaux articles -->
    <template id="article-template">
        <div class="article-section" data-index="{index}">
            <div class="row align-items-end mb-3">
                <!-- Article -->
                <div class="col-md-2">
                    <select class="form-select searchable-select article-select" name="articles[{index}][id]" required>
                        <option value="">Sélectionner un article</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}"
                            data-prix="{{ $article->prix_unitaire }}"
                            data-consignation="{{ $article->prix_consignation }}"
                            data-cgt="{{ $article->prix_cgt }}"
                            data-conditionnement="{{ $article->conditionnement }}"
                            data-quantite="{{ $article->quantite }}">
                            {{ $article->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix unitaire -->
                <div class="col-md-1">
                    <input type="number" class="form-control prix-unitaire" name="articles[{index}][prix_unitaire]" readonly>
                </div>
                <div class="col-md-1">
                    <input type="number" class="form-control prix-cgt" name="articles[{index}][prix_cgt]" readonly>
                </div>

                <div class="col-md-1">
                    <input type="number" class="form-control stock-cageots" name="articles[{index}][stock_cageots]" readonly>
                </div>
                <div class="col-md-1">
                    <input type="number" class="form-control stock-unites" name="articles[{index}][stock_unites]" readonly>
                </div>
                <!-- Quantité cageot -->
                <div class="col-md-1">
                    <input type="number" class="form-control quantite-cageot" name="articles[{index}][quantite_cageot]" min="0">
                </div>

                <!-- Quantité unité -->
                <div class="col-md-1">
                    <input type="number" class="form-control quantite-unite" name="articles[{index}][quantite_unite]" min="0">
                </div>

                <!-- Avec cageot -->
                <div class="col-md-1">
                    <div class="form-check">
                        <input class="form-check-input avec-cageot" type="checkbox" name="articles[{index}][avec_cageot]" id="avec_cageot_{index}" checked>
                        <label class="form-check-label" for="avec_cageot_{index}">Cageot</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input avec-bouteille" type="checkbox" name="articles[{index}][avec_bouteille]" id="avec_bouteille_{index}" checked>
                        <label class="form-check-label" for="avec_bouteille_{index}">Bouteille</label>
                    </div>
                </div>

                <!-- Avec bouteille -->


                <!-- Prix total + bouton supprimer -->
                <div class="col-md-2 text-end">
                    <div class="total-price fw-bold" data-index="{index}">0.00 Ar</div>
                    <div class="price-details small text-muted" data-index="{index}"></div>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-article mt-2">
                        <i class="fas fa-trash text-white"></i>
                    </button>
                </div>
            </div>
        </div>

    </template>
</body>

</html>
<!-- Scripts -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("toggle_nouveau_client");
        const clientSelect = document.getElementById("client_id");
        const nouveauInput = document.getElementById("nouveau_client");

        let modeNouveauClient = false;

        toggleBtn.addEventListener("click", function() {
            modeNouveauClient = !modeNouveauClient;

            if (modeNouveauClient) {
                clientSelect.value = "";
                clientSelect.disabled = true;
                nouveauInput.disabled = false;
                toggleBtn.classList.remove("btn-outline-primary");
                toggleBtn.classList.add("btn-success");
            } else {
                nouveauInput.value = "";
                nouveauInput.disabled = true;
                clientSelect.disabled = false;
                toggleBtn.classList.remove("btn-success");
                toggleBtn.classList.add("btn-outline-primary");
            }
        });
    });
    $(document).on('change', '#payer', function() {
        if ($(this).is(':checked')) {
            $('#paiement-fields').show();
            $('#montant-recu').val('');
            $('#montant-rendu').val('');
            $('#montant-recu').focus();
        } else {
            $('#paiement-fields').hide();
        }
    });

    // Calcul du montant à rendre
    $(document).on('input', '#montant-recu', function() {
        const montantRecu = parseFloat($(this).val()) || 0;
        const total = parseFloat($('#tot_glob').val()) || 0;
        const montantRendu = montantRecu - total;

        if (montantRendu >= 0) {
            $('#montant-rendu').val(montantRendu.toFixed(2));
        } else {
            $('#montant-rendu').val('0.00');
        }
    });

    // Empêcher la fermeture du modal si paiement immédiat est coché mais montant non saisi
    $('#venteForm').submit(function(e) {
        if ($('#payer').is(':checked')) {
            const montantRecu = parseFloat($('#montant-recu').val()) || 0;
            const total = parseFloat($('#tot_glob').val()) || 0;

            if (montantRecu < total) {
                e.preventDefault();
                alert('Le montant reçu doit être supérieur ou égal au total à payer');
                $('#montant-recu').focus();
                return false;
            }
        }
        return true;
    });

    $(document).ready(function() {
        // Initialiser Select2
        $('.searchable-select').select2();

        // Variables globales
        let articleIndex = 1;
        let emptyCageotsPrice = 0;

        // Fonction pour calculer le prix total d'un article
        function calculateArticleTotal(index) {
            const section = $(`.article-section[data-index="${index}"]`);
            const prixUnitaire = parseFloat(section.find('.prix-unitaire').val()) || 0;
            const quantiteCageot = parseInt(section.find('.quantite-cageot').val()) || 0;
            const quantiteUnite = parseInt(section.find('.quantite-unite').val()) || 0;

            const selectedOption = section.find('.article-select option:selected');
            const prixConsignation = parseFloat(selectedOption.data('consignation')) || 0;
            const prixCgt = parseFloat(selectedOption.data('cgt')) || 0;
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;

            // Décocher automatiquement si prix à 0
            if (prixConsignation === 0) {
                section.find('.avec-bouteille').prop('checked', false);
            }
            if (prixCgt === 0) {
                section.find('.avec-cageot').prop('checked', false);
            }

            const avecCageot = prixCgt > 0 && section.find('.avec-cageot').is(':checked');
            const avecBouteille = prixConsignation > 0 && section.find('.avec-bouteille').is(':checked');

            const totalUnites = (quantiteCageot * conditionnement) + quantiteUnite;

            let total = totalUnites * prixUnitaire;
            let totalSansConsigne = total;

            let details = [];

            if (avecCageot && quantiteCageot > 0) {
                const suppCageot = quantiteCageot * prixCgt;
                total += suppCageot;
                details.push(`+ ${quantiteCageot} cageot: ${suppCageot.toFixed(2)}`);
            }

            if (avecBouteille && totalUnites > 0) {
                const suppBouteille = totalUnites * prixConsignation;
                total += suppBouteille;
                details.push(`+ ${totalUnites} bouteille: ${suppBouteille.toFixed(2)}`);
            }

            $(`.total-price[data-index="${index}"]`).text(total.toFixed(2) + ' Ar');
            $(`.price-details[data-index="${index}"]`).html(details.join('<br>'));

            return {
                totalAvecConsigne: total,
                totalSansConsigne: totalSansConsigne,
                prixCgt: prixCgt
            };
        }

        // Fonction pour calculer le total général
        function calculateGlobalTotal() {
            let globalTotal = 0;
            let globalNonConsigne = 0;
            let prixCgtReference = 0;

            $('.article-section').each(function() {
                const index = $(this).data('index');
                const result = calculateArticleTotal(index);
                globalTotal += result.totalAvecConsigne;
                globalNonConsigne += result.totalSansConsigne;

                if (prixCgtReference === 0) {
                    prixCgtReference = result.prixCgt;
                }
            });

            const emptyCageots = parseInt($('#embale').val()) || 0;
            emptyCageotsPrice = emptyCageots * prixCgtReference;

            const totalWithEmptyCageots = globalTotal + emptyCageotsPrice;

            $('#global-total').text(totalWithEmptyCageots.toFixed(2) + ' Ar');
            $('#total_non_consignee').val(globalNonConsigne.toFixed(2));
            $('#tot_glob').val(totalWithEmptyCageots.toFixed(2));
            $('#global-total-modal').text(totalWithEmptyCageots.toFixed(2) + ' Ar');

            if ($('#choix').is(':checked') && emptyCageots > 0) {
                $('#empty-cageots-supplement').show();
                $('#empty-cageots-supplement span').text(emptyCageotsPrice.toFixed(2) + ' Ar');
            } else {
                $('#empty-cageots-supplement').hide();
            }

            // Recalculer le montant à rendre si un montant a déjà été saisi
            if ($('#payer').is(':checked') && $('#montant-recu').val()) {
                $('#montant-recu').trigger('input');
            }
        }
        // Gestion du modal
        $('#venteModal2').on('show.bs.modal', function() {
            calculateGlobalTotal();
        });

        // Gestion des cageots vides
        $(document).on('change', '#choix', function() {
            if ($(this).is(':checked')) {
                $('#choix_content').show();
            } else {
                $('#choix_content').hide();
                $('#embale').val('');
                calculateGlobalTotal();
            }
        });

        $(document).on('input', '#embale', function() {
            calculateGlobalTotal();
        });

        // Fonction pour mettre à jour le stock affiché
        function updateStockDisplay(section) {
            const selectedOption = section.find('.article-select option:selected');
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
            const stockTotal = parseInt(selectedOption.data('quantite')) || 0;

            const cageots = Math.floor(stockTotal / conditionnement);
            const unites = stockTotal % conditionnement;

            section.find('.stock-total').val(stockTotal);
            section.find('.stock-cageots').val(cageots);
            section.find('.stock-unites').val(unites);
        }

        // Gérer le changement d'article
        $(document).on('change', '.article-select', function() {
            const selectedOption = $(this).find('option:selected');
            const prixUnitaire = parseFloat(selectedOption.data('prix')) || 0;
            const prixCgt = parseFloat(selectedOption.data('cgt')) || 0;
            const prixConsignation = parseFloat(selectedOption.data('consignation')) || 0;
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
            const prix_cageot = prixUnitaire * conditionnement;
            const parentSection = $(this).closest('.article-section');
            const index = parentSection.data('index');

            parentSection.find('.prix-unitaire').val(prixUnitaire.toFixed(2));
            parentSection.find('.prix-cgt').val(prix_cageot.toFixed(2));

            // Décocher automatiquement si prix à 0
            if (prixConsignation === 0) {
                parentSection.find('.avec-bouteille').prop('checked', false);
            }

            if (prixCgt === 0) {
                parentSection.find('.avec-cageot').prop('checked', false);
            }

            updateStockDisplay(parentSection);
            calculateGlobalTotal();
        });

        // Gérer les changements de quantité
        $(document).on('change input', '.quantite-cageot, .quantite-unite, .avec-cageot, .avec-bouteille', function() {
            const parentSection = $(this).closest('.article-section');
            const index = parentSection.data('index');

            const selectedOption = parentSection.find('.article-select option:selected');
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
            const stockTotal = parseInt(selectedOption.data('quantite')) || 0;

            const quantiteCageot = parseInt(parentSection.find('.quantite-cageot').val()) || 0;
            const quantiteUnite = parseInt(parentSection.find('.quantite-unite').val()) || 0;

            const totalDemande = (quantiteCageot * conditionnement) + quantiteUnite;

            if (totalDemande > stockTotal) {
                alert('La quantité demandée dépasse le stock disponible!');
                parentSection.find('.quantite-cageot').val(0);
                parentSection.find('.quantite-unite').val(0);
            }

            calculateGlobalTotal();
        });

        // Ajouter un nouvel article
        $('#add-article').click(function() {
            const template = $('#article-template').html();
            const newArticle = template.replace(/{index}/g, articleIndex);
            $('#articles-container').append(newArticle);

            $('#articles-container .article-select').last().select2();
            articleIndex++;
        });

        // Supprimer un article
        $(document).on('click', '.remove-article', function() {
            $(this).closest('.article-section').remove();
            calculateGlobalTotal();
        });

        // Validation du formulaire
        $('#venteForm').submit(function(e) {
            if ($('.article-section').length === 0) {
                e.preventDefault();
                alert('Veuillez ajouter au moins un article');
                return false;
            }

            let isValid = true;
            $('.article-select').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Veuillez sélectionner un article pour chaque ligne');
                return false;
            }

            return true;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const disposition = document.getElementById('disposition');
        const payer = document.getElementById('payer');
        const fidele = document.getElementById('fidele');

        disposition.addEventListener('change', function() {
            if (disposition.checked) {
                payer.checked = false;
                fidele.checked = false;
            }
        });

        payer.addEventListener('change', function() {
            if (payer.checked) {
                disposition.checked = false;
            }
        });

        fidele.addEventListener('change', function() {
            if (fidele.checked) {
                disposition.checked = false;
            }
        });
    });
</script>