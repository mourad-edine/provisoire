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
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">

    <style>
        body {
            font-family: 'montserrat', sans-serif;
            padding-top: 60px; /* Compensation for fixed navbar */
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
        a{
            color: #333;
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

<body id="page-top" >

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark main-navbar fixed-top">
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
                            <li><hr class="dropdown-divider"></li>
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

                    <!-- Other Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stat')}}">
                        <i class="fas fa-chart-bar"></i>
                        Statistique des ventes
                        </a>
                    </li>
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

    <!-- Main Content -->
    <div class="m-4">
        <div class="main-content" style="font-size: 0.9rem;">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
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
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialisation de Select2 avec configuration pour les modals
            function initSelect2() {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: "Sélectionner...",
                    allowClear: true,
                    dropdownParent: $('.modal') // Important pour les modals
                });
            }

            // Initialiser au chargement
            initSelect2();

            // Réinitialiser quand un modal est ouvert
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $(this),
                    width: '100%'
                });
            });
        });
    </script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

</body>

</html>