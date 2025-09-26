@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="max-w-10xl mx-auto px-4">

    <!-- Card principale -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="flex items-center justify-between bg-gray-100 px-4 py-3 border-b">
            <div class="flex items-center gap-2">
                <i class="fas fa-th-list text-lg text-gray-700"></i>
                <h5 class="text-lg font-bold text-gray-800">CATEGORIE</h5>
            </div>
            <button onclick="openModal('addModal')"
                class="bg-gray-700 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-800">
                Ajouter catégorie
            </button>
        </div>

        <!-- Filtres -->
        <div class="flex flex-wrap items-center gap-2 px-4 py-3">
            <form action="{{ route('categorie.liste') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @csrf
                <input type="text" name="search" placeholder="Rechercher..."
                    value="{{ old('search', request('search')) }}"
                    class="px-3 py-1.5 border rounded-md text-sm focus:ring focus:ring-indigo-200">

                <!-- Tri -->
                <div class="relative">
                    <button type="button" onclick="toggleDropdown('sortDropdown')"
                        class="flex items-center px-3 py-1.5 border rounded-md text-sm hover:bg-gray-100">
                        <i class="fas fa-sort mr-1"></i> Trier par
                    </button>
                    <ul id="sortDropdown" class="hidden absolute bg-white border rounded-md mt-1 shadow w-40 z-10">
                        <li><button type="submit" name="sort" value="nom_asc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Nom (A-Z)</button></li>
                        <li><button type="submit" name="sort" value="nom_desc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Nom (Z-A)</button></li>
                        <li><button type="submit" name="sort" value="prix_asc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Prix (Croissant)</button></li>
                        <li><button type="submit" name="sort" value="prix_desc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Prix (Décroissant)</button></li>
                        <li><button type="submit" name="sort" value="stock_asc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Stock (Croissant)</button></li>
                        <li><button type="submit" name="sort" value="stock_desc" class="block w-full px-3 py-1.5 text-left hover:bg-gray-100">Stock (Décroissant)</button></li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="p-4 overflow-x-auto">
            @if(session('success'))
            <div class="mb-3 p-2 text-sm text-green-800 bg-green-100 border border-green-200 rounded">
                {{ session('success') }}
            </div>
            @endif

            <table class="w-full text-sm text-center border border-gray-300 rounded">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-2 py-2">ID</th>
                        <th class="px-2 py-2">Nom</th>
                        <th class="px-2 py-2">Référence</th>
                        <th class="px-2 py-2">Articles</th>
                        <th class="px-2 py-2">Image</th>
                        <th class="px-2 py-2">Création</th>
                        <th class="px-2 py-2">Mise à jour</th>
                        <th class="px-2 py-2">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                    <tr class="hover:bg-gray-50 cursor-pointer border-b border-gray-200">
                        <!-- ID -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-700 font-medium">
                            {{ $categorie->id }}
                        </td>

                        <!-- Nom -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-700">
                            {{ $categorie->nom }}
                        </td>

                        <!-- Référence -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-500 italic">
                            {{ $categorie->reference ?? 'Pas de référence' }}
                        </td>

                        <!-- Nombre d'articles -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-center text-gray-700">
                            {{ $categorie->articles_count }}
                        </td>

                        <!-- Colonne vide (si prévue pour autre chose) -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-400">
                            -
                        </td>

                        <!-- Créé le -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-600 text-sm">
                            {{ $categorie->created_at }}
                        </td>

                        <!-- Modifié le -->
                        <td onclick="openModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 text-gray-600 text-sm">
                            {{ $categorie->updated_at }}
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-2">
                            <!-- Menu déroulant -->
                            <div class="relative inline-block text-left">
                                <button type="button"
                                    class="inline-flex justify-center w-8 h-8 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100  transition-all duration-200"
                                    onclick="toggleDropdown('dropdown-categorie-{{ $categorie->id }}')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <!-- Menu déroulant -->
                                <div id="dropdown-categorie-{{ $categorie->id }}"
                                    class="hidden absolute right-0 z-50 mt-1 w-48 origin-top-right rounded-lg bg-white shadow-xl ring-1 ring-black ring-opacity-5 border border-gray-200">
                                    <div class="py-2">
                                        <!-- Option Éditer -->
                                        <button onclick="openModal('editModal-{{ $categorie->id }}')"
                                            class="flex items-center w-full px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150 group">
                                            <i class="fas fa-edit mr-3 text-indigo-500 group-hover:scale-110 transition-transform duration-200"></i>
                                            <span>Éditer</span>
                                        </button>

                                        <!-- Option Supprimer -->
                                        <button onclick="openModal('deleteModal-{{ $categorie->id }}')"
                                            class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-150 group">
                                            <i class="fas fa-trash-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                            <span>Supprimer</span>
                                        </button>

                                        <!-- Séparateur -->
                                        <div class="border-t border-gray-100 my-1"></div>

                                        <!-- Options supplémentaires -->
                                        <button class="flex items-center w-full px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150 group">
                                            <i class="fas fa-eye mr-3 text-blue-500 group-hover:scale-110 transition-transform duration-200"></i>
                                            <span>Voir les articles</span>
                                        </button>

                                       
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Modal édition -->
                        <div id="editModal-{{ $categorie->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                <h3 class="text-lg font-semibold mb-4">Modifier catégorie</h3>
                                <form action="{{ route('categorie.update', ['id' => $categorie->id]) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nom-{{ $categorie->id }}" class="block text-sm font-medium">Nom catégorie</label>
                                        <input type="text" name="nom" id="nom-{{ $categorie->id }}" value="{{ $categorie->nom }}" required
                                            class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
                                    </div>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" onclick="closeModal('editModal-{{ $categorie->id }}')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal suppression -->
                        <div id="deleteModal-{{ $categorie->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                <h3 class="text-lg font-semibold mb-4 text-red-600">Suppression</h3>
                                <p class="mb-4">Voulez-vous vraiment supprimer cette catégorie <span class="font-bold">{{ $categorie->nom }}</span> ?</p>
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" onclick="closeModal('deleteModal-{{ $categorie->id }}')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                                    <a href="{{ route('delete.categorie', ['id' => $categorie->id]) }}"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                    <tr>
                        <td colspan="8" class="py-3">
                            <div class="p-2 text-sm text-yellow-800 bg-yellow-100 border border-yellow-200 rounded">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Pas de donnée trouvée
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $categories->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal ajout -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Ajouter une catégorie</h3>
        <form action="{{ route('categorie.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nom" class="block text-sm font-medium">Nom catégorie</label>
                <input type="text" name="nom" id="nom" required
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
            </div>
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" id="checkRef" name="checkRef" class="rounded border-gray-300">
                <label for="checkRef">Ajouter une référence</label>
            </div>
            <div id="refContainer" class="hidden mb-3">
                <label for="categorie" class="block text-sm font-medium">Référence</label>
                <input type="text" name="categorie" id="categorie"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
            </div>
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" id="checkImage" name="checkImage" class="rounded border-gray-300">
                <label for="checkImage">Ajouter une image</label>
            </div>
            <div id="imageContainer" class="hidden mb-3">
                <label for="prix_unitaire" class="block text-sm font-medium">Importer image</label>
                <input type="file" name="prix_unitaire" id="prix_unitaire"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ajouter</button>
            </div>
        </form>
    </div>
</div>
<script>
// Fonction pour ouvrir/fermer le menu déroulant
function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    menu.classList.toggle('hidden');
    
    // Fermer les autres menus ouverts
    document.querySelectorAll('[id^="dropdown-categorie-"]').forEach(otherMenu => {
        if (otherMenu.id !== menuId) {
            otherMenu.classList.add('hidden');
        }
    });
    
    // Empêcher la propagation
    event.stopPropagation();
}

// Fermer les menus quand on clique ailleurs
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative.inline-block')) {
        document.querySelectorAll('[id^="dropdown-categorie-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

// Vos fonctions existantes
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    // Fermer les menus déroulants
    document.querySelectorAll('[id^="dropdown-categorie-"]').forEach(menu => {
        menu.classList.add('hidden');
    });
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>

<style>
/* Animation pour le menu déroulant */
[id^="dropdown-categorie-"]:not(.hidden) {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Effet de survol amélioré */
.hover\:bg-gradient-to-r:hover {
    background-size: 200% 100%;
    background-position: right center;
    transition: all 0.3s ease;
}
</style>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Checkbox gestion affichage
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