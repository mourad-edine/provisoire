@extends('layouts.AdminLayout')

@section('title', 'Gestion des Achats')

@section('content')
<div class="mx-auto">
    <!-- Navigation Tabs -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="w-full">
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                <!-- En-tête avec titre -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-cog mr-3 text-blue-600"></i>
                        Menu
                    </h3>
                </div>

                <!-- Grille des actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    <!-- Carte Détails commande -->
                    <a href="{{ route('achat.commande') }}"
                        class="group bg-white border-2 border-gray-200 hover:border-blue-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-300">
                                <i class="fas fa-file-alt text-blue-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Listes par commandes</h4>
                                <p class="text-xs text-gray-500">Voir les informations détaillées</p>
                            </div>
                        </div>
                    </a>

                    <!-- Carte Historique paiements -->
                    <a href="{{ route('achat.liste') }}"
                        class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                <i class="fas fa-history text-green-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Listes achats</h4>
                                <p class="text-xs text-gray-500">Consulter l'historique</p>
                            </div>
                        </div>
                    </a>

                    <!-- Carte Articles à rendre -->
                    <a href="{{ route('achat.page') }}"
                        class="group bg-white border-2 border-gray-200 hover:border-amber-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                <i class="fas fa-shopping-cart text-amber-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors">Nouvel achat</h4>
                                <p class="text-xs text-gray-500">Acheter</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden mb-6">
        <div class="p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-t-xl">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-blue-500"></i>Filtres de recherche
            </h2>
            <form method="GET" action="{{ route('achat.commande') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Nom|Numéro commande</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="pl-10 mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}"
                            class="pl-10 mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}"
                            class="pl-10 mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
                <div>
                    <label for="tri" class="block text-sm font-medium text-gray-700 mb-2">Trier par date</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-sort-amount-down text-gray-400"></i>
                        </div>
                        <select name="tri" id="tri"
                            class="pl-10 mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white">
                            <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                            <option value="asc" {{ request('tri') == 'asc' ? 'selected' : '' }}>Croissant</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2.5 px-4 rounded-lg shadow-sm hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center justify-center transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <i class="fa fa-filter mr-2"></i>Appliquer
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="p-5">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-5 rounded-md flex items-center" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div>
                    <p class="font-medium text-green-700">Succès!</p>
                    <p class="text-green-600">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="overflow-x-auto shadow-sm border border-gray-200">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-2 px-4 text-left font-medium">ID</th>
                            <th class="py-2 px-4 text-left font-medium">Numéro commande</th>
                            <th class="py-2 px-4 text-left font-medium">Fournisseur</th>
                            <th class="py-2 px-4 text-left font-medium">Date commande</th>
                            <th class="py-2 px-4 text-center font-medium">Nombre d'achat</th>
                            <th class="py-2 px-4 text-right font-medium">Total</th>
                            <th class="py-2 px-4 text-center font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($commandes as $commande)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 px-4 font-mono text-blue-600">C-{{ $commande->id }}</td>
                            <td class="py-3 px-4">{{ $commande->numero ? $commande->numero : 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $commande->fournisseur ? $commande->fournisseur->nom : 'Non spécifié' }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-medium">
                                    {{ $commande->achats_count }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-semibold text-green-700">{{ number_format($commande->achats_sum_prix, 0, ',', ' ') }} Ar</td>
                            <td class="py-3 px-4">
                                <!-- Menu déroulant -->
                                <div class="relative inline-block text-left">
                                    <button type="button"
                                        class="inline-flex justify-center ml-20 w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors duration-200"
                                        onclick="toggleDropdown('dropdown-commande-{{ $commande->id }}')">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <!-- Menu déroulant -->
                                    <div id="dropdown-commande-{{ $commande->id }}"
                                        class="hidden absolute right-0 z-50 mt-1 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none border border-gray-200">
                                        <div class="py-2">
                                            <!-- Voir les détails -->
                                            <a href="{{ route('achat.commande.detail', ['id' => $commande->id]) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                                <i class="fas fa-eye mr-3 text-blue-500 w-4"></i>
                                                Voir les détails
                                            </a>

                                            <!-- Imprimer -->
                                            <a href="{{ route('pdf.achat', ['id' => $commande->id]) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">
                                                <i class="fas fa-print mr-3 text-gray-500 w-4"></i>
                                                Imprimer
                                            </a>

                                            <!-- Séparateur -->
                                            <div class="border-t border-gray-100 my-1"></div>

                                            <!-- Supprimer -->
                                            <button type="button"
                                                onclick="openDeleteModal({{ $commande->id }}, '{{ $commande->numero ?: 'C-' . $commande->id }}')"
                                                class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-150 w-full text-left">
                                                <i class="fas fa-trash-alt mr-3 w-4"></i>
                                                Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 py-5">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                    <p class="font-medium">Aucune donnée trouvée</p>
                                    <p class="text-sm mt-1">Aucune commande ne correspond à vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $commandes->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center h-full w-full hidden z-50 transition-opacity duration-300">
    <div class="relative mx-auto p-6 border max-w-[400px] w-[90%] bg-white shadow-xl rounded-lg transform transition-all duration-300">
        <div class="text-center">
            <!-- Icône d'alerte -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            
            <!-- Titre et message -->
            <h3 class="text-lg font-semibold text-gray-900 mt-4">Confirmer la suppression</h3>
            <div class="mt-3 px-4 py-2">
                <p class="text-sm text-gray-600">
                    Êtes-vous sûr de vouloir supprimer la commande <span id="commandeNom" class="font-semibold"></span> ?
                </p>
                <p class="text-xs text-red-600 mt-2 flex items-center justify-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Cette action est irréversible et supprimera tous les achats associés.
                </p>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-center gap-4 mt-6">
                <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-150 flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-150 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour ouvrir/fermer le menu déroulant
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        menu.classList.toggle('hidden');

        // Fermer les autres menus ouverts
        document.querySelectorAll('[id^="dropdown-commande-"]').forEach(otherMenu => {
            if (otherMenu.id !== menuId) {
                otherMenu.classList.add('hidden');
            }
        });

        // Empêcher la propagation pour éviter la fermeture immédiate
        event.stopPropagation();
    }

    // Fermer les menus quand on clique ailleurs
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative.inline-block')) {
            document.querySelectorAll('[id^="dropdown-commande-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Fermer le menu quand une option est cliquée
    document.addEventListener('click', function(event) {
        if (event.target.closest('[id^="dropdown-commande-"] a, [id^="dropdown-commande-"] button')) {
            document.querySelectorAll('[id^="dropdown-commande-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Gestion du modal de suppression
    function openDeleteModal(commandeId, commandeNom) {
        const modal = document.getElementById('deleteModal');
        const commandeNomElement = document.getElementById('commandeNom');
        const deleteForm = document.getElementById('deleteForm');
        
        // Mettre à jour le nom de la commande
        commandeNomElement.textContent = commandeNom;
        
        // Mettre à jour l'action du formulaire
        deleteForm.action = "{{ route('delete.achat', ['id' => ':id']) }}".replace(':id', commandeId);
        
        // Afficher le modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    });

    // Fermer le modal avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

<style>
    .relative.inline-block {
        position: relative;
    }

    [id^="dropdown-commande-"] {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
    }

    /* Animation d'apparition */
    [id^="dropdown-commande-"]:not(.hidden) {
        animation: fadeInScale 0.2s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-5px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Style pour les icônes dans le menu */
    .py-2 a,
    .py-2 button {
        transition: all 0.2s ease;
    }

    .py-2 a:hover,
    .py-2 button:hover {
        transform: translateX(2px);
    }

    /* Animation pour le modal */
    #deleteModal {
        transition: all 0.3s ease;
    }

    /* Styles personnalisés pour améliorer l'apparence */
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23374151'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }

    tr:last-child {
        border-bottom: none;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style-type: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 0.25rem;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border: 1px solid #D1D5DB;
        color: #4B5563;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .pagination li a:hover {
        background-color: #E5E7EB;
    }

    .pagination li.active span {
        background-color: #3B82F6;
        color: white;
        border-color: #3B82F6;
    }
</style>
@endsection