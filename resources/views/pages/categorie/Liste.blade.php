@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="max-w-7xl mx-auto px-4">

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
                        <td class="px-4 py-2 flex items-center space-x-4">
                            <!-- Bouton Éditer -->
                            <button onclick="openModal('editModal-{{ $categorie->id }}')"
                                class="flex items-center gap-1 px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition">
                                <i class="fas fa-edit"></i>
                                <span class="hidden sm:inline">Éditer</span>
                            </button>

                            <!-- Bouton Supprimer -->
                            <button onclick="openModal('deleteModal-{{ $categorie->id }}')"
                                class="flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">
                                <i class="fas fa-trash-alt"></i>
                                <span class="hidden sm:inline">Supprimer</span>
                            </button>
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
                {{ $categories->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
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