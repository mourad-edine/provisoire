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
            z-index: 99999 !important;
        }
        .modal-open .select2-container {
            z-index: 999999 !important;
        }
        .select2-dropdown {
            z-index: 999999 !important;
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
                <a class="nav-link collapsed" href="{{route('achat.commande')}}">
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
                @yield('content')
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