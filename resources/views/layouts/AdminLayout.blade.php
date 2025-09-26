<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            padding-top: 70px;
            min-height: 100vh;
        }

        .select2-container {
            z-index: 1050 !important;
        }

        .select2-dropdown {
            z-index: 1051 !important;
        }

        .nav-active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-active:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
        }

        .nav-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
        }

        .nav-item:hover:not(.nav-active) {
            background: rgba(255, 255, 255, 0.1);
            color: #fbbf24;
        }

        .dropdown-menu {
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-nav-active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-radius: 6px;
            margin: 2px 0;
        }

        /* Améliorations pour les sous-menus */
        .dropdown-group {
            position: relative;
        }

        .dropdown-content {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .dropdown-group:hover .dropdown-content,
        .dropdown-group:focus-within .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: all;
        }

        /* Délai pour éviter la fermeture accidentelle */
        .dropdown-content {
            transition-delay: 0.1s;
        }

        /* Triangle indicateur pour les sous-menus */
        .dropdown-content::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 20px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-left: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        /* Amélioration pour mobile */
        .mobile-dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .mobile-dropdown-open .mobile-dropdown-content {
            max-height: 500px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Main Navigation -->
    <nav class="fixed top-0 left-0 w-full bg-gradient-to-r from-gray-900 to-gray-800 text-white shadow-lg z-50 border-b border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent">
                        MonSite
                    </span>
                </div>

                <!-- Desktop Menu -->
                <div id="mainNavbar" class="hidden md:flex items-center space-x-1">
                    <!-- Accueil -->
                    <a href="{{ route('page.accueil') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('page.accueil') ||  request()->routeIs('stat')? 'nav-active' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage d'articles -->
                    <div class="dropdown-group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('article.liste') || request()->routeIs('categorie.liste') || request()->routeIs('depense') ? 'nav-active' : '' }}">
                            <i class="fas fa-cogs text-sm"></i>
                            <span>Paramétrage</span>
                            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                        </button>
                        <div class="dropdown-content absolute left-0 mt-2 w-56 z-50">
                            <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                                <a href="{{ route('article.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('article.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-glass-martini-alt mr-3 text-blue-500"></i>Boissons
                                </a>
                                <a href="{{ route('categorie.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('categorie.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-tags mr-3 text-green-500"></i>Catégories
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <!-- <a href="{{ route('depense') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 transition-colors {{ request()->routeIs('depense') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-money-bill-wave mr-3 text-yellow-500"></i>Dépenses divers
                                </a> -->
                            </div>
                        </div>
                    </div>

                    <!-- Ventes -->
                    <a href="{{ route('commande.liste.vente') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('commande.liste.vente') ? 'nav-active' : '' }}">
                        <i class="fas fa-cart-plus text-sm"></i>
                        <span>Ventes</span>
                    </a>

                    <!-- Achats -->
                    <a href="{{ route('achat.commande') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('achat.commande') ? 'nav-active' : '' }}">
                        <i class="fas fa-shopping-cart text-sm"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs -->
                    <div class="dropdown-group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('client.liste') || request()->routeIs('fournisseur.liste') ? 'nav-active' : '' }}">
                            <i class="fas fa-users text-sm"></i>
                            <span>Clients & Fournisseurs</span>
                            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                        </button>
                        <div class="dropdown-content absolute left-0 mt-2 w-56 z-50">
                            <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                                <a href="{{ route('client.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('client.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-users mr-3 text-blue-500"></i>Clients
                                </a>
                                <a href="{{ route('fournisseur.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 transition-colors {{ request()->routeIs('fournisseur.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-truck mr-3 text-green-500"></i>Fournisseurs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stock -->
                    <a href="{{ route('stock.liste') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('stock.liste') ? 'nav-active' : '' }}">
                        <i class="fas fa-boxes text-sm"></i>
                        <span>Stock</span>
                    </a>

                    <!-- Paramètres -->
                    <a href="{{ route('parametre') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('parametre') ? 'nav-active' : '' }}">
                        <i class="fas fa-cog text-sm"></i>
                        <span>Paramètres</span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="dropdown-group">
                    <button class="nav-item flex items-center space-x-2">
                        <i class="fas fa-user-circle text-sm"></i>
                        <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-content absolute right-0 mt-2 w-48 z-50">
                        <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-red-50 text-gray-700 transition-colors flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-white p-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-800 p-4 mt-3 rounded-lg border border-gray-700">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('page.accueil') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('page.accueil') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage Mobile -->
                    <div class="mobile-dropdown-group">
                        <button class="mobile-dropdown-toggle flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors hover:bg-gray-700">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-cogs w-5 text-center"></i>
                                <span>Paramétrage</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content ml-6">
                            <a href="{{ route('article.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('article.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-glass-martini-alt w-5 text-center"></i>
                                <span>Boissons</span>
                            </a>
                            <a href="{{ route('categorie.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('categorie.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-tags w-5 text-center"></i>
                                <span>Catégories</span>
                            </a>
                            <a href="{{ route('depense') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('depense') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-money-bill-wave w-5 text-center"></i>
                                <span>Dépenses divers</span>
                            </a>
                        </div>
                    </div>

                    <!-- Ventes & Achats -->
                    <a href="{{ route('commande.liste.vente') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('commande.liste.vente') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cart-plus w-5 text-center"></i>
                        <span>Ventes</span>
                    </a>
                    <a href="{{ route('achat.commande') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('achat.commande') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs Mobile -->
                    <div class="mobile-dropdown-group">
                        <button class="mobile-dropdown-toggle flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors hover:bg-gray-700">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Clients & Fournisseurs</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content ml-6">
                            <a href="{{ route('client.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('client.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Clients</span>
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('fournisseur.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-truck w-5 text-center"></i>
                                <span>Fournisseurs</span>
                            </a>
                        </div>
                    </div>

                    <!-- Stock & Paramètres -->
                    <a href="{{ route('stock.liste') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('stock.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-boxes w-5 text-center"></i>
                        <span>Stock</span>
                    </a>
                    <a href="{{ route('parametre') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('parametre') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span>Paramètres</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="mx-auto px-4">
        <div class="rounded-xl shadow-lg p-6 text-sm border border-white/20">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-transparent py-6 mt-8">
        <div class="container mx-auto px-4 text-center">
            <div class="text-gray-600 text-sm">
                &copy; {{ now()->year }} Mon Site. Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <a href="#page-top" class="fixed bottom-6 right-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-3 rounded-full shadow-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-110">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialisation de Select2
            function initSelect2() {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: "Sélectionner...",
                    allowClear: true
                });
            }

            initSelect2();

            // Réinitialiser Select2 dans les modals
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('shown', function () {
                    $(this).find('.select2').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $(this),
                        width: '100%'
                    });
                });
            });

            // Toggle mobile menu
            $('#mobile-menu-button').on('click', function () {
                $('#mobile-menu').slideToggle(300);
                $(this).find('i').toggleClass('fa-bars fa-times');
            });

            // Gestion des sous-menus mobile
            $('.mobile-dropdown-toggle').on('click', function() {
                const dropdownGroup = $(this).closest('.mobile-dropdown-group');
                dropdownGroup.toggleClass('mobile-dropdown-open');
                $(this).find('.fa-chevron-down').toggleClass('rotate-180');
                
                // Fermer les autres sous-menus
                $('.mobile-dropdown-group').not(dropdownGroup).removeClass('mobile-dropdown-open');
                $('.mobile-dropdown-group').not(dropdownGroup).find('.fa-chevron-down').removeClass('rotate-180');
            });

            // Fermer le menu mobile en cliquant à l'extérieur
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#mobile-menu, #mobile-menu-button').length) {
                    if ($('#mobile-menu').is(':visible')) {
                        $('#mobile-menu').slideUp(300);
                        $('#mobile-menu-button').find('i').removeClass('fa-times').addClass('fa-bars');
                        $('.mobile-dropdown-group').removeClass('mobile-dropdown-open');
                        $('.mobile-dropdown-group').find('.fa-chevron-down').removeClass('rotate-180');
                    }
                }
            });

            // Amélioration : garder le sous-menu ouvert pendant le survol
            let dropdownTimeout;
            
            $('.dropdown-group').hover(
                function() {
                    clearTimeout(dropdownTimeout);
                    $(this).addClass('dropdown-open');
                },
                function() {
                    const $this = $(this);
                    dropdownTimeout = setTimeout(function() {
                        $this.removeClass('dropdown-open');
                    }, 300); // Délai de 300ms avant fermeture
                }
            );

            // Garder le sous-menu ouvert si la souris est dessus
            $('.dropdown-content').hover(
                function() {
                    clearTimeout(dropdownTimeout);
                },
                function() {
                    const $parent = $(this).closest('.dropdown-group');
                    dropdownTimeout = setTimeout(function() {
                        $parent.removeClass('dropdown-open');
                    }, 300);
                }
            );
        });
    </script>
</body>
</html>