<!DOCTYPE html>
<html lang="en">
@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class=" mx-auto px-4">
    <div class="bg-white shadow-lg  overflow-hidden">
        <!-- Card Header -->

        <!-- Card Header with Search and Add Button -->
        <div class="bg-gray-100 p-4 flex flex-wrap justify-between items-center gap-4">
            <form action="{{ route('article.liste') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ old('search', request('search')) }}"
                        class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Rechercher...">
                </div>
                <div class="relative">
                    <button type="button"
                        class="border rounded-lg px-3 py-2 text-sm bg-white text-gray-600 hover:bg-gray-50 flex items-center"
                        onclick="toggleSortDropdown()">
                        <i class="fas fa-sort mr-1"></i> Trier par
                    </button>
                    <div id="sortDropdown" class="absolute hidden mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                        <button type="submit" name="sort" value="nom_asc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Nom (A-Z)</button>
                        <button type="submit" name="sort" value="nom_desc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Nom (Z-A)</button>
                        <button type="submit" name="sort" value="prix_asc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Prix (Croissant)</button>
                        <button type="submit" name="sort" value="prix_desc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Prix (Décroissant)</button>
                        <button type="submit" name="sort" value="stock_asc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Stock (Croissant)</button>
                        <button type="submit" name="sort" value="stock_desc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Stock (Décroissant)</button>
                    </div>
                </div>
            </form>
            <button class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 flex items-center"
                onclick="openModal('addArticleModal')">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter boisson
            </button>
        </div>

        <!-- Card Body -->
        <div class="p-4">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Nom</th>
                            <th class="p-2">Catégorie</th>
                            <th class="p-2">P.Vente unité gros</th>
                            <th class="p-2">P.Vente cageot/pack</th>
                            <th class="p-2">Prix détails</th>
                            <th class="p-2">P.Achat</th>
                            <th class="p-2">Quantité</th>
                            <th class="p-2">Date</th>
                            <th class="p-2">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['id'] }}</td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ \Illuminate\Support\Str::limit($article['nom'], 15) }}</td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['categorie'] }}</td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                {{ isset($article['prix_unitaire']) && is_numeric($article['prix_unitaire']) ? number_format($article['prix_unitaire'], 0, '.', ',') . ' Ar' : '---' }}
                            </td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                {{ isset($article['prix_conditionne']) && is_numeric($article['prix_conditionne']) ? number_format($article['prix_conditionne'], 0, '.', ',') . ' Ar' : '---' }}
                            </td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                {{ isset($article['prix_gros']) && is_numeric($article['prix_gros']) ? number_format($article['prix_gros'], 0, '.', ',') . ' Ar' : '---' }}
                            </td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                {{ isset($article['prix_achat']) && is_numeric($article['prix_achat']) ? number_format($article['prix_achat'], 0, '.', ',') . ' Ar' : '---' }}
                            </td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                @php
                                $quotient = intdiv($article['quantite'], $article['conditionnement']);
                                $reste = $article['quantite'] % $article['conditionnement'];
                                $affichage = $quotient;
                                @endphp
                                {{ $affichage }} cageot/pack{{ $affichage > 1 ? 's' : '' }} @if($reste > 0) et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}@endif
                            </td>
                            <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">
                                @if (!empty($article['created_at']))
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $article['created_at'])->format('Y-m-d') }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="p-3 relative">
                                <!-- Bouton menu déroulant -->
                                <div class="relative inline-block text-left">
                                    <button type="button"
                                        class="inline-flex justify-center w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100  "
                                        onclick="toggleDropdown('dropdown-menu-{{ $article['id'] }}')">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <!-- Menu déroulant -->
                                    <div id="dropdown-menu-{{ $article['id'] }}"
                                        class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            <button onclick="openEditModal('editArticleModal{{ $article['id'] }}')"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                <i class="fas fa-edit mr-3 text-blue-500"></i>
                                                Modifier
                                            </button>
                                            <button onclick="openDeleteModal('supprimerModal{{ $article['id'] }}')"
                                                class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 w-full text-left">
                                                <i class="fas fa-trash-alt mr-3"></i>
                                                Supprimer
                                            </button>
                                            <!-- <a href="#"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                <i class="fas fa-eye mr-3 text-green-500"></i>
                                                Voir détails
                                            </a>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                <i class="fas fa-chart-line mr-3 text-purple-500"></i>
                                                Statistiques
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="supprimerModal{{ $article['id'] }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-md">
                                <div class="p-4 border-b">
                                    <h5 class="text-lg font-bold">Suppression</h5>
                                    <button onclick="closeModal('supprimerModal{{ $article['id'] }}')" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <p>Voulez-vous vraiment supprimer cet article <span class="text-yellow-500">{{ $article['nom'] }}</span> ?</p>
                                </div>
                                <div class="p-4 border-t flex justify-end gap-2">
                                    <button onclick="closeModal('supprimerModal{{ $article['id'] }}')" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                                    <a href="{{ route('delete.article', ['id' => $article['id']]) }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Supprimer</a>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div id="editArticleModal{{ $article['id'] }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-3xl">
                                <div class="bg-gray-50 text-dark p-4 rounded-t-lg flex justify-between items-center">
                                    <h5 class="text-lg font-bold">Modifier articles</h5>
                                    <button onclick="closeModal('editArticleModal{{ $article['id'] }}')" class="text-gray-900 hover:text-dark">
                                        <i class="fas fa-times text-dark"></i>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <form action="{{ route('articles.update') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="nom" class="block text-sm font-medium">Nom</label>
                                            <input type="text" name="nom" value="{{ $article['nom'] }}"
                                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            <input type="hidden" name="id" value="{{ $article['id'] }}">
                                        </div>
                                        <div class="mb-4">
                                            <label for="categorie" class="block text-sm font-medium">Catégorie</label>
                                            <select name="categorie_id" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">----</option>
                                                @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id }}" {{ $categorie->id == $article['categorie_id'] ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="conditionnement" class="block text-sm font-medium">Conditionnement</label>
                                            <select name="conditionnement" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="{{ $article['conditionnement'] }}">{{ $article['conditionnement'] }}</option>
                                                <option value="48">Emballage de 48</option>
                                                <option value="24">Emballage de 24</option>
                                                <option value="20">Emballage de 20</option>
                                                <option value="12">Emballage de 12</option>
                                                <option value="6">Emballage de 6</option>
                                                <option value="8">Emballage de 8</option>
                                            </select>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                            <div class="flex items-center">
                                                <input type="radio" name="choix_{{ $article['id'] }}" value="cageot" id="condi_cgt_{{ $article['id'] }}"
                                                    {{ ($article['prix_consignation'] > 0 && $article['prix_cgt']) > 0 ? 'checked' : '' }}
                                                    class="mr-2">
                                                <label for="condi_cgt_{{ $article['id'] }}" class="text-sm">Cageot</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="choix_{{ $article['id'] }}" value="pack" id="condi_pack_{{ $article['id'] }}"
                                                    {{ $article['prix_consignation'] == 0 ? 'checked' : '' }} class="mr-2">
                                                <label for="condi_pack_{{ $article['id'] }}" class="text-sm">Pack</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="choix_{{ $article['id'] }}" value="jet" id="condi_jet_{{ $article['id'] }}"
                                                    data-id="{{ $article['id'] }}"
                                                    {{ $article['prix_consignation'] > 0 && ($article['prix_cgt'] == 0 || $article['prix_cgt'] == null) ? 'checked' : '' }}
                                                    class="mr-2 condi_jet_radio">
                                                <label for="condi_jet_{{ $article['id'] }}" class="text-sm">Emb. jetable</label>
                                            </div>
                                            @if($article['prix_consignation'] > 0)
                                            <div class="flex items-center" id="reini_div_{{ $article['id'] }}">
                                                <input type="radio" name="choix_{{ $article['id'] }}" value="pack" id="reini_{{ $article['id'] }}"
                                                    class="mr-2">
                                                <label for="reini_{{ $article['id'] }}" class="text-sm">Réinitialiser</label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="prix_consignation" class="block text-sm font-medium">Prix consignation</label>
                                                <input type="number" name="prix_consignation" value="{{ $article['prix_consignation'] ?? '' }}"
                                                    readonly class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-100">
                                            </div>
                                            <div>
                                                <label for="diff_{{ $article['id'] }}" class="block text-sm font-medium">Nouveau prix consignation</label>
                                                <input type="number" name="diff_{{ $article['id'] }}" id="diff_{{ $article['id'] }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="prix_achat" class="block text-sm font-medium">Prix d'achat unité</label>
                                                <input type="number" name="prix_achat" value="{{ $article['prix_achat'] }}"
                                                    readonly class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-100">
                                            </div>
                                            <div>
                                                <label for="prix_unitaire" class="block text-sm font-medium">Prix de gros unité</label>
                                                <input type="number" name="prix_unitaire" value="{{ $article['prix_unitaire'] }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="prix_gros" class="block text-sm font-medium">Prix détails unité</label>
                                                <input type="number" name="prix_gros" value="{{ $article['prix_gros'] }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                                            </div>
                                            <div>
                                                <label for="prix_conditionne" class="block text-sm font-medium">Prix de gros cageot/pack <span class="text-red-500">*</span></label>
                                                <input type="number" name="prix_conditionne" value="{{ $article['prix_conditionne'] }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="quantite" class="block text-sm font-medium">Quantité en cageot/pack</label>
                                                <input type="number" name="quantite" value="{{ intdiv($article['quantite'], $article['conditionnement']) }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                                            </div>
                                            <div>
                                                <label for="quantite_unite" class="block text-sm font-medium">Quantité en unité</label>
                                                <input type="number" name="quantite_unite" value="{{ $article['quantite'] % $article['conditionnement'] }}"
                                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                                            </div>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="closeModal('editArticleModal{{ $article['id'] }}')"
                                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Enregistrer modification</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="10" class="p-4">
                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Pas de donnée trouvée
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    <script>
                        // Fonction pour ouvrir/fermer le menu déroulant
                        function toggleDropdown(menuId) {
                            const menu = document.getElementById(menuId);
                            menu.classList.toggle('hidden');

                            // Fermer les autres menus ouverts
                            document.querySelectorAll('[id^="dropdown-menu-"]').forEach(otherMenu => {
                                if (otherMenu.id !== menuId) {
                                    otherMenu.classList.add('hidden');
                                }
                            });
                        }

                        // Fermer les menus quand on clique ailleurs
                        document.addEventListener('click', function(event) {
                            if (!event.target.closest('.relative.inline-block')) {
                                document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
                                    menu.classList.add('hidden');
                                });
                            }
                        });

                        // Fonctions existantes pour les modals
                        function openEditModal(modalId) {
                            document.getElementById(modalId).classList.remove('hidden');
                        }

                        function openDeleteModal(modalId) {
                            document.getElementById(modalId).classList.remove('hidden');
                        }

                        function closeModal(modalId) {
                            document.getElementById(modalId).classList.add('hidden');
                        }
                    </script>

                    <style>
                        .relative.inline-block {
                            position: relative;
                        }

                        [id^="dropdown-menu-"] {
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                            border: 1px solid #e5e7eb;
                        }

                        .py-1 button,
                        .py-1 a {
                            transition: all 0.2s ease;
                        }

                        .py-1 button:hover,
                        .py-1 a:hover {
                            background-color: #f9fafb;
                        }
                    </style>
                </table>
                <div class="mt-4">
                    {{ $articles->appends(['search' => request('search')])->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Article Modal -->
    <div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-3xl">
            <div class="bg-gray-50 text-dark p-4 rounded-t-lg flex justify-between items-center">
                <h5 class="text-lg font-bold">Ajouter un article</h5>
                <button onclick="closeModal('addArticleModal')" class="text-dark hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form action="{{ route('articles.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-medium">Nom du boisson</label>
                        <input type="text" name="nom" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="categorie" class="block text-sm font-medium">Catégorie</label>
                        <select name="categorie_id" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value=""></option>
                            @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="conditionnement" class="block text-sm font-medium">Conditionnement</label>
                        <select name="conditionnement" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">---Sélectionner---</option>
                            <option value="48">Emballage de 48</option>
                            <option value="24">Emballage de 24</option>
                            <option value="20">Emballage de 20</option>
                            <option value="12">Emballage de 12</option>
                            <option value="6">Emballage de 6</option>
                            <option value="8">Emballage de 8</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="flex items-center">
                            <input type="radio" name="choix" value="cageot" id="condi_cgts" checked class="mr-2">
                            <label for="condi_cgts" class="text-sm">Cageot</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="choix" value="pack" id="condi_packs" class="mr-2">
                            <label for="condi_packs" class="text-sm">Pack</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="choix" value="jet" id="condi_jet" class="mr-2">
                            <label for="condi_jet" class="text-sm">BTL consigné / Emb jetable</label>
                        </div>
                    </div>
                    <div class="mb-4" id="consignation_field_add">
                        <label for="diff" class="block text-sm font-medium">Prix consignation</label>
                        <input type="number" name="diff" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="prix_vente" class="block text-sm font-medium">Prix de gros unité</label>
                            <input type="number" name="prix_vente" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>
                        <div>
                            <label for="prix_conditionne" class="block text-sm font-medium">Prix de gros cageot/pack <span class="text-red-500">*</span></label>
                            <input type="number" name="prix_conditionne" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="prix_gros" class="block text-sm font-medium">Prix détails unité</label>
                            <input type="number" name="prix_gros" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>
                        <div>
                            <label for="quantite" class="block text-sm font-medium">Quantité initiale en cageot</label>
                            <input type="number" name="quantite" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>
                        <div>
                            <label for="quantite_unite" class="block text-sm font-medium">Quantité initiale en unité</label>
                            <input type="number" name="quantite_unite" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('addArticleModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function openEditModal(modalId) {
        openModal(modalId);
    }

    function openDeleteModal(modalId) {
        openModal(modalId);
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function toggleSortDropdown() {
        document.getElementById('sortDropdown').classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des radios dans le modal d'ajout
        const choixRadios = document.querySelectorAll('input[name="choix"]');
        choixRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const consignationField = document.getElementById('consignation_field_add');
                consignationField.style.display = this.value === 'jet' ? 'block' : 'none';
            });
        });

        // Gestion des radios dans les modals d'édition
        document.querySelectorAll('[id^="editArticleModal"]').forEach(modal => {
            const id = modal.id.replace('editArticleModal', '');
            const radios = modal.querySelectorAll(`input[name="choix_${id}"]`);
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const reiniDiv = modal.querySelector(`#reini_div_${id}`);
                    if (reiniDiv) {
                        reiniDiv.style.display = this.value === 'pack' ? 'none' : 'flex';
                    }
                });
            });

            // Initialiser l'état au chargement
            const checkedRadio = modal.querySelector(`input[name="choix_${id}"]:checked`);
            const reiniDiv = modal.querySelector(`#reini_div_${id}`);
            if (checkedRadio && checkedRadio.value === 'pack' && reiniDiv) {
                reiniDiv.style.display = 'none';
            }
        });
    });
    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.add('hidden');
            }
        });
    });
</script>
@endsection