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
            padding-top: 60px;
            background-color: #f8f9fa;
        }

        .select2-container {
            z-index: 50 !important;
        }

        .select2-dropdown {
            z-index: 51 !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav style="z-index: 60;" class="fixed top-0 left-0 w-full bg-gray-800 text-white shadow-md py-3">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button class="md:hidden text-white mr-3" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="{{ route('page.accueil') }}" class="text-xl font-bold">Mon Site</a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>

                    <!-- User Space Dropdown -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-user mr-1"></i> Espace utilisateur <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('article.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-700 my-1"></div>
                            <a href="{{ route('commande.liste.vente') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Commandes ventes
                            </a>
                            <a href="{{ route('achat.commande') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Commandes achats
                            </a>
                            <a href="{{ route('depense') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Dépense divers
                            </a>
                            <a href="{{ route('vente.page') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-cash-register mr-2"></i> Ventes
                            </a>
                            <a href="{{ route('achat.page') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-shopping-cart mr-2"></i> Achats
                            </a>
                        </div>
                    </div>

                    <!-- Clients & Suppliers -->
                    <div class="relative group">
                        <button class="hover:text-yellow-400 transition flex items-center">
                            <i class="fas fa-users mr-1"></i> Clients & Fournisseurs <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                            <a href="{{ route('client.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-users mr-2"></i> Clients
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" class="block px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-truck mr-2"></i> Fournisseurs
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-chart-bar mr-1"></i> Statistique des ventes
                    </a>

                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-cog mr-1"></i> Paramètres
                    </a>

                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-boxes mr-1"></i> Stock
                    </a>
                </div>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="hover:text-yellow-400 transition flex items-center">
                        <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute right-0 hidden group-hover:block bg-gray-800 shadow-lg rounded-md mt-1 w-48 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu (hidden by default) -->
            <div class="hidden md:hidden mt-4" id="mobile-menu">
                <div class="flex flex-col space-y-3 pb-3">
                    <a href="{{ route('page.accueil') }}" class="hover:text-yellow-400 transition">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>

                    <div class="pl-2 border-l border-gray-700 ml-2">
                        <p class="font-medium mb-1"><i class="fas fa-user mr-2"></i> Espace utilisateur</p>
                        <div class="flex flex-col space-y-2 ml-4">
                            <a href="{{ route('article.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-glass-martini-alt mr-2"></i> Boissons
                            </a>
                            <a href="{{ route('categorie.liste') }}" class="text-sm hover:text-yellow-400">
                                <i class="fas fa-tags mr-2"></i> Catégories
                            </a>
                            <div class="border-t border-gray-700 my-1"></div>
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

                    <div class="pl-2 border-l border-gray-700 ml-2">
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

                    <a href="{{ route('stat') }}" class="hover:text-yellow-400">
                        <i class="fas fa-chart-bar mr-2"></i> Statistique des ventes
                    </a>

                    <a href="{{ route('parametre') }}" class="hover:text-yellow-400">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>

                    <a href="{{ route('stock.liste') }}" class="hover:text-yellow-400">
                        <i class="fas fa-boxes mr-2"></i> Stock
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-40 py-6">
        <div class="bg-white shadow-md overflow-hidden">
            <div class="bg-gray-700 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold"><i class="fas fa-cash-register mr-2"></i> Nouvelle vente</h2>
                <a href="{{ url()->previous() }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Retour
                </a>
            </div>

            <div class="p-6">
                <form id="venteForm" action="{{ route('vente.store') }}" method="POST" onsubmit="disableSubmitButton(this)">
                    @csrf

                    <!-- Client Section -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
                        <div class="md:col-span-3">
                            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Client existant</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 searchable-select"
                                id="client_id" name="client_id" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="nouveau_client" class="block text-sm font-medium text-gray-700 mb-1">Nouveau client</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100"
                                name="nouveau" id="nouveau_client" disabled>
                        </div>

                        <div class="md:col-span-1 flex items-end">
                            <button type="button" id="toggle_nouveau_client" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md"
                                title="Créer un nouveau client">
                                <span class="text-white font-bold">+</span>
                            </button>
                        </div>

                        <div class="md:col-span-2">
                            <label for="date_vente" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100"
                                id="date_vente" value="{{ now()->format('d/m/Y') }}" readonly>
                        </div>

                        <input type="hidden" name="total_non_consignee" id="total_non_consignee">
                        <input type="hidden" name="tot_glob" id="tot_glob">

                        <div class="md:col-span-2">
                            <label for="numero_commande" class="block text-sm font-medium text-gray-700 mb-1">N° Commande</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100"
                                id="numero_commande" value="C-{{ str_pad(($dernier->id ?? 0) + 1, 5, '0', STR_PAD_LEFT) }}" readonly>
                        </div>

                        <div class="md:col-span-2">
                            <label for="type_vente" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                id="type_vente" name="cat">
                                <option value="gros">Gros</option>
                                <option value="detail">Détail</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- Articles Section as Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Article</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">P.U</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">P.cgt</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Qt.CGT/Pack</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Qt.BTL</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Cageot/pack</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Unité</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Options</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Total</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody id="articles-container" class="bg-white divide-y divide-gray-200">
                                <!-- First article row -->
                                <tr class="article-row" data-index="0">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded shadow-sm article-select searchable-select"
                                            name="articles[0][id]" required>
                                            <option value="">Sélectionner un article</option>
                                            @foreach($articles as $article)
                                            <option value="{{ $article->id }}"
                                                data-prix="{{ $article->prix_unitaire }}"
                                                data-consignation="{{ $article->prix_consignation }}"
                                                data-cgt="{{ $article->prix_cgt }}"
                                                data-conditionnement="{{ $article->conditionnement }}"
                                                data-quantite="{{ $article->quantite }}"
                                                data-prix_conditionne="{{ $article->prix_conditionne }}"
                                                data-prix_gros="{{ $article->prix_gros }}">
                                                {{ $article->nom }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 prix-unitaire"
                                            name="articles[0][prix_unitaire]" readonly>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 prix-cgt"
                                            name="articles[0][prix_cgt]" readonly>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 stock-cageots"
                                            name="articles[0][stock_cageots]" readonly>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 stock-unites"
                                            name="articles[0][stock_unites]" readonly>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded quantite-cageot"
                                            name="articles[0][quantite_cageot]" min="0">
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded quantite-unite"
                                            name="articles[0][quantite_unite]" min="0">
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 avec-cageot"
                                                    name="articles[0][avec_cageot]" id="avec_cageot_0" checked>
                                                <span class="ml-2 text-sm">Cageot</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 avec-bouteille"
                                                    name="articles[0][avec_bouteille]" id="avec_bouteille_0" checked>
                                                <span class="ml-2 text-sm">Bouteille</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap text-right">
                                        <div class="total-price font-bold" data-index="0">0.00 Ar</div>
                                        <div class="price-details text-xs text-gray-500" data-index="0"></div>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <!-- No delete button for first row -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-6">
                        <button type="button" id="add-article" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-plus mr-2"></i> Ajouter un article
                        </button>
                    </div>

                    <hr class="my-6">

                    <!-- Global Total -->
                    <div class="flex justify-end mb-6">
                        <div class="w-full md:w-1/3">
                            <div class="flex justify-between items-center border-t-2 border-gray-300 pt-4">
                                <h5 class="text-lg font-bold">Total général:</h5>
                                <h5 id="global-total" class="text-lg font-bold text-green-600">0.00 Ar</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="button" id="final2" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md font-medium">
                            <i class="fas fa-check-circle mr-2"></i> Valider la vente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Template -->
    <div id="vente-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden pt-10">
        <div class="relative top-5 mx-auto p-4 border w-full max-w-2xl shadow-lg rounded-md bg-white modal-container">
            <!-- Header -->
            <div class="bg-gray-800 text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                <h3 class="text-lg font-bold">
                    <i class="fas fa-cogs mr-2"></i>Configuration commande
                </h3>
                <button type="button" class="text-white" id="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4">
                <!-- Summary Section - Côte à côte -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Quantity Summary -->
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm summary-card">
                        <div class="bg-gray-200 px-3 py-2 rounded-t-lg">
                            <h6 class="font-bold text-sm"><i class="fas fa-boxes mr-2"></i>Résumé des quantités</h6>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center py-1">
                                <span class="font-bold text-sm">Total unités :</span>
                                <span class="bg-gray-800 text-white px-2 py-1 rounded-full text-xs" id="tot">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Global Total -->
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm summary-card">
                        <div class="bg-gray-200 px-3 py-2 rounded-t-lg">
                            <h6 class="font-bold text-sm"><i class="fas fa-receipt mr-2"></i>Total global</h6>
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center py-1">
                                <span class="font-bold text-sm">Montant final :</span>
                                <span class="text-lg font-bold" id="global-total-modal">0 Ar</span>
                            </div>
                            <div id="empty-cageots-supplement" class="text-right text-xs mt-1 hidden">
                                <span class="text-gray-500">dont supplément cageots: </span>
                                <span class="text-yellow-600 font-bold">0 Ar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options Section - Côte à côte -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Empty Crates Option -->
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h6 class="font-bold text-sm"><i class="fas fa-tools mr-2"></i>Options de conditionnement</h6>
                        </div>
                        <div class="p-3">
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="choix" name="choix" class="h-4 w-4 text-blue-600">
                                    <label for="choix" class="ml-2 font-bold text-sm cursor-pointer">Ajouter des cageots vides</label>
                                </div>
                                <div id="choix_content" class="pl-4 mt-2 hidden">
                                    <div class="flex">
                                        <input type="number" class="w-20 px-2 py-1 border border-gray-300 rounded-l"
                                            name="embale" id="embale" placeholder="Nombre">
                                        <span class="bg-gray-100 px-2 py-1 border border-gray-300 border-l-0 rounded-r text-sm">unités</span>
                                    </div>
                                    <small class="text-gray-500 text-xs">Prix par cageot: <span id="cageot-unit-price">0</span> Ar</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Options -->
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h6 class="font-bold text-sm"><i class="fas fa-money-bill-wave mr-2"></i>Options de paiement</h6>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="fidele" name="fidele" class="h-4 w-4 text-blue-600">
                                        <label for="fidele" class="ml-2 cursor-pointer text-sm">
                                            <i class="fas fa-user-check mr-1"></i> Mode non consigné
                                        </label>
                                    </div>
                                    <small class="text-gray-500 text-xs block ml-6">(Bouteilles + Cageots)</small>
                                </div>

                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="payer" name="payer" class="h-4 w-4 text-blue-600" checked>
                                        <label for="payer" class="ml-2 cursor-pointer text-sm">
                                            <i class="fas fa-money-bill-wave mr-1"></i> Paiement immédiat
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="disposition" name="disposition" class="h-4 w-4 text-blue-600">
                                        <label for="disposition" class="ml-2 cursor-pointer text-sm">
                                            <i class="fas fa-archive mr-1 text-yellow-500"></i> À disposition
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Fields -->
                <div id="paiement-fields" class="mt-3 p-3 border border-gray-300 rounded bg-gray-50">
                    <h6 class="font-bold text-sm mb-2"><i class="fas fa-cash-register mr-2"></i>Détails du paiement</h6>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="montant-recu" class="block text-xs font-medium text-gray-700">Montant reçu (Ar)</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
                                id="montant-recu" name="montant_recu">
                        </div>
                        <div>
                            <label for="montant-rendu" class="block text-xs font-medium text-gray-700">Montant à rendre (Ar)</label>
                            <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100 text-sm"
                                id="montant-rendu" name="montant_rendu" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 px-4 py-3 rounded-b-md flex justify-end space-x-2">
                <button id="cancel-modal" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-times mr-1"></i> Annuler
                </button>
                <button type="submit" form="venteForm" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm" id="confirm-btn">
                    <i class="fas fa-check-circle mr-1"></i> Confirmer
                </button>
            </div>
        </div>
    </div>
    <!-- Template for new article rows -->
    <template id="article-template">
        <tr class="article-row" data-index="{index}">
            <td class="px-4 py-4 whitespace-nowrap">
                <select class="w-full px-2 py-1 border border-gray-300 rounded shadow-sm article-select searchable-select"
                    name="articles[{index}][id]" required>
                    <option value="">Sélectionner un article</option>
                    @foreach($articles as $article)
                    <option value="{{ $article->id }}"
                        data-prix="{{ $article->prix_unitaire }}"
                        data-consignation="{{ $article->prix_consignation }}"
                        data-cgt="{{ $article->prix_cgt }}"
                        data-conditionnement="{{ $article->conditionnement }}"
                        data-quantite="{{ $article->quantite }}"
                        data-prix_gros="{{ $article->prix_gros }}"
                        data-prix_conditionne="{{ $article->prix_conditionne }}">
                        {{ $article->nom }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 prix-unitaire"
                    name="articles[{index}][prix_unitaire]" readonly>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 prix-cgt"
                    name="articles[{index}][prix_cgt]" readonly>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 stock-cageots"
                    name="articles[{index}][stock_cageots]" readonly>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded bg-gray-100 stock-unites"
                    name="articles[{index}][stock_unites]" readonly>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded quantite-cageot"
                    name="articles[{index}][quantite_cageot]" min="0">
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="number" class="w-full px-2 py-1 border border-gray-300 rounded quantite-unite"
                    name="articles[{index}][quantite_unite]" min="0">
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <div class="flex flex-col space-y-1">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 avec-cageot"
                            name="articles[{index}][avec_cageot]" id="avec_cageot_{index}" checked>
                        <span class="ml-2 text-sm">Cageot</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 avec-bouteille"
                            name="articles[{index}][avec_bouteille]" id="avec_bouteille_{index}" checked>
                        <span class="ml-2 text-sm">Bouteille</span>
                    </label>
                </div>
            </td>
            <td class="px-2 py-4 whitespace-nowrap text-right">
                <div class="total-price font-bold" data-index="{index}">0.00 Ar</div>
                <div class="price-details text-xs text-gray-500" data-index="{index}"></div>
            </td>
            <td class="px-2 py-4 whitespace-nowrap">
                <button type="button" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded remove-article">
                    <i class="fas fa-trash text-white text-xs"></i>
                </button>
            </td>
        </tr>
    </template>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialiser Select2
            $('.searchable-select').select2();

            // Variables globales
            let articleIndex = 1;
            let emptyCageotsPrice = 0;

            // Mobile menu toggle
            $('#mobile-menu-button').on('click', function() {
                $('#mobile-menu').toggleClass('hidden');
            });

            // Toggle new client field
            $('#toggle_nouveau_client').on('click', function() {
                const nouveauClientField = $('#nouveau_client');
                const clientSelect = $('#client_id');

                if (nouveauClientField.prop('disabled')) {
                    nouveauClientField.prop('disabled', false).prop('required', true);
                    clientSelect.prop('disabled', true).prop('required', false).val('');
                    $(this).html('<span style="font-size: 1rem; color: white;">-</span>');
                } else {
                    nouveauClientField.prop('disabled', true).prop('required', false).val('');
                    clientSelect.prop('disabled', false).prop('required', true);
                    $(this).html('<span style="font-size: 1rem; color: white;">+</span>');
                }
            });

            // Modal functionality
            $('#final2').on('click', function() {
                $('#vente-modal').removeClass('hidden');
                calculateGlobalTotal();
            });

            $('#close-modal, #cancel-modal').on('click', function() {
                $('#vente-modal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#vente-modal').on('click', function(event) {
                if (event.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // Toggle empty crates option
            $('#choix').on('change', function() {
                $('#choix_content').toggleClass('hidden', !this.checked);
                if (!this.checked) {
                    $('#embale').val('');
                    emptyCageotsPrice = 0; // Réinitialiser le prix des cageots vides
                }
                calculateGlobalTotal();
            });

            // Gérer les cageots vides
            $('#embale').on('input', function() {
                if ($('#choix').is(':checked')) {
                    calculateGlobalTotal();
                }
            });

            // Gestion des checkboxes de paiement
            $('#disposition, #payer, #fidele').on('change', function() {
                if (this.id === 'disposition' && this.checked) {
                    $('#payer').prop('checked', false);
                    $('#fidele').prop('checked', false);
                    $('#paiement-fields').hide();
                } else if (this.id === 'payer' && this.checked) {
                    $('#disposition').prop('checked', false);
                    $('#paiement-fields').show();
                    $('#montant-recu').val('').focus();
                    $('#montant-rendu').val('');
                } else if (this.id === 'fidele' && this.checked) {
                    $('#disposition').prop('checked', false);
                }
            });

            // Calcul du montant à rendre
            $('#montant-recu').on('input', function() {
                const montantRecu = parseFloat($(this).val()) || 0;
                const total = parseFloat($('#tot_glob').val()) || 0;
                const montantRendu = montantRecu - total;
                $('#montant-rendu').val(montantRendu >= 0 ? montantRendu.toFixed(2) : '0.00');
            });

            // Type de vente (gros/détail)
            $('#type_vente').on('change', function() {
                const type = $(this).val();
                $('.article-row').each(function() {
                    const row = $(this);
                    const selectedOption = row.find('.article-select option:selected');
                    const prixDetail = parseFloat(selectedOption.data('prix')) || 0;
                    const prixGros = parseFloat(selectedOption.data('prix_gros')) || 0;
                    const prixFinal = type === 'gros' ? prixGros : prixDetail;
                    row.find('.prix-unitaire').val(prixFinal);
                    calculateArticleTotal(row.data('index'));
                });
                calculateGlobalTotal();
            });

            // Fonction pour calculer le prix total d'un article
            function calculateArticleTotal(index) {
                const row = $(`.article-row[data-index="${index}"]`);
                const prixUnitaire = parseFloat(row.find('.prix-unitaire').val()) || 0;
                const quantiteCageot = parseInt(row.find('.quantite-cageot').val()) || 0;
                const quantiteUnite = parseInt(row.find('.quantite-unite').val()) || 0;
                const selectedOption = row.find('.article-select option:selected');
                const prixConsignation = parseFloat(selectedOption.data('consignation')) || 0;
                const prixCgt = parseFloat(selectedOption.data('cgt')) || 0;
                const groscageots = parseFloat(selectedOption.data('prix_conditionne')) || 0;
                const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;

                // Décocher automatiquement si prix à 0
                if (prixConsignation === 0) {
                    row.find('.avec-bouteille').prop('checked', false);
                }
                if (prixCgt === 0) {
                    row.find('.avec-cageot').prop('checked', false);
                }

                const avecCageot = prixCgt > 0 && row.find('.avec-cageot').is(':checked');
                const avecBouteille = prixConsignation > 0 && row.find('.avec-bouteille').is(':checked');
                const totalUnites = (quantiteCageot * conditionnement) + quantiteUnite;
                let total = (quantiteUnite * prixUnitaire) + (quantiteCageot * groscageots);
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

                row.find('.total-price').text(total.toFixed(2) + ' Ar');
                row.find('.price-details').html(details.join('<br>'));

                return {
                    totalAvecConsigne: total,
                    totalSansConsigne: totalSansConsigne,
                    prixCgt: prixCgt,
                    totalUnites: totalUnites
                };
            }

            // Fonction pour calculer le total général
            function calculateGlobalTotal() {
                let globalTotal = 0;
                let globalNonConsigne = 0;
                let prixCgtReference = 0;
                let totalUnitesGlobal = 0;

                $('.article-row').each(function() {
                    const index = $(this).data('index');
                    const result = calculateArticleTotal(index);
                    globalTotal += result.totalAvecConsigne;
                    globalNonConsigne += result.totalSansConsigne;
                    totalUnitesGlobal += result.totalUnites;
                    if (prixCgtReference === 0) {
                        prixCgtReference = result.prixCgt;
                    }
                });

                // Ajouter le coût des cageots vides uniquement si l'option est cochée
                emptyCageotsPrice = 0;
                if ($('#choix').is(':checked')) {
                    const emptyCageots = parseInt($('#embale').val()) || 0;
                    emptyCageotsPrice = emptyCageots * prixCgtReference;
                }

                const totalWithEmptyCageots = globalTotal + emptyCageotsPrice;

                $('#global-total').text(totalWithEmptyCageots.toFixed(2) + ' Ar');
                $('#total_non_consignee').val(globalNonConsigne.toFixed(2));
                $('#tot_glob').val(totalWithEmptyCageots.toFixed(2));
                $('#global-total-modal').text(totalWithEmptyCageots.toFixed(2) + ' Ar');
                $('#tot').text(totalUnitesGlobal);
                $('#cageot-unit-price').text(prixCgtReference.toFixed(2));

                if ($('#choix').is(':checked') && emptyCageotsPrice > 0) {
                    $('#empty-cageots-supplement').show();
                    $('#empty-cageots-supplement span').text(emptyCageotsPrice.toFixed(2) + ' Ar');
                } else {
                    $('#empty-cageots-supplement').hide();
                }

                if ($('#payer').is(':checked') && $('#montant-recu').val()) {
                    $('#montant-recu').trigger('input');
                }
            }

            // Mettre à jour le stock affiché
            function updateStockDisplay(row) {
                const selectedOption = row.find('.article-select option:selected');
                const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
                const stockTotal = parseInt(selectedOption.data('quantite')) || 0;
                const cageots = Math.floor(stockTotal / conditionnement);
                const unites = stockTotal % conditionnement;

                row.find('.stock-cageots').val(cageots);
                row.find('.stock-unites').val(unites);
            }

            // Gérer le changement d'article
            $(document).on('change', '.article-select', function() {
                const row = $(this).closest('.article-row');
                const selectedOption = $(this).find('option:selected');
                const type = $('#type_vente').val();
                const prixDetail = parseFloat(selectedOption.data('prix')) || 0;
                const prixGros = parseFloat(selectedOption.data('prix_gros')) || 0;
                const prixUnitaire = type === 'gros' ? prixGros : prixDetail;
                const prixCgt = parseFloat(selectedOption.data('cgt')) || 0;
                const prixConsignation = parseFloat(selectedOption.data('consignation')) || 0;
                const groscageots = parseFloat(selectedOption.data('prix_conditionne')) || 0;

                row.find('.prix-unitaire').val(prixUnitaire);
                row.find('.prix-cgt').val(groscageots);

                if (prixConsignation === 0) {
                    row.find('.avec-bouteille').prop('checked', false);
                }
                if (prixCgt === 0) {
                    row.find('.avec-cageot').prop('checked', false);
                }

                updateStockDisplay(row);
                calculateGlobalTotal();
            });

            // Gérer les changements de quantité
            $(document).on('input change', '.quantite-cageot, .quantite-unite, .avec-cageot, .avec-bouteille', function() {
                const row = $(this).closest('.article-row');
                const index = row.data('index');
                const selectedOption = row.find('.article-select option:selected');
                const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
                const stockTotal = parseInt(selectedOption.data('quantite')) || 0;
                const quantiteCageot = parseInt(row.find('.quantite-cageot').val()) || 0;
                const quantiteUnite = parseInt(row.find('.quantite-unite').val()) || 0;
                const totalDemande = (quantiteCageot * conditionnement) + quantiteUnite;

                if (totalDemande > stockTotal) {
                    alert('La quantité demandée dépasse le stock disponible !');
                    row.find('.quantite-cageot').val('');
                    row.find('.quantite-unite').val('');
                }

                calculateGlobalTotal();
            });

            // Ajouter un nouvel article
            $('#add-article').on('click', function() {
                const template = $('#article-template').html().replace(/{index}/g, articleIndex);
                $('#articles-container').append(template);
                $('#articles-container .article-select').last().select2();
                articleIndex++;
                calculateGlobalTotal();
            });

            // Supprimer un article
            $(document).on('click', '.remove-article', function() {
                $(this).closest('.article-row').remove();
                calculateGlobalTotal();
            });

            // Validation du formulaire
            $('#venteForm').on('submit', function(e) {
                if ($('.article-row').length === 0) {
                    e.preventDefault();
                    alert('Veuillez ajouter au moins un article.');
                    return false;
                }

                let isValid = true;
                $('.article-select').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        alert('Veuillez sélectionner un article pour chaque ligne.');
                        return false;
                    }
                });

                if ($('#payer').is(':checked')) {
                    const montantRecu = parseFloat($('#montant-recu').val()) || 0;
                    const total = parseFloat($('#tot_glob').val()) || 0;
                    if (montantRecu < total) {
                        e.preventDefault();
                        alert('Le montant reçu est inférieur au total de la commande.');
                        return false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                disableSubmitButton(this);
            });

            // Désactiver le bouton de soumission
            function disableSubmitButton(form) {
                const button = $(form).find('button[type="submit"]');
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Confirmer');
            }
        });
    </script>
</body>

</html>