<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>
    @include('Layouts.Css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">
    <style>
        @font-face {
            font-family: 'Bellota';
            src: url("{{ asset('assets/css/fonts/Bellota-Light.ttf') }}") format('truetype');

        }

        body {
            font-family: "Bellota", system-ui;
        }

        .select2-container--default .select2-selection--single {
            height: 46px;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
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

<body class="bg-gray-50 font-semibold">
    <nav class="fixed top-0 left-0 w-full bg-gradient-to-r from-gray-900 to-gray-800 text-white shadow-lg z-50 border-b border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/' . $entreprise->logo) }}" alt="Logo">
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent">
                                                {{$entreprise->nom_site}}

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

    <div class=" mx-auto px-4 py-6 mt-12">
        <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8 bg-white shadow-lg overflow-hidden">
            <!-- Card Header -->

            <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
                <h5 class="textrounded-md font-semibold flex items-center text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a1 1 0 100 2 1 1 0 000-2zm-10 2H3" />
                    </svg>
                    Nouvelle vente
                </h5>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>

            <!-- Card Body -->
            <div class="py-6  ">
                @if(session('success'))
                <div class="max-w-7xl mx-auto mb-4 px-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Succès!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                                <title>Fermer</title>
                                <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 11-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 111.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 111.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 010 1.698z" />
                            </svg>
                        </span>
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div class="max-w-7xl mx-auto mb-4 px-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Erreur!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                                <title>Fermer</title>
                                <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 11-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 111.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 111.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 010 1.698z" />
                            </svg>
                        </span>
                    </div>
                </div>
                @endif
                <form id="venteForm" action="{{ route('vente.store') }}" method="POST" onsubmit="disableSubmitButton(this)">
                    @csrf

                    <!-- Section Client -->
                    <div class="bg-white p-6 rounded-lg shadow-md max-w-7xl mx-auto border-2 border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end ">
                            <!-- Client existant -->
                            <div class="md:col-span-3">
                                <label for="client_id" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Client existant
                                </label>
                                <select class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors searchable-select" id="client_id" name="client_id" required>
                                    <option value="">Sélectionner un client</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nouveau client -->
                            <div class="md:col-span-3 flex items-end gap-2">
                                <div class="flex-1">
                                    <label for="nouveau_client" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                        <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Nouveau client
                                    </label>
                                    <input type="text" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" name="nouveau" id="nouveau_client" disabled>
                                </div>
                                <button type="button" id="toggle_nouveau_client" class="h-10 w-10 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="Créer un nouveau client">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Date -->
                            <div class="md:col-span-2">
                                <label for="date_vente" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Date
                                </label>
                                <input type="text" class="w-full border border-gray-200 rounded-md px-3 py-2 bg-gray-50 cursor-not-allowed" id="date_vente" value="{{ now()->format('d/m/Y') }}" readonly>
                            </div>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="total_non_consignee" id="total_non_consignee">
                            <input type="hidden" name="tot_glob" id="tot_glob">

                            <!-- Numéro de commande -->
                            <div class="md:col-span-2">
                                <label for="numero_commande" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    N° Commande
                                </label>
                                <input type="text" class="w-full border border-gray-200 rounded-md px-3 py-2 bg-gray-50 cursor-not-allowed" id="numero_commande" value="C-{{ str_pad(($dernier->id ?? 0) + 1, 5, '0', STR_PAD_LEFT) }}" readonly>
                            </div>

                            <!-- Type -->
                            <div class="md:col-span-2">
                                <label for="type_vente" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <svg fill="#000000" class="w-5 h-5 mr-1 text-gray-500" viewBox="0 0 512 512" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M478,256,302,432l-21.21-21.2L420.6,271H34V241H420.6L280.75,101.16,302,80Z" />
                                    </svg> Type
                                </label>
                                <select class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" id="type_vente" name="cat">
                                    <option value="gros">Détail</option>
                                    <option value="detail">Gros</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <!-- Section Articles - Tableau amélioré -->
                    <div id="articles-container" class="border border-gray-300 overflow-hidden shadow-md my-5">
                        <!-- En-tête du tableau avec bordures -->
                        <div class="grid grid-cols-12 gap-0 bg-gray-100 border-b border-gray-300 font-medium  text-dark rounded-md">
                            <div class="col-span-2 p-1 border-r border-gray-300">Article</div>
                            <div class="col-span-1 p-1 border-r border-gray-300 text-center">prix unitaire</div>
                            <div class="col-span-2 p-1 border-r border-gray-300 text-center">Prix cageot</div>
                            <div class="col-span-2 p-1 border-r border-gray-300 text-center">stock</div>
                            <!-- <div class="col-span-1 p-1 border-r border-gray-300 text-center">Qt.BTL</div> -->
                            <div class="col-span-1 p-1 border-r border-gray-300 text-center">Cageot/pack</div>
                            <div class="col-span-1 p-1 border-r border-gray-300 text-center">Unité</div>
                            <div class="col-span-1 p-1 border-r border-gray-300 text-center">Options</div>
                            <div class="col-span-2 p-1 text-center">Total</div>
                        </div>

                        <!-- Premier article avec bordures -->
                        <div class="article-section border-b border-gray-200 last:border-b-0" data-index="0">
                            <div class="grid grid-cols-12 gap-0 items-center">
                                <!-- Article -->
                                <div class="col-span-2 p-3 border-r border-gray-200">
                                    <select class="w-full border border-gray-300  px-2 py-1 searchable-select article-select" name="articles[0][id]" required>
                                        <option value="">Sélectionner un article</option>
                                        @foreach($articles as $article)
                                        <option value="{{ $article->id }}"
                                            data-prix="{{ $article->prix_unitaire }}"
                                            data-consignation="{{ $article->prix_consignation }}"
                                            data-cgt="{{ $article->prix_cgt }}"
                                            data-conditionnement="{{ $article->conditionnement }}"
                                            data-quantite="{{ $article->quantite }}"
                                            data-prix_conditionne="{{ $article->prix_conditionne }}"
                                            data-type_btl="{{ $article->type_btl }}" data-prix_gros="{{ $article->prix_gros }}">
                                            {{ $article->nom }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Prix unitaire -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300  px-2 py-1 bg-gray-100 text-center" name="articles[0][prix_unitaire]" readonly>
                                </div>

                                <!-- Prix CGT -->
                                <div class="col-span-2 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300  px-2 py-1 bg-gray-100 text-center" name="articles[0][prix_cgt]" readonly>
                                </div>

                                <!-- Stock cageots -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <div class="flex items-center border border-gray-300 bg-gray-100 rounded">
                                        <input type="number" class="w-full px-2 py-1 bg-transparent text-center border-none focus:outline-none" name="articles[0][stock_cageots]" readonly>
                                        <span class="px-2 py-1 bg-gray-200 text-gray-600 text-sm border-l border-gray-300">P</span>
                                    </div>
                                </div>

                                <!-- Stock unités -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <div class="flex items-center border border-gray-300 bg-gray-100 rounded">
                                        <input type="number" class="w-full px-2 py-1 bg-transparent text-center border-none focus:outline-none" name="articles[0][stock_unites]" readonly>
                                        <span class="px-2 py-1 bg-gray-200 text-gray-600 text-sm border-l border-gray-300">U</span>
                                    </div>
                                </div>

                                <!-- Quantité cageot -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300  px-2 py-1 text-center" name="articles[0][quantite_cageot]" min="0">
                                </div>

                                <!-- Quantité unité -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300  px-2 py-1 text-center" name="articles[0][quantite_unite]" min="0">
                                </div>

                                <!-- Options -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <div class="flex flex-col space-y-1 items-start">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="articles[0][avec_cageot]" checked>
                                            <span class="ml-2 text-sm whitespace-nowrap">Cageot</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="articles[0][avec_bouteille]" checked>
                                            <span class="ml-2 text-sm whitespace-nowrap">Bouteille</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Prix total -->
                                <div class="col-span-2 p-3 text-center bg-white rounded-lg border border-gray-200 flex justify-between items-stretch h-16">
                                    <div class="flex flex-col justify-center items-start flex-grow">
                                        <div class="font-bold total-price text-gray-900 ml-3" data-index="0">0 Ar</div>
                                        <div class="text-xs text-gray-500 price-details" data-index="0"></div>
                                    </div>

                                    <div class="flex items-stretch ml-3">
                                        <button type="button" class="delete-article bg-red-400 hover:bg-red-600 text-white w-8 h-8 flex items-center justify-center rounded-r transition-colors duration-200">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter article -->
                    <div class="mb-6 mt-4">
                        <button type="button" id="add-article" class="rounded-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter un article
                        </button>
                    </div>

                    <hr class="my-6">

                    <!-- Total général -->
                    <div class="flex justify-end mb-6">
                        <div class="w-full md:w-1/3">
                            <div class="flex justify-between items-center text-lg font-semibold border-t border-gray-300 pt-4">
                                <span>Total général:</span>
                                <span id="global-total">0 Ar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="flex justify-end">
                        <button type="button" class="bg-blue-600 rounded-sm hover:bg-blue-700 text-white px-6 py-2 flex items-center text-lg" id="final2">
                            <i class="fas fa-check-circle mr-2"></i> Valider la vente
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                        <div class="modal-dialog relative top-20 mx-auto p-2 w-full max-w-2xl">
                            <div class="bg-white -xl shadow-2xl border border-gray-200 overflow-hidden">
                                <!-- En-tête du modal -->
                                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 flex justify-between items-center">
                                    <h5 class="modal-title font-semibold text-white text-lg flex items-center">
                                        <i class="fas fa-cogs mr-3 text-blue-400"></i>Configuration de la commande
                                    </h5>
                                    <button type="button" class="close text-white text-xl hover:text-gray-300 transition-colors" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <!-- Corps du modal -->
                                <div class="p-6">
                                    <!-- Section Résumé compacte -->
                                    <!-- Section Résumé compacte -->
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-blue-700 mb-1">Total cageot</p>
                                                    <span class="text-2xl font-bold text-blue-900" id="total-unites">0</span>
                                                </div>
                                                <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-box text-blue-600"></i>
                                                </div>
                                            </div>
                                            <!-- Détail des cageots par type -->

                                        </div>

                                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-green-700 mb-1">Montant final</p>
                                                    <span class="text-2xl font-bold text-green-900" id="global-total-modal">0 Ar</span>
                                                </div>
                                                <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-receipt text-green-600"></i>
                                                </div>
                                            </div>
                                            <div id="empty-cageots-supplement" class="text-right text-xs mt-1 hidden">
                                                <span class="text-gray-600">dont cageots: </span>
                                                <span class="text-yellow-600 font-semibold">0 Ar</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section Options compacte -->
                                    <div class="space-y-4">
                                        <!-- Option Cageots vides -->
                                        <div class="border border-gray-200 -lg p-4 bg-white">
                                            <div class="flex items-center justify-between mb-3">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 " id="choix" name="choix">
                                                    <span class="ml-3 font-medium text-gray-700">Ajouter des cageots vides</span>
                                                </label>
                                            </div>
                                            <div id="choix_content" class="pl-7 mt-2 hidden">
    <div class="flex justify-between items-center gap-4 flex-wrap">
        <!-- Cageot 24 -->
        <!-- Dans la section des cageots vides -->
        @foreach($cageots as $cageot)
        <div class="flex flex-col items-start gap-1">
            <label for="{{$cageot->nom_emballage}}" class="text-gray-600">Stock {{$cageot->quantite}}</label>
            <div class="flex border border-gray-300 overflow-hidden">
                <input type="number" class="w-20 px-3 py-2 border-0 focus:ring-0" name="{{$cageot->nom_emballage}}" id="{{$cageot->nom_emballage}}" placeholder="Nombre" min="0" max="{{$cageot->quantite}}">
                <span class="bg-gray-100 px-3 py-2 text-gray-600 border-l border-gray-300">x {{$cageot->type_cageot}}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
                                        </div>

                                        <!-- Options de paiement en ligne -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="border border-gray-200 -lg p-3 bg-white">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 " id="fidele" name="fidele">
                                                    <span class="ml-3 text-sm font-medium text-gray-700">Mode non consigné</span>
                                                </label>
                                                <p class="text-xs text-gray-500 mt-1">Bouteilles + Cageots</p>
                                            </div>

                                            <div class="border border-gray-200 -lg p-3 bg-white">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" class="h-4 w-4 text-blue-600 " id="payer" name="payer" checked>
                                                    <span class="ml-3 text-sm font-medium text-gray-700">Paiement immédiat</span>
                                                </label>
                                            </div>

                                            <div class="border border-gray-200 -lg p-3 bg-white">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" class="h-4 w-4 text-yellow-600 " id="disposition" name="disposition">
                                                    <span class="ml-3 text-sm font-medium text-gray-700">À disposition</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Champs de paiement -->
                                        <div id="paiement-fields" class="border border-gray-200 -lg p-4 bg-gray-50">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="montant-recu" class="block text-sm font-medium text-gray-700 mb-2">Montant reçu (Ar)</label>
                                                    <input type="number" class="w-full border border-gray-300 -lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="montant-recu" name="montant_recu" placeholder="0">
                                                </div>
                                                <div>
                                                    <label for="montant-rendu" class="block text-sm font-medium text-gray-700 mb-2">Montant à rendre (Ar)</label>
                                                    <input type="number" class="w-full border border-gray-300 -lg px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-gray-500 focus:border-transparent" id="montant-rendu" name="montant_rendu" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pied de page du modal -->
                                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                                    <button type="button" class="px-5 py-2 border border-gray-300 text-gray-700 -lg hover:bg-gray-100 transition-colors duration-200 flex items-center font-medium" data-dismiss="modal">
                                        <i class="fas fa-times mr-2"></i> Annuler
                                    </button>
                                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white -lg hover:from-green-700 hover:to-green-800 transition-all duration-200 flex items-center font-medium shadow-lg hover:shadow-xl" id="confirm-btn">
                                        <i class="fas fa-check-circle mr-2"></i> Confirmer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Template pour les nouveaux articles avec bordures -->
    <template id="article-template">
        <div class="article-section border-b border-gray-200 last:border-b-0" data-index="{index}">
            <div class="grid grid-cols-12 gap-0 items-center">
                <!-- Article -->
                <div class="col-span-2 p-3 border-r border-gray-200">
                    <select class="w-full border border-gray-300  px-2 py-1 searchable-select article-select" name="articles[{index}][id]" required>
                        <option value="">Sélectionner un article</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}"
                            data-prix="{{ $article->prix_unitaire }}"
                            data-consignation="{{ $article->prix_consignation }}"
                            data-cgt="{{ $article->prix_cgt }}"
                            data-conditionnement="{{ $article->conditionnement }}"
                            data-quantite="{{ $article->quantite }}"
                            data-prix_gros="{{ $article->prix_gros }}"
                            data-prix_conditionne="{{ $article->prix_conditionne }}"
                            data-type_btl="{{ $article->type_btl }}" data-prix_gros="{{ $article->prix_gros }}">

                            {{ $article->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix unitaire -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300  px-2 py-1 bg-gray-100 text-center" name="articles[{index}][prix_unitaire]" readonly>
                </div>

                <!-- Prix CGT -->
                <div class="col-span-2 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300  px-2 py-1 bg-gray-100 text-center" name="articles[{index}][prix_cgt]" readonly>
                </div>

                <!-- Stock cageots -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <div class="flex items-center border border-gray-300 bg-gray-100 rounded">
                        <input type="number" class="w-full px-2 py-1 bg-transparent text-center border-none focus:outline-none" name="articles[{index}][stock_cageots]" readonly>
                        <span class="px-2 py-1 bg-gray-200 text-gray-600 text-sm border-l border-gray-300">P</span>
                    </div>
                </div>

                <!-- Stock unités -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <div class="flex items-center border border-gray-300 bg-gray-100 rounded">
                        <input type="number" class="w-full px-2 py-1 bg-transparent text-center border-none focus:outline-none" name="articles[{index}][stock_unites]" readonly>
                        <span class="px-2 py-1 bg-gray-200 text-gray-600 text-sm border-l border-gray-300">U</span>
                    </div>
                </div>

                <!-- Quantité cageot -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300  px-2 py-1 text-center" name="articles[{index}][quantite_cageot]" min="0">
                </div>

                <!-- Quantité unité -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300  px-2 py-1 text-center" name="articles[{index}][quantite_unite]" min="0">
                </div>

                <!-- Options -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <div class="flex flex-col space-y-2 items-start">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="articles[{index}][avec_cageot]" id="avec_cageot_{index}" checked>
                            <span class="ml-2 text-sm whitespace-nowrap">Cageot</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="articles[{index}][avec_bouteille]" id="avec_bouteille_{index}" checked>
                            <span class="ml-2 text-sm whitespace-nowrap">Bouteille</span>
                        </label>
                    </div>
                </div>

                <!-- Prix total + bouton supprimer -->
                <div class="col-span-2 p-3 text-center bg-white rounded-lg border border-gray-200 flex justify-between items-stretch h-16">
                    <div class="flex flex-col justify-center items-start flex-grow">
                        <div class="font-bold total-price text-gray-900 ml-3" data-index="{index}">0 Ar</div>
                        <div class="text-xs text-gray-500 price-details ml-3" data-index="{index}"></div>
                    </div>

                    <div class="flex items-stretch ml-3">
                        <button type="button" class="delete-article bg-red-400 hover:bg-red-600 text-white w-8 h-8 flex items-center justify-center rounded-r transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <script>
    function disableSubmitButton(form) {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Confirmer la configuration';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Select2 for searchable selects
        $('.searchable-select').select2();

        // Variables globales
        let articleIndex = 1;
        let emptyCageotsPrice = 0;

        // Bootstrap 5 Modal handling
        const venteModal = document.getElementById('venteModal2');
        const venteModalInstance = new bootstrap.Modal(venteModal);

        // Function to format numbers with thousand separators
        function formatNumber(number) {
            return Math.floor(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Toggle new client input
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
                toggleBtn.classList.remove("bg-blue-600", "hover:bg-blue-700");
                toggleBtn.classList.add("bg-green-600", "hover:bg-green-700");
            } else {
                nouveauInput.value = "";
                nouveauInput.disabled = true;
                clientSelect.disabled = false;
                toggleBtn.classList.remove("bg-green-600", "hover:bg-green-700");
                toggleBtn.classList.add("bg-blue-600", "hover:bg-blue-700");
            }
        });

        // Show/hide payment fields based on 'payer' checkbox
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

        // Calculate change amount
        $(document).on('input', '#montant-recu', function() {
            const montantRecu = parseFloat($(this).val()) || 0;
            const total = parseFloat($('#tot_glob').val()) || 0;
            const montantRendu = montantRecu - total;
            $('#montant-rendu').val(montantRendu >= 0 ? montantRendu : '0');
        });

        // Prevent form submission if payment is required but amount is not entered
        $('#venteForm').submit(function(e) {
            return true;
        });

        // Handle type of sale change (gros/detail)
        $('#type_vente').on('change', function() {
            const type = $(this).val();
            $('.article-section').each(function() {
                const section = $(this);
                const selectedOption = section.find('.article-select option:selected');
                const prixDetail = parseInt(selectedOption.data('prix')) || 0;
                const prixGros = parseInt(selectedOption.data('prix_gros')) || 0;
                const prixFinal = (type === 'gros') ? prixGros : prixDetail;
                section.find('input[name$="[prix_unitaire]"]').val(prixFinal);
                calculateArticleTotal(section.data('index'));
            });
            calculateGlobalTotal();
        });

        // Fonction pour calculer le nombre de cageots par type
        function calculateCageotsByType() {
            let cageots24 = 0;
            let cageots20 = 0;
            let cageots12 = 0;

            $('.article-section').each(function() {
                const section = $(this);
                const selectedOption = section.find('.article-select option:selected');
                const typeBtl = parseInt(selectedOption.data('type_btl')) || 0;
                const quantiteCageot = parseInt(section.find('input[name$="[quantite_cageot]"]').val()) || 0;
                const avecCageot = section.find('input[name$="[avec_cageot]"]').is(':checked');

                // Incrémenter seulement si "avec cageot" est coché ET il y a des cageots
                if (avecCageot && quantiteCageot > 0) {
                    switch(typeBtl) {
                        case 30:
                        case 33:
                            cageots24 += quantiteCageot;
                            break;
                        case 50:
                        case 65:
                            cageots20 += quantiteCageot;
                            break;
                        case 100:
                            cageots12 += quantiteCageot;
                            break;
                        default:
                            // Type non reconnu, on ne compte pas
                            break;
                    }
                }
            });

            return {
                cageots24: cageots24,
                cageots20: cageots20,
                cageots12: cageots12,
                totalCageots: cageots24 + cageots20 + cageots12
            };
        }

        // Fonction pour synchroniser les cageots achetés avec les champs modifiables
        function syncCageotsFields() {
            const cageotsByType = calculateCageotsByType();

            // Mettre à jour les champs seulement s'ils ne sont pas en cours de modification
            if (!$('#cageot24').is(':focus') || $('#cageot24').val() === '') {
                $('#cageot24').val(cageotsByType.cageots24);
            }
            if (!$('#cageot20').is(':focus') || $('#cageot20').val() === '') {
                $('#cageot20').val(cageotsByType.cageots20);
            }
            if (!$('#cageot12').is(':focus') || $('#cageot12').val() === '') {
                $('#cageot12').val(cageotsByType.cageots12);
            }

            // Recalculer le total
            calculateGlobalTotal();
        }

        // Calculate total for an article
        function calculateArticleTotal(index) {
            const section = $(`.article-section[data-index="${index}"]`);
            const prixUnitaire = parseInt(section.find('input[name$="[prix_unitaire]"]').val()) || 0;
            const quantiteCageot = parseInt(section.find('input[name$="[quantite_cageot]"]').val()) || 0;
            const quantiteUnite = parseInt(section.find('input[name$="[quantite_unite]"]').val()) || 0;
            const selectedOption = section.find('.article-select option:selected');
            const prixConsignation = parseInt(selectedOption.data('consignation')) || 0;
            const prixCgt = parseInt(selectedOption.data('cgt')) || 0;
            const prixConditionne = parseInt(selectedOption.data('prix_conditionne')) || 0;
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;

            // Disable avec_cageot checkbox if quantite_cageot is 0
            const avecCageotCheckbox = section.find('input[name$="[avec_cageot]"]');
            if (quantiteCageot === 0 || prixCgt === 0) {
                avecCageotCheckbox.prop('checked', false).prop('disabled', true);
            } else {
                avecCageotCheckbox.prop('disabled', false);
            }

            // Uncheck options if price is 0
            if (prixConsignation === 0) {
                section.find('input[name$="[avec_bouteille]"]').prop('checked', false);
            }

            const avecCageot = prixCgt > 0 && quantiteCageot > 0 && avecCageotCheckbox.is(':checked');
            const avecBouteille = prixConsignation > 0 && section.find('input[name$="[avec_bouteille]"]').is(':checked');
            const totalUnites = (quantiteCageot * conditionnement) + quantiteUnite;

            // Calcul du prix de base (unités + cageots complets)
            let total = (quantiteUnite * prixUnitaire) + (quantiteCageot * prixConditionne);
            let totalSansConsigne = total;
            let details = [];

            // Ajout du prix des cageots si coché
            if (avecCageot && quantiteCageot > 0) {
                const suppCageot = quantiteCageot * prixCgt;
                total += suppCageot;
                details.push(`+ ${quantiteCageot} cageot: ${formatNumber(suppCageot)} Ar`);
            }

            // Ajout du prix des bouteilles si coché
            if (avecBouteille && totalUnites > 0) {
                const suppBouteille = totalUnites * prixConsignation;
                total += suppBouteille;
                details.push(`+ ${totalUnites} bouteille: ${formatNumber(suppBouteille)} Ar`);
            }

            $(`.total-price[data-index="${index}"]`).text(formatNumber(total) + ' Ar');
            $(`.price-details[data-index="${index}"]`).html(details.join('<br>'));

            return {
                totalAvecConsigne: total,
                totalSansConsigne: totalSansConsigne,
                prixCgt: prixCgt,
                totalUnites: totalUnites
            };
        }

        // Calculate global total
        function calculateGlobalTotal() {
            let globalTotal = 0;
            let globalNonConsigne = 0;
            let totalUnitesGlobal = 0;

            $('.article-section').each(function() {
                const index = $(this).data('index');
                const result = calculateArticleTotal(index);
                globalTotal += result.totalAvecConsigne;
                globalNonConsigne += result.totalSansConsigne;
                totalUnitesGlobal += result.totalUnites;
            });

            // Récupérer les valeurs des champs de cageots vides
            const emptyCageots24 = parseInt($('#cageot24').val()) || 0;
            const emptyCageots20 = parseInt($('#cageot20').val()) || 0;
            const emptyCageots12 = parseInt($('#cageot12').val()) || 0;

            // Tous les cageots ont le même prix (8000 Ar)
            const cageotPrice = 8000;
            emptyCageotsPrice = (emptyCageots24 + emptyCageots20 + emptyCageots12) * cageotPrice;
            const totalWithEmptyCageots = globalTotal + emptyCageotsPrice;

            // Mettre à jour l'affichage
            $('#global-total').text(formatNumber(totalWithEmptyCageots) + ' Ar');
            $('#total_non_consignee').val(globalNonConsigne);
            $('#tot_glob').val(totalWithEmptyCageots);
            $('#global-total-modal').text(formatNumber(totalWithEmptyCageots) + ' Ar');

            // Afficher le nombre total de cageots (achetés + modifiés)
            const totalCageots = emptyCageots24 + emptyCageots20 + emptyCageots12;
            $('#total-unites').text(totalCageots);

            // Afficher le détail des cageots (achetés + modifiés)
            $('#detail-cageots-24').text(emptyCageots24);
            $('#detail-cageots-20').text(emptyCageots20);
            $('#detail-cageots-12').text(emptyCageots12);

            // Gérer l'affichage des cageots supplémentaires
            if ($('#choix').is(':checked') && emptyCageotsPrice > 0) {
                $('#empty-cageots-supplement').show();
                $('#empty-cageots-supplement span').text(formatNumber(emptyCageotsPrice) + ' Ar');
            } else {
                $('#empty-cageots-supplement').hide();
            }

            // Recalculer la monnaie si nécessaire
            if ($('#payer').is(':checked') && $('#montant-recu').val()) {
                $('#montant-recu').trigger('input');
            }
        }

        // Update stock display
        function updateStockDisplay(section) {
            const selectedOption = section.find('.article-select option:selected');
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
            const stockTotal = parseInt(selectedOption.data('quantite')) || 0;
            const cageots = Math.floor(stockTotal / conditionnement);
            const unites = stockTotal % conditionnement;

            section.find('input[name$="[stock_cageots]"]').val(cageots);
            section.find('input[name$="[stock_unites]"]').val(unites);
        }

        // Écouter les modifications des quantités d'articles
        $(document).on('change input', 'input[name$="[quantite_cageot]"], input[name$="[quantite_unite]"], input[name$="[avec_cageot]"], input[name$="[avec_bouteille]"]', function() {
            const parentSection = $(this).closest('.article-section');
            const selectedOption = parentSection.find('.article-select option:selected');
            const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
            const stockTotal = parseInt(selectedOption.data('quantite')) || 0;
            const quantiteCageot = parseInt(parentSection.find('input[name$="[quantite_cageot]"]').val()) || 0;
            const quantiteUnite = parseInt(parentSection.find('input[name$="[quantite_unite]"]').val()) || 0;
            const prixCgt = parseInt(selectedOption.data('cgt')) || 0;
            const totalDemande = (quantiteCageot * conditionnement) + quantiteUnite;

            // Disable/enable avec_cageot based on quantite_cageot
            if (quantiteCageot === 0 || prixCgt === 0) {
                parentSection.find('input[name$="[avec_cageot]"]').prop('checked', false).prop('disabled', true);
            } else {
                parentSection.find('input[name$="[avec_cageot]"]').prop('disabled', false);
            }

            // Vérifier le stock
            if (totalDemande > stockTotal) {
                alert('La quantité demandée dépasse le stock disponible!');
                parentSection.find('input[name$="[quantite_cageot]"]').val('');
                parentSection.find('input[name$="[quantite_unite]"]').val('');
                parentSection.find('input[name$="[avec_cageot]"]').prop('checked', false).prop('disabled', true);
            }

            syncCageotsFields();
        });

        // Écouter les modifications manuelles des champs de cageots vides
        $(document).on('input', '#cageot24, #cageot20, #cageot12', function() {
            calculateGlobalTotal();
        });

        // Écouter la sélection d'article
        $(document).on('change', '.article-select', function() {
            const parentSection = $(this).closest('.article-section');
            const selectedOption = $(this).find('option:selected');
            const type = $('#type_vente').val();
            const prixDetail = parseInt(selectedOption.data('prix')) || 0;
            const prixGros = parseInt(selectedOption.data('prix_gros')) || 0;
            const prixUnitaire = (type === 'gros') ? prixGros : prixDetail;
            const prixCgt = parseInt(selectedOption.data('cgt')) || 0;
            const prixConsignation = parseInt(selectedOption.data('consignation')) || 0;
            const prixConditionne = parseInt(selectedOption.data('prix_conditionne')) || 0;

            parentSection.find('input[name$="[prix_unitaire]"]').val(prixUnitaire);
            parentSection.find('input[name$="[prix_cgt]"]').val(prixConditionne);

            // Disable avec_cageot if quantite_cageot is 0 or prixCgt is 0
            const quantiteCageot = parseInt(parentSection.find('input[name$="[quantite_cageot]"]').val()) || 0;
            if (quantiteCageot === 0 || prixCgt === 0) {
                parentSection.find('input[name$="[avec_cageot]"]').prop('checked', false).prop('disabled', true);
            } else {
                parentSection.find('input[name$="[avec_cageot]"]').prop('disabled', false);
            }

            if (prixConsignation === 0) {
                parentSection.find('input[name$="[avec_bouteille]"]').prop('checked', false);
            }

            updateStockDisplay(parentSection);
            syncCageotsFields();
        });

        // Show modal and calculate totals
        $('#final2').on('click', function() {
            syncCageotsFields();
            venteModalInstance.show();
        });

        // Close modal
        venteModal.querySelector('[data-dismiss="modal"]').addEventListener('click', function() {
            venteModalInstance.hide();
        });

        // Handle empty cageots option
        $(document).on('change', '#choix', function() {
            if ($(this).is(':checked')) {
                $('#choix_content').show();
                // Réinitialiser les champs avec les cageots achetés
                syncCageotsFields();
            } else {
                $('#choix_content').hide();
                $('#cageot24').val('0');
                $('#cageot20').val('0');
                $('#cageot12').val('0');
                calculateGlobalTotal();
            }
        });

        // Add new article
        $('#add-article').click(function() {
            const template = $('#article-template').html();
            const newArticle = template.replace(/{index}/g, articleIndex);
            $('#articles-container').append(newArticle);
            $('#articles-container .article-select').last().select2();
            articleIndex++;
        });

        // Remove article
        $(document).on('click', '.delete-article', function() {
            const section = $(this).closest('.article-section');
            section.remove();

            // Réindexer les lignes pour garder une cohérence des data-index
            $('.article-section').each(function(i) {
                $(this).attr('data-index', i);
                $(this).find('[data-index]').attr('data-index', i);
            });

            // Recalculer après suppression
            syncCageotsFields();
        });

        // Form validation
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

        // Handle checkbox exclusivity
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

        // Initialisation
        syncCageotsFields();
    });
</script>
</body>
</html>