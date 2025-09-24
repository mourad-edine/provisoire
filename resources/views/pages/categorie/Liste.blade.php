@extends('layouts.AdminLayout')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Card principale -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <!-- En-tête de la card -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-3 mb-3 sm:mb-0">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-th-list text-xl text-indigo-600"></i>
                </div>
                <div>
                    <h5 class="text-2xl font-bold text-gray-900">GESTION DES CATÉGORIES</h5>
                    <p class="text-sm text-gray-600 mt-1">Total : {{ $categories->total() }} catégorie(s)</p>
                </div>
            </div>
            <button onclick="openModal('addModal')"
                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter une catégorie
            </button>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white px-6 py-4 border-b border-gray-100">
            <form action="{{ route('categorie.liste') }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-start lg:items-center">
                @csrf
                <!-- Barre de recherche -->
                <div class="relative flex-1 w-full lg:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" placeholder="Rechercher une catégorie..."
                        value="{{ old('search', request('search')) }}"
                        class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200">
                </div>

                <!-- Tri -->
                <div class="relative">
                    <button type="button" onclick="toggleDropdown('sortDropdown')"
                        class="flex items-center gap-2 px-4 py-3 border border-gray-300 rounded-xl text-sm hover:bg-gray-50 transition-all duration-200 font-medium">
                        <i class="fas fa-sort-amount-down"></i>
                        Trier par
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <ul id="sortDropdown" class="hidden absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-2xl w-48 z-20 overflow-hidden">
                        <li><button type="submit" name="sort" value="nom_asc" class="block w-full px-4 py-3 text-left hover:bg-indigo-50 text-sm font-medium border-b border-gray-100"><i class="fas fa-sort-alpha-down mr-2"></i>Nom (A-Z)</button></li>
                        <li><button type="submit" name="sort" value="nom_desc" class="block w-full px-4 py-3 text-left hover:bg-indigo-50 text-sm font-medium border-b border-gray-100"><i class="fas fa-sort-alpha-up mr-2"></i>Nom (Z-A)</button></li>
                        <li><button type="submit" name="sort" value="created_at_desc" class="block w-full px-4 py-3 text-left hover:bg-indigo-50 text-sm font-medium">Plus récent</button></li>
                    </ul>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit"
                    class="px-6 py-3 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    Appliquer
                </button>
            </form>
        </div>

        <!-- Tableau -->
        <div class="p-6 overflow-x-auto">
            <!-- Message de succès -->
            @if(session('success'))
            <div class="mb-6 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Table -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Référence</th>
                            <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Articles</th>
                            <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Création</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Mise à jour</th>
                            <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $categorie)
                        <tr class="hover:bg-gray-50 transition-all duration-150 group cursor-pointer">
                            <!-- ID -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold group-hover:text-indigo-600 transition-colors">
                                #{{ $categorie->id }}
                            </td>

                            <!-- Nom -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-gray-800 font-medium">
                                {{ $categorie->nom }}
                            </td>

                            <!-- Référence -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-gray-500">
                                {{ $categorie->reference ?? '<span class="text-gray-400 italic">Non définie</span>' }}
                            </td>

                            <!-- Nombre d'articles -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ $categorie->articles_count }}
                                </span>
                            </td>

                            <!-- Image -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-center text-gray-400">
                                <i class="fas fa-image text-lg opacity-50"></i>
                            </td>

                            <!-- Créé le -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-gray-600 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-plus text-gray-400"></i>
                                    {{ $categorie->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>

                            <!-- Modifié le -->
                            <td onclick="openModal('editModal-{{ $categorie->id }}')" 
                                class="px-6 py-4 text-gray-600 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-edit text-gray-400"></i>
                                    {{ $categorie->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Bouton Éditer -->
                                    <button onclick="openModal('editModal-{{ $categorie->id }}')"
                                        class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-all duration-200 border border-indigo-100 hover:border-indigo-200 shadow-sm hover:shadow-md">
                                        <i class="fas fa-edit"></i>
                                        <span class="hidden sm:inline">Éditer</span>
                                    </button>

                                    <!-- Bouton Supprimer -->
                                    <button onclick="openModal('deleteModal-{{ $categorie->id }}')"
                                        class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all duration-200 border border-red-100 hover:border-red-200 shadow-sm hover:shadow-md">
                                        <i class="fas fa-trash-alt"></i>
                                        <span class="hidden sm:inline">Supprimer</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal édition -->
                        <div id="editModal-{{ $categorie->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                        <i class="fas fa-edit"></i>
                                        Modifier la catégorie
                                    </h3>
                                </div>
                                <form action="{{ route('categorie.update', ['id' => $categorie->id]) }}" method="POST" class="p-6">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nom-{{ $categorie->id }}" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                                        <input type="text" name="nom" id="nom-{{ $categorie->id }}" value="{{ $categorie->nom }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200">
                                    </div>
                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" onclick="closeModal('editModal-{{ $categorie->id }}')" 
                                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                                            Annuler
                                        </button>
                                        <button type="submit" 
                                            class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                            Enregistrer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal suppression -->
                        <div id="deleteModal-{{ $categorie->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                                <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4 rounded-t-2xl">
                                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Confirmation de suppression
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="p-3 bg-red-100 rounded-full">
                                            <i class="fas fa-trash-alt text-red-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Êtes-vous sûr de vouloir supprimer cette catégorie ?</p>
                                            <p class="text-sm text-gray-600 mt-1">"<span class="font-bold text-red-600">{{ $categorie->nom }}</span>"</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" onclick="closeModal('deleteModal-{{ $categorie->id }}')" 
                                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                                            Annuler
                                        </button>
                                        <a href="{{ route('delete.categorie', ['id' => $categorie->id]) }}"
                                            class="px-6 py-2 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-xl hover:from-red-700 hover:to-orange-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                            Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 text-gray-500">
                                    <i class="fas fa-inbox text-4xl opacity-50"></i>
                                    <p class="text-lg font-medium">Aucune catégorie trouvée</p>
                                    <p class="text-sm">Commencez par ajouter votre première catégorie</p>
                                    <button onclick="openModal('addModal')"
                                        class="mt-2 px-6 py-2 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>Ajouter une catégorie
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination stylisée -->
            @if($categories->hasPages())
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Affichage de <span class="font-semibold">{{ $categories->firstItem() }}</span> à <span class="font-semibold">{{ $categories->lastItem() }}</span> sur <span class="font-semibold">{{ $categories->total() }}</span> résultats
                </div>
                
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    {{ $categories->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal ajout -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                Ajouter une catégorie
            </h3>
        </div>
        <form action="{{ route('categorie.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                <input type="text" name="nom" id="nom" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200"
                    placeholder="Entrez le nom de la catégorie">
            </div>
            
            <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
                <input type="checkbox" id="checkRef" name="checkRef" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="checkRef" class="text-sm font-medium text-gray-700">Ajouter une référence</label>
            </div>
            
            <div id="refContainer" class="hidden mb-4">
                <label for="categorie" class="block text-sm font-medium text-gray-700 mb-2">Référence</label>
                <input type="text" name="categorie" id="categorie"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200"
                    placeholder="Entrez la référence">
            </div>
            
            <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
                <input type="checkbox" id="checkImage" name="checkImage" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="checkImage" class="text-sm font-medium text-gray-700">Ajouter une image</label>
            </div>
            
            <div id="imageContainer" class="hidden mb-4">
                <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-2">Importer une image</label>
                <input type="file" name="prix_unitaire" id="prix_unitaire"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200">
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('addModal')" 
                    class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                    Annuler
                </button>
                <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-xl hover:from-green-700 hover:to-teal-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                    Ajouter la catégorie
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Style personnalisé pour la pagination */
    .pagination {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
    }
    
    .pagination .page-item {
        margin: 0;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border-color: #4f46e5;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
    }
    
    .pagination .page-item:not(.active) .page-link:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }
    
    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: #f9fafb;
        border-color: #e5e7eb;
        cursor: not-allowed;
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Fermer les dropdowns en cliquant à l'extérieur
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.dropdown-trigger')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
                dropdown.classList.add('hidden');
            });
        }
    });

    // Gestion des checkboxes
    document.addEventListener("DOMContentLoaded", () => {
        const checkImage = document.getElementById('checkImage');
        const checkRef = document.getElementById('checkRef');
        
        if (checkImage) {
            checkImage.addEventListener('change', function() {
                document.getElementById('imageContainer').classList.toggle('hidden', !this.checked);
            });
        }
        if (checkRef) {
            checkRef.addEventListener('change', function() {
                document.getElementById('refContainer').classList.toggle('hidden', !this.checked);
            });
        }
    });
</script>
@endsection