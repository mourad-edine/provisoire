@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class=" mx-auto">
    <!-- Client Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gray-100 p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-users text-xl text-gray-800 mr-2"></i>
                <h5 class="text-lg font-bold text-gray-800">CLIENTS</h5>
            </div>
            <button class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-600" onclick="openModal('addArticleModal')">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter client
            </button>
        </div>
        <div class="p-4 flex flex-wrap gap-4">
            <form action="{{ route('client.liste') }}" method="GET" class="flex flex-wrap gap-4">
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
                            <th class="p-2">bouteille(s)</th>
                            <th class="p-2">cageot(s)</th>
                            <th class="p-2">créance BTL+CGT</th>
                            <th class="p-2">Reste à payer</th>
                            <th class="p-2">Commande non payé</th>
                            <th class="p-2">date creation</th>
                            <th class="p-2">options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 cursor-pointer clickable-row" data-href="{{ route('client.commande', ['id' => $client['id']]) }}">
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['id'] }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['nom'] }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['numero'] ? $client['numero'] : 'pas de numero' }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['reference'] ? $client['reference'] : 'pas de reference' }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['sum_btl'] }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['sum_cgt'] + $client['conditionnement'] }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ number_format($client['consignation_sum_prix'] + $client['consignation_sum_prix_cgt'] + ($client['conditionnement'] * $cgt), 0, ',', ' ') }} Ar</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['reste_a_payer'] }} Ar</a></td>
                            <td class="px-3 py-5"><a class="font-bold {{ $client['nombre_com_no_paye'] > 0 ? 'text-red-500' : 'text-green-500' }} hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['nombre_com_no_paye'] }}</a></td>
                            <td class="px-3 py-5"><a class="text-gray-800 hover:text-blue-600" href="{{ route('client.commande', ['id' => $client['id']]) }}">{{ $client['created_at'] }}</a></td>
                            <td class="px-3 py-5">
                                <a class="text-gray-600 hover:text-gray-800" href="{{ route('client.commande', ['id' => $client['id']]) }}"><i class="fas fa-user-alt"></i></a>
                                <a class="text-red-500 hover:text-red-700 ml-3" href="#" onclick="openDeleteModal('supprimerArticleModal{{ $client['id'] }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div id="supprimerArticleModal{{ $client['id'] }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-md">
                                <div class="bg-gray-800 text-white p-4 rounded-t-lg flex justify-between items-center">
                                    <h5 class="text-lg font-bold">Suppression</h5>
                                    <button onclick="closeModal('supprimerArticleModal{{ $client['id'] }}')" class="text-white hover:text-gray-200">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <p>Voulez-vous vraiment supprimer ce client ?</p>
                                </div>
                                <div class="p-4 bg-gray-100 rounded-b-lg flex justify-end gap-2">
                                    <button type="button" onclick="closeModal('supprimerArticleModal{{ $client['id'] }}')" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                                    <a href="{{ route('delete.client', ['id' => $client['id']]) }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Supprimer</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="11" class="p-4">
                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Pas de donnée trouvée
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $clients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Client Modal -->
    <div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="bg-gray-800 text-white p-4 rounded-t-lg flex justify-between items-center">
                <h5 class="text-lg font-bold">Ajouter un client</h5>
                <button onclick="closeModal('addArticleModal')" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form action="{{ route('client.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-semibold text-gray-700">Nom client</label>
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

    $(document).ready(function() {
        $('.clickable-row').click(function(e) {
            if (!$(e.target).is('a, i, button')) {
                window.location = $(this).data('href');
            }
        });

        document.getElementById('ref').addEventListener('change', function() {
            document.getElementById('referenceContainer').classList.toggle('hidden', !this.checked);
        });
    });
</script>
@endsection