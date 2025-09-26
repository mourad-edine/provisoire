<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- Tailwind CSS -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&family=Bellota:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Cinzel:wght@400..900&family=Lobster&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 -->
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        body {
            font-family: 'Bellota', sans-serif;
            padding-top: 60px;
            background-color: #f8f9fa;
        }



        .select2-dropdown {
            z-index: 51 !important;
        }

        .select2-container--default .select2-selection--single {
            height: 46px;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
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
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
    </style>
</head>

<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav class="fixed top-0 left-0 w-full bg-gradient-to-r from-gray-900 to-gray-800 text-white shadowrounded-md z-50 border-b border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-md flex items-center justify-center">
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
                        class="nav-item flex items-center space-x-2 {{ request()->routeIs('page.accueil') ? 'nav-active' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage d'articles -->
                    <div class="relative group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('article.liste') || request()->routeIs('categorie.liste') || request()->routeIs('depense') ? 'nav-active' : '' }}">
                            <i class="fas fa-cogs text-sm"></i>
                            <span>Paramétrage</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div class="absolute hidden group-hover:block glass-effect shadow-xl rounded-md mt-1 w-56 z-50 border border-gray-200">
                            <a href="{{ route('article.liste') }}"
                                class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('article.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                <i class="fas fa-glass-martini-alt mr-3 text-blue-500"></i>Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}"
                                class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('categorie.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                <i class="fas fa-tags mr-3 text-green-500"></i>Catégories
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <a href="{{ route('depense') }}"
                                class="block px-4 py-3 hover:bg-blue-50 text-gray-700 transition-colors {{ request()->routeIs('depense') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                <i class="fas fa-money-bill-wave mr-3 text-yellow-500"></i>Dépenses divers
                            </a>
                        </div>
                    </div>

                    <!-- Ventes -->
                    <a href="{{ route('commande.liste.vente') }}"
                        class="nav-item flex items-center space-x-2 {{ request()->routeIs('commande.liste.vente') || request()->routeIs('vente.page')  ? 'nav-active' : '' }}">
                        <i class="fas fa-cart-plus text-sm"></i>
                        <span>Ventes</span>
                    </a>

                    <!-- Achats -->
                    <a href="{{ route('achat.commande') }}"
                        class="nav-item flex items-center space-x-2 {{ request()->routeIs('achat.commande') || request()->routeIs('achat.page')  ? 'nav-active' : '' }}">
                        <i class="fas fa-shopping-cart text-sm"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs -->
                    <div class="relative group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('client.liste') || request()->routeIs('fournisseur.liste') ? 'nav-active' : '' }}">
                            <i class="fas fa-users text-sm"></i>
                            <span>Clients & Fournisseurs</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div class="absolute hidden group-hover:block glass-effect shadow-xl rounded-md mt-1 w-56 z-50 border border-gray-200">
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
                <div class="relative group">
                    <button class="nav-item flex items-center space-x-2">
                        <i class="fas fa-user-circle text-sm"></i>
                        <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block glass-effect shadow-xl rounded-md mt-1 w-48 z-50 border border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-red-50 text-gray-700 transition-colors flex items-center">
                                <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-white p-2 rounded-md hover:bg-gray-700 transition-colors">
                    <i class="fas fa-bars textrounded-md"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-800 p-4 mt-3 rounded-md border border-gray-700">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('page.accueil') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('page.accueil') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage Mobile -->
                    <div class="space-y-1">
                        <div class="px-3 py-2 text-gray-400 font-medium flex items-center space-x-3">
                            <i class="fas fa-cogs w-5 text-center"></i>
                            <span>Paramétrage</span>
                        </div>
                        <div class="ml-6 space-y-1">
                            <a href="{{ route('article.liste') }}"
                                class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('article.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-glass-martini-alt w-5 text-center"></i>
                                <span>Boissons</span>
                            </a>
                            <a href="{{ route('categorie.liste') }}"
                                class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('categorie.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-tags w-5 text-center"></i>
                                <span>Catégories</span>
                            </a>
                            <a href="{{ route('depense') }}"
                                class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('depense') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-money-bill-wave w-5 text-center"></i>
                                <span>Dépenses divers</span>
                            </a>
                        </div>
                    </div>

                    <!-- Ventes & Achats -->
                    <a href="{{ route('commande.liste.vente') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('commande.liste.vente') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cart-plus w-5 text-center"></i>
                        <span>Ventes</span>
                    </a>
                    <a href="{{ route('achat.commande') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('achat.commande') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs Mobile -->
                    <div class="space-y-1">
                        <div class="px-3 py-2 text-gray-400 font-medium flex items-center space-x-3">
                            <i class="fas fa-users w-5 text-center"></i>
                            <span>Clients & Fournisseurs</span>
                        </div>
                        <div class="ml-6 space-y-1">
                            <a href="{{ route('client.liste') }}"
                                class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('client.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Clients</span>
                            </a>
                            <a href="{{ route('fournisseur.liste') }}"
                                class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('fournisseur.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-truck w-5 text-center"></i>
                                <span>Fournisseurs</span>
                            </a>
                        </div>
                    </div>

                    <!-- Stock & Paramètres -->
                    <a href="{{ route('stock.liste') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('stock.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-boxes w-5 text-center"></i>
                        <span>Stock</span>
                    </a>
                    <a href="{{ route('parametre') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('parametre') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span>Paramètres</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-10 py-6">
        <div class="bg-white shadowrounded-md rounded-md overflow-hidden">
            <!-- Header -->
            <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
                <h5 class="textrounded-md font-semibold flex items-center text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a1 1 0 100 2 1 1 0 000-2zm-10 2H3" />
                    </svg>
                    Nouvel achat
                </h5>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>


            <!-- Messages d'erreur -->
            @if(session('error') || $errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex justify-between items-center">
                <div>
                    <strong>Erreur!</strong> {{ session('error') ?? 'Veuillez remplir tous les champs requis.' }}
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Formulaire -->
            <form id="achatForm" method="POST" action="{{ route('achat.store') }}">
                @csrf
                <div class="bg-white p-6 roundedrounded-md shadow-sm border-2 border-gray-300 max-w-7xl mx-auto my-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Numéro de commande -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Numéro de commande
                            </label>
                            <input type="text" name="numero" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date
                            </label>
                            <input type="date" name="dateachat" value="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <!-- Fournisseur -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Fournisseur
                            </label>
                            <select name="fournisseur_id" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors select2" required>
                                @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tableau articles -->
                <div class="overflow-x-auto mb-4">
                    <table class="w-full table-auto border border-gray-100 rounded-md bg-white">
                        <thead class="bg-gray-50 text-dark rounded-md">
                            <tr>
                                <th class="p-1 border border-gray-300">Article</th>
                                <th class="p-1 border border-gray-300">Quantité (Cageot/Pack)</th>
                                <th class="p-1 border border-gray-300">Quantité (Unité)</th>
                                <th class="p-1 border border-gray-300">Total (Ar)</th>
                                <th class="p-1 border border-gray-300">Prix unité (Ar)</th>
                                <th class="p-1 border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesContainer" class="divide-y divide-gray-400">
                            <tr class="article-row hover:bg-gray-50">
                                <td class="p-3 border border-gray-400">
                                    <select class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 select2 article-select" data-index="0">
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
                                </td>
                                <td class="p-3 border border-gray-400">
                                    <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantite-input" data-index="0" min="1">
                                </td>
                                <td class="p-3 border border-gray-400">
                                    <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantiteunite-input" data-index="0" min="1">
                                </td>
                                <td class="p-3 border border-gray-400">
                                    <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 bg-gray-100 total-input" data-index="0">
                                </td>
                                <td class="p-3 border border-gray-400">
                                    <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 bg-gray-100 prixunite-input" data-index="0" min="1" step="0.01" readonly>
                                </td>
                                <td class="p-3 text-center border border-gray-400">
                                    <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Ajouter article + Total -->
                <div class="flex justify-between items-center mb-4">
                    <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center" id="ajouterArticleBtn">
                        <i class="fas fa-plus mr-2"></i>Ajouter un article
                    </button>
                    <div class="textrounded-md font-bold text-green-600">
                        <span id="grandTotal">0</span> Ar
                    </div>
                </div>

                <!-- Bouton valider -->
                <div class="flex justify-end px-4 mb-4">
                    <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center" id="validerCommande">
                        <i class="fas fa-check-circle mr-2"></i>Valider la commande
                    </button>
                </div>
                <div id="hiddenInputs"></div>
            </form>
        </div>

        <!-- Modal confirmation -->
        <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-md shadowrounded-md max-w-md w-full">
                <div class="bg-gray-800 text-white p-4 flex justify-between items-center -trounded-md">
                    <h5 class="textrounded-md font-bold flex items-center"><i class="fas fa-check-circle mr-2"></i>Confirmation de commande</h5>
                    <button onclick="closeModal('validationModal')" class="text-white hover:text-gray-200"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-4 text-center">
                    <i class="fas fa-question-circle text-4xl text-yellow-500 mb-4"></i>
                    <h5 class="textrounded-md font-bold mb-4">Voulez-vous valider cette commande ?</h5>
                    <div class="bg-gray-100 p-2 rounded-md flex justify-between items-center">
                        <span class="font-bold">Montant total:</span>
                        <div><span class="textrounded-md font-bold text-gray-800" id="modalTotal">0</span><span class="ml-2">Ar</span></div>
                    </div>
                </div>
                <div class="bg-gray-100 p-4 -brounded-md flex justify-end gap-2">
                    <button type="button" onclick="closeModal('validationModal')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <button type="button" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 flex items-center" id="confirmSubmit">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function toggleNavbar() {
            document.getElementById('mainNavbar').classList.toggle('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        $(document).ready(function() {
            $('.select2').select2();

            let articleIndex = 0;

            function calculatePricePerUnit(index) {
                const quantiteCageot = parseFloat($(`.quantite-input[data-index="${index}"]`).val()) || 0;
                const quantiteUnite = parseFloat($(`.quantiteunite-input[data-index="${index}"]`).val()) || 0;
                const total = parseFloat($(`.total-input[data-index="${index}"]`).val()) || 0;
                const selectedOption = $(`.article-select[data-index="${index}"] option:selected`);
                const conditionnement = parseFloat(selectedOption.data('condi')) || 1;

                let prixUnite = 0;
                if (quantiteCageot > 0) {
                    prixUnite = total / (quantiteCageot * conditionnement);
                } else if (quantiteUnite > 0) {
                    prixUnite = total / quantiteUnite;
                }

                if (prixUnite > 0) {
                    $(`.prixunite-input[data-index="${index}"]`).val(prixUnite.toFixed(2));
                } else {
                    $(`.prixunite-input[data-index="${index}"]`).val('');
                }

                updateGrandTotal();
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                $('.total-input').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });
                $('#grandTotal').text(grandTotal.toFixed(2));
                $('#modalTotal').text(grandTotal.toFixed(2));
            }

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

            $('#ajouterArticleBtn').click(function() {
                articleIndex++;
                const newRow = `
                        <tr class="article-row hover:bg-gray-100">
            <td class="p-3 border border-gray-400">
                <select class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 select2 article-select" data-index="${articleIndex}">
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
            </td>
            <td class="p-3 border border-gray-400">
                <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantite-input" data-index="${articleIndex}" min="1">
            </td>
            <td class="p-3 border border-gray-400">
                <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 quantiteunite-input" data-index="${articleIndex}" min="1">
            </td>
            <td class="p-3 border border-gray-400">
                <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 bg-gray-100 total-input" data-index="${articleIndex}">
            </td>
            <td class="p-3 border border-gray-400">
                <input type="number" class="w-full border border-gray-400 rounded-md px-3 py-2 bg-gray-100 prixunite-input" data-index="${articleIndex}" min="1" step="0.01" readonly>
            </td>
            <td class="p-3 text-center border border-gray-400">
                <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="${articleIndex}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
`;
                $('#articlesContainer').append(newRow);
                $(`.article-select[data-index="${articleIndex}"]`).select2();
                handleQuantiteExclusivity(articleIndex);
            });

            $(document).on('click', '.remove-article', function() {
                $(this).closest('.article-row').remove();
                updateGrandTotal();
            });

            $('#validerCommande').click(function() {
                let isValid = true;
                $('.article-row').each(function() {
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
                openModal('validationModal');
            });

            let isSubmitting = false;

            $('#confirmSubmit').click(function() {
                if (isSubmitting) return;
                isSubmitting = true;
                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement...';
                setTimeout(() => {
                    $('#achatForm').submit();
                }, 50);
            });

            function prepareHiddenInputs() {
                $('#hiddenInputs').empty();
                $('.article-row').each(function(index) {
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
                    <input type="hidden" name="numero_commande" value="${$('#numero_commande').val()}">
                `);
            }

            handleQuantiteExclusivity(0);
        });
    </script>
</body>

</html>