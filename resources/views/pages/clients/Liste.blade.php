@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class=" mx-auto">
    <!-- Client Table -->
    <div class="bg-white shadow-lg rounded-lg">
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
        <div class="p-4 bg-white rounded-lg shadow-sm">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <div class=" bg-white rounded-lg border border-gray-200">
                <table class="w-full text-center">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="p-3 font-semibold text-gray-700">ID</th>
                            <th class="p-3 font-semibold text-gray-700">Nom</th>
                            <th class="p-3 font-semibold text-gray-700">Numéro</th>
                            <th class="p-3 font-semibold text-gray-700">Référence</th>
                            <th class="p-3 font-semibold text-gray-700">Bouteille(s)</th>
                            <th class="p-3 font-semibold text-gray-700">Cageot(s)</th>
                            <th class="p-3 font-semibold text-gray-700">Créance BTL+CGT</th>
                            <th class="p-3 font-semibold text-gray-700">Reste à payer</th>
                            <th class="p-3 font-semibold text-gray-700">Commande non payé</th>
                            <th class="p-3 font-semibold text-gray-700">Date création</th>
                            <th class="p-3 font-semibold text-gray-700">Options</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 client-row" data-client-id="{{ $client['id'] }}" data-client-nom="{{ $client['nom'] }}" data-client-reference="{{ $client['reference'] }}" data-client-numero="{{ $client['numero'] }}">
                            <!-- Colonnes cliquables pour le modal -->
                            <td class="p-3 clickable-cell text-gray-900">{{ $client['id'] }}</td>
                            <td class="p-3 clickable-cell text-gray-900">{{ $client['nom'] }}</td>
                            <td class="p-3 clickable-cell text-gray-700">{{ $client['numero'] ? $client['numero'] : 'pas de numero' }}</td>
                            <td class="p-3 clickable-cell text-gray-700">{{ $client['reference'] ? $client['reference'] : 'pas de reference' }}</td>
                            <td class="p-3 clickable-cell text-gray-900">{{ $client['sum_btl'] }}</td>
                            <td class="p-3 clickable-cell text-gray-900">{{ $client['sum_cgt'] + $client['conditionnement'] }}</td>
                            <td class="p-3 clickable-cell text-gray-900 font-medium">{{ number_format($client['consignation_sum_prix'] + $client['consignation_sum_prix_cgt'] + ($client['conditionnement'] * $cgt), 0, ',', ' ') }} Ar</td>
                            <td class="p-3 clickable-cell text-gray-900 font-medium">{{ $client['reste_a_payer'] }} Ar</td>
                            <td class="p-3 clickable-cell">
                                <span class="font-bold {{ $client['nombre_com_no_paye'] > 0 ? 'text-red-500' : 'text-green-500' }}">
                                    {{ $client['nombre_com_no_paye'] }}
                                </span>
                            </td>
                            <td class="p-3 clickable-cell text-gray-700">{{ $client['created_at'] }}</td>

                            <!-- Colonne d'actions avec menu déroulant -->
                            <td class="p-3 relative">
                                <button class="options-btn text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors" data-client-id="{{ $client['id'] }}">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <!-- Menu déroulant -->
                                <div class="options-menu absolute right-3 top-full mt-1 w-48 bg-white rounded-lg shadow-lg z-10 hidden border border-gray-200">
                                    <div class="py-2">
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 edit-client" data-client-id="{{ $client['id'] }}">
                                            <i class="fas fa-edit mr-3 text-blue-500"></i>Modifier
                                        </a>
                                        
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 payment-details" data-client-id="{{ $client['id'] }}">
                                            <i class="fas fa-credit-card mr-3 text-purple-500"></i>Détails
                                        </a>
                                        <a href="#" onclick="openDeleteModal('supprimerArticleModal{{ $client['id'] }}')" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                            <i class="fas fa-trash-alt mr-3"></i>Supprimer
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de suppression -->
                        <div id="supprimerArticleModal{{ $client['id'] }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-md">
                                <div class="bg-gray-50 p-4 rounded-t-lg border-b border-gray-200 flex justify-between items-center">
                                    <h5 class="text-lg font-semibold text-gray-800">Suppression</h5>
                                    <button onclick="closeModal('supprimerArticleModal{{ $client['id'] }}')" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-700">Voulez-vous vraiment supprimer ce client ?</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-b-lg flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('supprimerArticleModal{{ $client['id'] }}')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Annuler</button>
                                    <a href="{{ route('delete.client', ['id' => $client['id']]) }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">Supprimer</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="11" class="p-6">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Pas de données trouvées
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-200">
                    {{ $clients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

        <!-- Modal de détails et édition du client -->
        <div id="clientDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
                <div class="bg-gray-50 p-4 rounded-t-lg border-b border-gray-200 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-gray-800">Modifier le client</h5>
                    <button onclick="closeModal('clientDetailsModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="clientEditForm" method="POST" class="p-6">
                    @csrf
                    <div id="clientDetailsContent" class="space-y-4">
                        <!-- Les détails seront chargés ici via JavaScript -->
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('clientDetailsModal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Annuler</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Gestion du modal de détails
            document.querySelectorAll('.clickable-cell').forEach(cell => {
                cell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const clientId = this.closest('tr').getAttribute('data-client-id');
                    const nom = this.closest('tr').getAttribute('data-client-nom');
                    const reference = this.closest('tr').getAttribute('data-client-reference');
                    const numero = this.closest('tr').getAttribute('data-client-numero');
                    openClientDetailsModal(clientId , nom , numero , reference, '0' , '0');
                });
            });

            // Gestion du menu d'options
            document.querySelectorAll('.options-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const menu = this.nextElementSibling;

                    // Fermer tous les autres menus ouverts
                    document.querySelectorAll('.options-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });

                    // Ouvrir/fermer le menu actuel
                    menu.classList.toggle('hidden');
                });
            });

            // Gestion du bouton modifier
            document.querySelectorAll('.edit-client').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const clientId = this.getAttribute('data-client-id');
                    openClientEditModal(clientId);
                });
            });

            // Fermer les menus quand on clique ailleurs
            document.addEventListener('click', function() {
                document.querySelectorAll('.options-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });

            function openClientEditModal(clientId , nom , numero , reference ,sum_btl , sum_cgt) {
                // Simulation de données - à remplacer par un appel AJAX réel
                const clientData = {
                    id: clientId,
                    nom: nom,
                    numero: numero,
                    reference: reference,
                    sum_btl: sum_btl,
                    sum_cgt: sum_cgt,
                    conditionnement: "5"
                };

                const content = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                <input type="text" value="${clientData.id}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="nom" value="${clientData.nom}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro</label>
                <input type="text" name="numero" value="${clientData.numero}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                <input type="text" name="reference" value="${clientData.reference}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bouteilles</label>
                <input type="number" name="sum_btl" value="${clientData.sum_btl}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cageots</label>
                <input type="number" name="sum_cgt" value="${clientData.sum_cgt}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    `;

                document.getElementById('clientDetailsContent').innerHTML = content;
                document.getElementById('clientEditForm').action = '/clients/' + clientId + '/update';
                document.getElementById('clientDetailsModal').classList.remove('hidden');
            }

            function openClientDetailsModal(clientId) {
                openClientEditModal(clientId); // Même fonctionnalité pour l'instant
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            // Gestion de la soumission du formulaire
            document.getElementById('clientEditForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // Ici vous ajouterez la logique AJAX pour sauvegarder les modifications
                alert('Modifications enregistrées pour le client');
                closeModal('clientDetailsModal');
            });
        </script>

        <style>
            .clickable-cell {
                transition: background-color 0.2s;
                cursor: pointer;
            }

            .clickable-cell:hover {
                background-color: #f8fafc;
            }

            .options-menu {
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

            .table-container {
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
        </style>

        <!-- Add Client Modal -->
        <div id="addArticleModal" class="fixed inset-0  bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-md">
                <div class="bg-gray-50 text-dark p-4 rounded-t-lg flex justify-between items-center">
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