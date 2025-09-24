<!DOCTYPE html>
<html lang="en">
@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gray-100 p-4 flex items-center">
                <i class="fas fa-glass-cheers text-xl mr-2"></i>
                <h5 class="text-lg font-bold text-gray-800">BOISSON</h5>
            </div>

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
                                <th class="p-3">ID</th>
                                <th class="p-3">Nom</th>
                                <th class="p-3">Catégorie</th>
                                <th class="p-3">P.Vente unité gros</th>
                                <th class="p-3">P.Vente cageot/pack</th>
                                <th class="p-3">Prix détails</th>
                                <th class="p-3">P.Achat</th>
                                <th class="p-3">Quantité</th>
                                <th class="p-3">Date</th>
                                <th class="p-3">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr class="hover:bg-gray-50 cursor-pointer">
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['id'] }}</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ \Illuminate\Support\Str::limit($article['nom'], 15) }}</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['categorie'] }}</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['prix_unitaire'] }} Ar</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['prix_conditionne'] }} Ar</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['prix_gros'] }} Ar</td>
                                <td class="p-3" onclick="openEditModal('editArticleModal{{ $article['id'] }}')">{{ $article['prix_achat'] }} Ar</td>
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
                                <td class="p-3">
                                    <button onclick="openEditModal('editArticleModal{{ $article['id'] }}')" class="text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal('supprimerModal{{ $article['id'] }}')" class="text-red-600 hover:text-red-800 ml-3">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
                                    <div class="bg-gray-800 text-white p-4 rounded-t-lg flex justify-between items-center">
                                        <h5 class="text-lg font-bold">Modifier articles</h5>
                                        <button onclick="closeModal('editArticleModal{{ $article['id'] }}')" class="text-white hover:text-gray-200">
                                            <i class="fas fa-times"></i>
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
                    </table>
                    <div class="mt-4">
                        {{ $articles->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Article Modal -->
        <div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-3xl">
                <div class="bg-gray-800 text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h5 class="text-lg font-bold">Ajouter un article</h5>
                    <button onclick="closeModal('addArticleModal')" class="text-white hover:text-gray-200">
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
</script>
@endsection