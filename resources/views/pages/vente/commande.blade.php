@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Onglets de navigation -->
    <!-- <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-8">
            <a href="#" class="py-4 px-1 border-b-2 border-blue-600 text-blue-600 font-medium text-sm flex items-center">
                <i class="fas fa-list-alt mr-2"></i>Listes par commandes
            </a>
          
            <a href="#" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center">
                <i class="fas fa-cart-plus mr-2"></i>Nouvelle vente
            </a>
        </nav>
    </div> -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="w-full">
            <div class="bg-white shadow-lg  border border-gray-100 overflow-hidden">
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
                    <a href="{{ route('commande.liste.vente') }}"
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
                    <a href="{{ route('sortie.stat') }}"
                        class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                <i class="fas fa-history text-green-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Historique</h4>
                                <p class="text-xs text-gray-500">Consulter l'historique</p>
                            </div>
                        </div>
                    </a>

                    <!-- Carte Articles à rendre -->
                    <a href="{{ route('vente.page') }}"
                        class="group bg-white border-2 border-gray-200 hover:border-amber-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                <i class="fas fa-cart-plus text-amber-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors"> Nouvelle vente
                                </h4>
                                <p class="text-xs text-gray-500">Vendre</p>
                            </div>
                        </div>
                    </a>

                    <!-- Carte Compte rendu -->

                </div>

                <!-- Barre de statut en bas -->

            </div>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="bg-white  shadow-lg border border-gray-200">
        <!-- En-tête avec formulaire de recherche -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-lg">
            <form method="GET" action="#" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nom | Numéro commande</label>
                    <input type="text" id="search" name="search" value=""
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" id="date_debut" name="date_debut" value=""
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" id="date_fin" name="date_fin" value=""
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="tri" class="block text-sm font-medium text-gray-700 mb-1">Trier par date</label>
                    <select name="tri" id="tri"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="desc" selected>Décroissant</option>
                        <option value="asc">Croissant</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
        <div id="successMessage" class="bg-green-50 border-l-4 border-green-400 p-4 mx-6 mt-4 rounded">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                    <span class="text-green-700 text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('successMessage').remove()" 
                        class="text-green-400 hover:text-green-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div id="errorMessage" class="bg-red-50 border-l-4 border-red-400 p-4 mx-6 mt-4 rounded">
            <div class="flex items-center justify-between">
                <div class="flex items
-center">
                    <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                    <span class="text-red-700 text-sm">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('errorMessage').remove()" 
                        class="text-red-400 hover:text-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

        </div>
        @endif

        <!-- Contenu du tableau -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date commande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Opérations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Sous-total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Consignation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">État</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($commandes as $commande)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer clickable-row"
                            data-href="{{ route('commande.liste.vente.detail', ['id' => $commande->id]) }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">C-{{ $commande->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $commande->client ? $commande->client->nom : 'Client occasionnel' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $commande->created_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $commande->ventes_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ number_format($commande->ventes_total, 0, ',', ' ') }} Ar
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($commande->etat_client == 1)
                                <span class="font-semibold text-red-600">À rendre</span>
                                @elseif($commande->etat_client == 2)
                                <span class="font-semibold text-red-600">À disposition</span>
                                @else
                                <span class="text-gray-900">
                                    {{ number_format(
                                        $commande->ventes_consignation_sum_prix 
                                        + $commande->ventes_consignation_sum_prix_cgt 
                                        + optional($commande->conditionnements)->sum('nombre_cageot') * $cgt, 
                                        0, ',', ' '
                                    ) }} Ar
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                @if($commande->etat_client == 1)
                                {{ number_format($commande->ventes_total, 0, ',', ' ') }} Ar
                                @else
                                {{ number_format(
                                    $commande->ventes_total 
                                    + $commande->ventes_consignation_sum_prix 
                                    + $commande->ventes_consignation_sum_prix_cgt 
                                    + (optional($commande->conditionnements)->sum('nombre_cageot') * $cgt), 
                                    0, ',', ' '
                                ) }} Ar
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($commande->etat_commande == 'payé')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Payé
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Non payé
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Menu déroulant avec trois points -->
                                <div class="relative inline-block text-left">
                                    <button type="button" 
                                            class="options-toggle inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 transition-colors"
                                            onclick="toggleOptionsMenu('{{ $commande->id }}')">
                                        <i class="fas fa-ellipsis-v text-gray-500"></i>
                                    </button>
                                    
                                    <!-- Menu déroulant -->
                                    <div id="options-menu-{{ $commande->id }}" 
                                         class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            <a href="{{ route('commande.liste.vente.detail', ['id' => $commande->id]) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-eye mr-3 text-blue-500"></i>
                                                Voir détails
                                            </a>
                                            <a href="{{ route('pdf.download', ['id' => $commande->id]) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-print mr-3 text-yellow-500"></i>
                                                Imprimer facture
                                            </a>
                                            <button onclick="openDeleteModal('{{ $commande->id }}')" 
                                                    class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                <i class="fas fa-trash mr-3 text-red-500"></i>
                                                Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center text-gray-400">
                                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                    <p class="text-lg">Aucune donnée trouvée</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($commandes->hasPages())
                <div class="mt-6 flex justify-end">
                    <div class="bg-white px-4 py-3 border border-gray-200 rounded-lg">
                        {{ $commandes->links('pagination::tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
            <button type="button" onclick="closeDeleteModal()" 
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <div class="px-6 py-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <p id="modalMessage" class="text-sm text-gray-700">
                        Voulez-vous supprimer cette commande ? Cette action est irréversible.
                    </p>
                </div>
            </div>
        </div>

        <!-- Pied du modal -->
        <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
            <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                Annuler
            </button>
            <form id="deleteForm" method="POST" action="{{ route('delete.commande') }}" class="inline">
                @csrf
                <input type="hidden" name="commande_id" id="commande_id">
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Gestion des menus déroulants
    function toggleOptionsMenu(commandeId) {
        const menu = document.getElementById(`options-menu-${commandeId}`);
        const isVisible = !menu.classList.contains('hidden');
        
        // Fermer tous les autres menus
        document.querySelectorAll('[id^="options-menu-"]').forEach(otherMenu => {
            otherMenu.classList.add('hidden');
        });
        
        // Ouvrir/fermer le menu actuel
        if (!isVisible) {
            menu.classList.remove('hidden');
        }
        
        // Empêcher la propagation pour éviter de fermer immédiatement
        event.stopPropagation();
    }

    // Fermer les menus quand on clique ailleurs
    document.addEventListener('click', function() {
        document.querySelectorAll('[id^="options-menu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Gestion des lignes cliquables
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', (e) => {
            // Ne pas rediriger si on clique sur le menu déroulant
            if (!e.target.closest('.options-toggle') && !e.target.closest('[id^="options-menu-"]')) {
                window.location.href = row.dataset.href;
            }
        });
    });

    // Gestion du modal de suppression
    window.openDeleteModal = function(id) {
        document.getElementById('commande_id').value = id;
        document.getElementById('modalMessage').textContent = 
            `Voulez-vous supprimer la commande C-${id} ? Cette action est irréversible.`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Fermer le modal avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

<style>
    .options-toggle {
        transition: all 0.2s ease;
    }
    
    .options-toggle:hover {
        background-color: #f3f4f6;
        transform: scale(1.1);
    }
    
    .clickable-row {
        transition: background-color 0.2s ease;
    }
    
    .clickable-row:hover {
        background-color: #f9fafb;
    }
</style>

@endsection