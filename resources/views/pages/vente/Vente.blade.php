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
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 46px;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
        }
    </style>
</head>

<body class="bg-gray-50">
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
    <div class="container mx-auto px-4 py-6 mt-12">
        <div class="bg-white shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="border-b-2 border-b-gray-500 bg-gray-10 px-6 py-4 text-dark flex justify-between items-center">
                <h5 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-cash-register mr-2"></i> Nouvelle vente
                </h5>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i>Retour
                </a>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <form id="venteForm" action="{{ route('vente.store') }}" method="POST" onsubmit="disableSubmitButton(this)">
                    @csrf

                    <!-- Section Client -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6 items-end">
                        <!-- Client existant -->
                        <div class="md:col-span-3">
                            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Client existant</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2 searchable-select" id="client_id" name="client_id" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nouveau client -->
                        <div class="md:col-span-3 flex items-end gap-2">
                            <div class="flex-1">
                                <label for="nouveau_client" class="block text-sm font-medium text-gray-700 mb-1">Nouveau client</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" name="nouveau" id="nouveau_client" disabled>
                            </div>
                            <button type="button" id="toggle_nouveau_client" class="h-10 w-10 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded" title="Créer un nouveau client">
                                <span class="text-xl font-bold">+</span>
                            </button>
                        </div>

                        <!-- Date -->
                        <div class="md:col-span-2">
                            <label for="date_vente" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" id="date_vente" value="{{ now()->format('d/m/Y') }}" readonly>
                        </div>

                        <!-- Hidden inputs -->
                        <input type="hidden" name="total_non_consignee" id="total_non_consignee">
                        <input type="hidden" name="tot_glob" id="tot_glob">

                        <!-- Numéro de commande -->
                        <div class="md:col-span-2">
                            <label for="numero_commande" class="block text-sm font-medium text-gray-700 mb-1">N° Commande</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" id="numero_commande" value="C-{{ str_pad(($dernier->id ?? 0) + 1, 5, '0', STR_PAD_LEFT) }}" readonly>
                        </div>

                        <!-- Type -->
                        <div class="md:col-span-2">
                            <label for="type_vente" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2" id="type_vente" name="cat">
                                <option value="gros">Détail</option>
                                <option value="detail">Gros</option>
                            </select>
                        </div>
                    </div>


                    <hr class="my-6">

                    <!-- Section Articles - Tableau amélioré -->
                    <div id="articles-container" class="border border-gray-300 overflow-hidden">
                        <!-- En-tête du tableau avec bordures -->
                        <div class="grid grid-cols-12 gap-0 bg-gray-600 border-b border-gray-300 font-medium text-gray-700 text-white">
                            <div class="col-span-2 p-3 border-r border-gray-300">Article</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">prix unitaire</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">P.cgt</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">Qt.CGT/Pack</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">Qt.BTL</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">Cageot/pack</div>
                            <div class="col-span-1 p-3 border-r border-gray-300 text-center">Unité</div>
                            <div class="col-span-2 p-3 border-r border-gray-300 text-center">Options</div>
                            <div class="col-span-2 p-3 text-center">Total</div>
                        </div>

                        <!-- Premier article avec bordures -->
                        <div class="article-section border-b border-gray-200 last:border-b-0" data-index="0">
                            <div class="grid grid-cols-12 gap-0 items-center">
                                <!-- Article -->
                                <div class="col-span-2 p-3 border-r border-gray-200">
                                    <select class="w-full border border-gray-300 rounded px-2 py-1 searchable-select article-select" name="articles[0][id]" required>
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
                                </div>

                                <!-- Prix unitaire -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[0][prix_unitaire]" readonly>
                                </div>

                                <!-- Prix CGT -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[0][prix_cgt]" readonly>
                                </div>

                                <!-- Stock cageots -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[0][stock_cageots]" readonly>
                                </div>

                                <!-- Stock unités -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[0][stock_unites]" readonly>
                                </div>

                                <!-- Quantité cageot -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 text-center" name="articles[0][quantite_cageot]" min="0">
                                </div>

                                <!-- Quantité unité -->
                                <div class="col-span-1 p-3 border-r border-gray-200">
                                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 text-center" name="articles[0][quantite_unite]" min="0">
                                </div>

                                <!-- Options -->
                                <div class="col-span-2 p-3 border-r border-gray-200">
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
                                <div class="col-span-2 p-3 text-center">
                                    <div class="font-bold total-price mb-2" data-index="0">0 Ar</div>
                                    <div class="text-xs text-gray-500 price-details mb-2" data-index="0"></div>
                                    <button type="button" class="delete-article bg-red-600 hover:bg-red-700 text-white px-2 py-1 text-sm flex items-center justify-center w-full mx-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter article -->
                    <div class="mb-6 mt-4">
                        <button type="button" id="add-article" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 flex items-center">
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
                        <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 flex items-center text-lg" id="final2">
                            <i class="fas fa-check-circle mr-2"></i> Valider la vente
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
                            <!-- En-tête du modal -->
                            <div class="modal-header bg-gray-800 text-white px-6 py-4 rounded-t-md flex justify-between items-center">
                                <h5 class="modal-title font-bold text-lg" id="venteModal2Label">
                                    <i class="fas fa-cogs mr-2"></i>Configuration avancée de la commande
                                </h5>
                                <button type="button" class="close text-white text-2xl" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Corps du modal -->
                            <div class="modal-body p-6">
                                <div class="container-fluid">
                                    <!-- Section Résumé -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div class="border border-gray-300 rounded-lg h-full">
                                            <div class="bg-gray-600 text-white px-4 py-2 rounded-t-lg">
                                                <h6 class="font-semibold"><i class="fas fa-boxes mr-2"></i>Résumé des quantités</h6>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex justify-between items-center py-2">
                                                    <span class="font-bold">Total unités :</span>
                                                    <span class="bg-gray-800 text-white px-3 py-1 rounded-full" id="total-unites">0</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border border-gray-300 rounded-lg h-full">
                                            <div class="bg-gray-600 text-white px-4 py-2 rounded-t-lg">
                                                <h6 class="font-semibold"><i class="fas fa-receipt mr-2"></i>Total global</h6>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex justify-between items-center py-2">
                                                    <span class="font-bold">Montant final :</span>
                                                    <span class="text-lg font-bold" id="global-total-modal">0 Ar</span>
                                                </div>
                                                <div id="empty-cageots-supplement" class="text-right text-sm mt-1 hidden">
                                                    <span class="text-gray-600">dont supplément cageots: </span>
                                                    <span class="text-yellow-600 font-bold">0 Ar</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section Options -->
                                    <div class="border border-gray-300 rounded-lg shadow-sm mb-6">
                                        <div class="bg-gray-100 px-4 py-2 rounded-t-lg">
                                            <h6 class="font-semibold"><i class="fas fa-tools mr-2"></i>Options de conditionnement</h6>
                                        </div>
                                        <div class="p-4">
                                            <!-- Option Cageots vides -->
                                            <div class="mb-4">
                                                <div class="flex items-center mb-2">
                                                    <input type="checkbox" class="h-5 w-5 text-blue-600" id="choix" name="choix" style="cursor: pointer;">
                                                    <label class="ml-2 font-bold cursor-pointer" for="choix">Ajouter des cageots vides</label>
                                                </div>
                                                <div id="choix_content" class="pl-6 mt-2 hidden">
                                                    <div class="flex">
                                                        <input type="number" class="border border-gray-300 rounded px-3 py-2 w-32" name="embale" id="embale" placeholder="Nombre de cageots">
                                                        <span class="bg-gray-100 border border-gray-300 border-l-0 px-3 py-2 rounded-r">unités</span>
                                                    </div>
                                                    <small class="text-gray-600">Prix par cageot: <span id="cageot-unit-price">0</span> Ar</small>
                                                </div>
                                            </div>

                                            <!-- Options de paiement -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="flex items-center">
                                                        <input type="checkbox" class="h-5 w-5 text-blue-600" id="fidele" name="fidele" style="cursor: pointer;">
                                                        <span class="ml-2 cursor-pointer">
                                                            <i class="fas fa-user-check mr-1"></i> Mode non consigné
                                                        </span>
                                                    </label>
                                                    <small class="text-gray-600">(Bouteilles + Cageots)</small>
                                                </div>

                                                <div>
                                                    <label class="flex items-center">
                                                        <input type="checkbox" class="h-5 w-5 text-blue-600" id="payer" name="payer" style="cursor: pointer;" checked>
                                                        <span class="ml-2 cursor-pointer">
                                                            <i class="fas fa-money-bill-wave mr-1"></i> Paiement immédiat
                                                        </span>
                                                    </label>
                                                </div>

                                                <div>
                                                    <label class="flex items-center">
                                                        <input type="checkbox" class="h-5 w-5 text-blue-600" id="disposition" name="disposition" style="cursor: pointer;">
                                                        <span class="ml-2 cursor-pointer">
                                                            <i class="fas fa-archive mr-1 text-yellow-600"></i> À disposition
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Champs de paiement -->
                                            <div id="paiement-fields" class="mt-4 p-4 border rounded bg-gray-50">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="montant-recu" class="block text-sm font-medium text-gray-700">Montant reçu (Ar)</label>
                                                        <input type="number" class="w-full border border-gray-300 rounded px-3 py-2" id="montant-recu" name="montant_recu">
                                                    </div>
                                                    <div>
                                                        <label for="montant-rendu" class="block text-sm font-medium text-gray-700">Montant à rendre (Ar)</label>
                                                        <input type="number" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" id="montant-rendu" name="montant_rendu" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pied de page du modal -->
                            <div class="modal-footer bg-gray-100 px-6 py-4 rounded-b-md flex justify-end space-x-3">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded flex items-center" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i> Annuler
                                </button>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center" id="confirm-btn">
                                    <i class="fas fa-check-circle mr-1"></i> Confirmer la configuration
                                </button>
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
                    <select class="w-full border border-gray-300 rounded px-2 py-1 searchable-select article-select" name="articles[{index}][id]" required>
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
                </div>

                <!-- Prix unitaire -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[{index}][prix_unitaire]" readonly>
                </div>

                <!-- Prix CGT -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[{index}][prix_cgt]" readonly>
                </div>

                <!-- Stock cageots -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[{index}][stock_cageots]" readonly>
                </div>

                <!-- Stock unités -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-center" name="articles[{index}][stock_unites]" readonly>
                </div>

                <!-- Quantité cageot -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 text-center" name="articles[{index}][quantite_cageot]" min="0">
                </div>

                <!-- Quantité unité -->
                <div class="col-span-1 p-3 border-r border-gray-200">
                    <input type="number" class="w-full border border-gray-300 rounded px-2 py-1 text-center" name="articles[{index}][quantite_unite]" min="0">
                </div>

                <!-- Options -->
                <div class="col-span-2 p-3 border-r border-gray-200">
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
                <div class="col-span-2 p-3 text-center">
                    <div class="font-bold total-price mb-2" data-index="{index}">0 Ar</div>
                    <div class="text-xs text-gray-500 price-details mb-2" data-index="{index}"></div>
                    <button type="button" class="delete-article bg-red-600 hover:bg-red-700 text-white px-2 py-1 text-sm flex items-center justify-center w-full mx-auto">
                        <i class="fas fa-trash mr-1"></i> Supprimer
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
                const montantRecu = parseInt($(this).val()) || 0;
                const total = parseInt($('#tot_glob').val()) || 0;
                const montantRendu = montantRecu - total;
                $('#montant-rendu').val(montantRendu >= 0 ? formatNumber(montantRendu) : '0');
            });

            // Prevent form submission if payment is required but amount is not entered
            $('#venteForm').submit(function(e) {
                if ($('#payer').is(':checked') && !$('#montant-recu').val()) {
                    e.preventDefault();
                    alert('Veuillez saisir le montant reçu.');
                    return false;
                }
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

                // Uncheck options if price is 0
                if (prixConsignation === 0) {
                    section.find('input[name$="[avec_bouteille]"]').prop('checked', false);
                }
                if (prixCgt === 0) {
                    section.find('input[name$="[avec_cageot]"]').prop('checked', false);
                }

                const avecCageot = prixCgt > 0 && section.find('input[name$="[avec_cageot]"]').is(':checked');
                const avecBouteille = prixConsignation > 0 && section.find('input[name$="[avec_bouteille]"]').is(':checked');
                const totalUnites = (quantiteCageot * conditionnement) + quantiteUnite;

                let total = (quantiteUnite * prixUnitaire) + (quantiteCageot * prixConditionne);
                let totalSansConsigne = total;
                let details = [];

                if (avecCageot && quantiteCageot > 0) {
                    const suppCageot = quantiteCageot * prixCgt;
                    total += suppCageot;
                    details.push(`+ ${quantiteCageot} cageot: ${formatNumber(suppCageot)}`);
                }
                if (avecBouteille && totalUnites > 0) {
                    const suppBouteille = totalUnites * prixConsignation;
                    total += suppBouteille;
                    details.push(`+ ${totalUnites} bouteille: ${formatNumber(suppBouteille)}`);
                }

                $(`.total-price[data-index="${index}"]`).text(formatNumber(total) + ' Ar');
                $(`.price-details[data-index="${index}"]`).html(details.join('<br>'));

                return {
                    totalAvecConsigne: total,
                    totalSansConsigne: totalSansConsigne,
                    prixCgt: prixCgt
                };
            }

            // Calculate global total
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

                $('#global-total').text(formatNumber(totalWithEmptyCageots) + ' Ar');
                $('#total_non_consignee').val(globalNonConsigne);
                $('#tot_glob').val(totalWithEmptyCageots);
                $('#global-total-modal').text(formatNumber(totalWithEmptyCageots) + ' Ar');
                $('#cageot-unit-price').text(formatNumber(prixCgtReference));

                if ($('#choix').is(':checked') && emptyCageots > 0) {
                    $('#empty-cageots-supplement').show();
                    $('#empty-cageots-supplement span').text(formatNumber(emptyCageotsPrice) + ' Ar');
                } else {
                    $('#empty-cageots-supplement').hide();
                }

                if ($('#payer').is(':checked') && $('#montant-recu').val()) {
                    $('#montant-recu').trigger('input');
                }
            }

            // Show modal and calculate totals
            $('#final2').on('click', function() {
                calculateGlobalTotal();
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
                } else {
                    $('#choix_content').hide();
                    $('#embale').val('');
                    calculateGlobalTotal();
                }
            });

            $(document).on('input', '#embale', function() {
                calculateGlobalTotal();
            });

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

            // Handle article selection
            $(document).on('change', '.article-select', function() {
                const selectedOption = $(this).find('option:selected');
                const type = $('#type_vente').val();
                const prixDetail = parseInt(selectedOption.data('prix')) || 0;
                const prixGros = parseInt(selectedOption.data('prix_gros')) || 0;
                const prixUnitaire = (type === 'gros') ? prixGros : prixDetail;
                const prixCgt = parseInt(selectedOption.data('cgt')) || 0;
                const prixConsignation = parseInt(selectedOption.data('consignation')) || 0;
                const prixConditionne = parseInt(selectedOption.data('prix_conditionne')) || 0;
                const parentSection = $(this).closest('.article-section');

                parentSection.find('input[name$="[prix_unitaire]"]').val(prixUnitaire);
                parentSection.find('input[name$="[prix_cgt]"]').val(prixConditionne);

                if (prixConsignation === 0) {
                    parentSection.find('input[name$="[avec_bouteille]"]').prop('checked', false);
                }
                if (prixCgt === 0) {
                    parentSection.find('input[name$="[avec_cageot]"]').prop('checked', false);
                }

                updateStockDisplay(parentSection);
                calculateGlobalTotal();
            });

            // Handle quantity changes and options
            $(document).on('change input', 'input[name$="[quantite_cageot]"], input[name$="[quantite_unite]"], input[name$="[avec_cageot]"], input[name$="[avec_bouteille]"]', function() {
                const parentSection = $(this).closest('.article-section');
                const index = parentSection.data('index');
                const selectedOption = parentSection.find('.article-select option:selected');
                const conditionnement = parseInt(selectedOption.data('conditionnement')) || 1;
                const stockTotal = parseInt(selectedOption.data('quantite')) || 0;
                const quantiteCageot = parseInt(parentSection.find('input[name$="[quantite_cageot]"]').val()) || 0;
                const quantiteUnite = parseInt(parentSection.find('input[name$="[quantite_unite]"]').val()) || 0;
                const totalDemande = (quantiteCageot * conditionnement) + quantiteUnite;

                if (totalDemande > stockTotal) {
                    alert('La quantité demandée dépasse le stock disponible!');
                    parentSection.find('input[name$="[quantite_cageot]"]').val('');
                    parentSection.find('input[name$="[quantite_unite]"]').val('');
                }

                calculateGlobalTotal();
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
                calculateGlobalTotal();
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
        });
    </script>