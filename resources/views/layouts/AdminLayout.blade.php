<!DOCTYPE html>
<html lang="en">

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
            padding-top: 60px; /* Compensation for fixed navbar */
            background-color: #f8f9fa;
        }

        .select2-container {
            z-index: 1050 !important;
        }

        .select2-dropdown {
            z-index: 1051 !important;
        }
    </style>
</head>

<body id="page-top">
    <!-- Main Navigation -->
    <nav class="fixed top-0 left-0 w-full bg-gray-800 text-white shadow-md z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center">
                    <button id="mobile-menu-button" class="md:hidden text-white mr-3 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="{{ route('page.accueil') }}" class="text-xl font-bold">Mon Site</a>
                </div>

                <!-- Desktop Menu -->
                <div id="mainNavbar" class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>

                    <!-- User Space Dropdown -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-user mr-1"></i> Espace utilisateur
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-700 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('article.liste') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-600 my-1"></div>
                            <a href="{{ route('commande.liste.vente') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-cash-register mr-2"></i> Commandes ventes
                            </a>
                            <a href="{{ route('achat.commande') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-cash-register mr-2"></i> Commandes achats
                            </a>
                            <a href="{{ route('depense') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-cash-register mr-2"></i> Dépense divers
                            </a>
                            <a href="{{ route('vente.page') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-cash-register mr-2"></i> Ventes
                            </a>
                            <a href="{{ route('achat.page') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-shopping-cart mr-2"></i> Achats
                            </a>
                        </div>
                    </div>

                    <!-- Clients & Suppliers -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-users mr-1"></i> Clients & Fournisseurs
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-700 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('client.liste') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-users mr-2"></i> Clients
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" class="block px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-truck mr-2"></i> Fournisseurs
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-chart-bar mr-1"></i> Statistique des ventes
                    </a>
                    <a  class="hover:text-yellow-400 transition flex items-center" href="{{route('sortie.stat')}}">
                            <i class="fas fa-history"></i>
                            historique des sorties
                    </a>
                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-cog mr-1"></i> Paramètres
                    </a>
                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-boxes mr-1"></i> Stock
                    </a>
                </div>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }}
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block bg-gray-700 shadow-lg rounded-md mt-1 w-48 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-600 text-white">
                                <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-900 p-4 mt-3 rounded-md">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>

                    <div class="pl-2 border-l border-gray-600">
                        <p class="font-medium mb-1"><i class="fas fa-user mr-2"></i> Espace utilisateur</p>
                        <div class="flex flex-col space-y-2 ml-4">
                            <a href="{{ route('article.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-600 my-1"></div>
                            <a href="{{ route('commande.liste.vente') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Commandes ventes
                            </a>
                            <a href="{{ route('achat.commande') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Commandes achats
                            </a>
                            <a href="{{ route('depense') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Dépense divers
                            </a>
                            <a href="{{ route('vente.page') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-cash-register mr-2"></i> Ventes
                            </a>
                            <a href="{{ route('achat.page') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-shopping-cart mr-2"></i> Achats
                            </a>
                        </div>
                    </div>

                    <div class="pl-2 border-l border-gray-600">
                        <p class="font-medium mb-1"><i class="fas fa-users mr-2"></i> Clients & Fournisseurs</p>
                        <div class="flex flex-col space-y-2 ml-4">
                            <a href="{{ route('client.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-users mr-2"></i> Clients
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-truck mr-2"></i> Fournisseurs
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400 flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i> Statistique des ventes
                    </a>
                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400 flex items-center">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>
                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400 flex items-center">
                        <i class="fas fa-boxes mr-2"></i> Stock
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-5 text-sm">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 mt-6">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <div class="copyright">&copy; {{ now()->year }} Mon Site. Tous droits réservés.</div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <a href="#page-top" class="fixed bottom-4 right-4 bg-gray-600 text-white p-3 rounded-full shadow-lg hover:bg-gray-700 transition">
        <i class="fas fa-angle-up"></i>
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
                $('#mobile-menu').toggleClass('hidden');
            });
        });
    </script>
</body>

</html>