@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class=" mx-auto">
    <!-- Supplier Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gray-100 p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-truck text-xl text-gray-800 mr-2"></i>
                <h5 class="text-lg font-bold text-gray-800">FOURNISSEURS</h5>
            </div>
            <button class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600" onclick="openModal('addArticleModal')">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter fournisseur
            </button>
        </div>
        <div class="p-4 flex flex-wrap gap-4">
            <form action="{{ route('fournisseur.liste') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="relative">
                    <input type="text" name="search" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Rechercher..." value="{{ old('search', request('search')) }}">
                </div>
                <div class="relative">
                    <button type="button" class="border rounded-lg px-3 py-2 text-sm bg-white text-gray-600 hover:bg-gray-50 flex items-center" onclick="toggleSortDropdown()">
                        <i class="fas fa-sort mr-1"></i>Trier par
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
        </div>
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
                           <th class="p-2">id</th>
                            <th class="p-2">nom</th>
                            <th class="p-2">numero</th>
                            <th class="p-2">reference</th>
                            <th class="p-2">Dette fournisseur</th>
                            <th class="p-2">date creation</th>
                            <th class="p-2">options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fournisseurs as $fournisseur)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-5">{{ $fournisseur->id }}</td>
                            <td class="px-3 py-5">{{ $fournisseur->nom }}</td>
                            <td class="px-3 py-5">{{ $fournisseur->numero ? $fournisseur->numero : 'pas de numero' }}</td>
                            <td class="px-3 py-5">{{ $fournisseur->reference ? $fournisseur->reference : 'pas de reference' }}</td>
                            <td class="px-3 py-5">---</td>
                            <td class="px-3 py-5">{{ $fournisseur->date_entre }}</td>
                            <td class="px-3 py-5">
                                <a class="text-red-500 hover:text-red-700" href="#" onclick="openDeleteModal('supprimerArticleModal{{ $fournisseur->id }}')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div id="supprimerArticleModal{{ $fournisseur->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-md">
                                <div class="bg-gray-50 text-dark p-4 rounded-t-lg flex justify-between items-center">
                                    <h5 class="text-lg font-bold">Suppression</h5>
                                    <button onclick="closeModal('supprimerArticleModal{{ $fournisseur->id }}')" class="text-dark">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <p>Voulez-vous vraiment supprimer ce fournisseur ?</p>
                                    <input value="{{ $fournisseur->nom }}" type="hidden" name="nom" class="hidden">
                                </div>
                                <div class="p-4 bg-gray-100 rounded-b-lg flex justify-end gap-2">
                                    <button type="button" onclick="closeModal('supprimerArticleModal{{ $fournisseur->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                                    <a href="{{ route('delete.fournisseur', ['id' => $fournisseur->id]) }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Supprimer</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="p-4">
                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Pas de donnée trouvée
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $fournisseurs->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="bg-gray-50 text-dark p-4 rounded-t-lg flex justify-between items-center">
                <h5 class="text-lg font-bold">Ajouter un fournisseur</h5>
                <button onclick="closeModal('addArticleModal')" class="text-dark">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form action="{{ route('fournisseur.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-semibold text-gray-700">Nom fournisseur</label>
                        <input type="text" id="nom" name="nom" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="numero" class="block text-sm font-semibold text-gray-700">Numéro</label>
                        <input type="text" id="numero" name="numero" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="ref" name="ref" class="mr-2">
                            <label for="ref" class="text-sm text-gray-700">Ajouter une référence</label>
                        </div>
                    </div>
                    <div id="referenceContainer" class="mb-4 hidden">
                        <label for="reference" class="block text-sm font-semibold text-gray-700">Référence</label>
                        <input type="text" id="reference" name="reference" class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
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

    function openDeleteModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function toggleSortDropdown() {
        document.getElementById('sortDropdown').classList.toggle('hidden');
    }

    document.getElementById('ref').addEventListener('change', function() {
        document.getElementById('referenceContainer').classList.toggle('hidden', !this.checked);
    });
</script>
@endsection