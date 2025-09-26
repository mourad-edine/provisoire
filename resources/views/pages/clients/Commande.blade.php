@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid px-4">
    <!-- Navigation par onglets -->
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
                    <a href="{{route('client.historique', ['id' => $client_id])}}"
                        class="group bg-white border-2 border-gray-200 hover:border-blue-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-300">
                                <i class="fas fa-file-alt text-blue-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Historique des payements</h4>
                                <p class="text-xs text-gray-500">Voir les informations détaillées</p>
                            </div>
                        </div>
                    </a>

                    <!-- Carte Historique paiements -->
                    <a href="{{ route('client.commande', ['id' => $client_id]) }}"
                        class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                <i class="fas fa-history text-green-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Commandes passées</h4>
                                <p class="text-xs text-gray-500">Consulter l'historique</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
   

    <!-- Formulaire de recherche -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="p-6">
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="hidden" name="client_id" value="{{ $client_id }}">

                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nom | N° commande</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Rechercher...">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <div class="relative">
                        <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <div class="relative">
                        <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label for="tri" class="block text-sm font-medium text-gray-700 mb-1">Trier par date</label>
                    <div class="relative">
                        <select name="tri" id="tri" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none">
                            <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                            <option value="asc" {{ request('tri') == 'asc' ? 'selected' : '' }}>Croissant</option>
                        </select>
                        <i class="fas fa-sort absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        <span>Rechercher</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des commandes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
            @endif
            
            <div class="overflow-x-auto  border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i> ID
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i> Client
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1"></i> Date commande
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-shopping-cart mr-1"></i> Nb achats
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-receipt mr-1"></i> Sous-total
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-boxes mr-1"></i> Consignation
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-calculator mr-1"></i> Total
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-1"></i> État
                            </th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                <i class="fas fa-cog mr-1"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($commandes as $commande)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 cursor-pointer" data-href="{{route('commande.liste.vente.detail', ['id' => $commande->id]) }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    C-{{$commande->id}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{$commande->client ? $commande->client->nom : 'Client passager'}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{$commande->created_at}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-800 font-medium">
                                    {{$commande->ventes_count}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{$commande->ventes_total }} Ar
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($commande->etat_client == 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> À rendre
                                </span>
                                @elseif($commande->etat_client == 2)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> À disposition
                                </span>
                                @else
                                {{ number_format(
                                        $commande->ventes_consignation_sum_prix 
                                        + $commande->ventes_consignation_sum_prix_cgt 
                                        + optional($commande->conditionnement)->nombre_cageot * $cgt, 
                                        0, ',', ' '
                                ) }} Ar
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                @if($commande->etat_client == 1)
                                {{ number_format($commande->ventes_total, 0, ',', ' ') }} Ar
                                @else
                                {{ number_format($commande->ventes_total + $commande->ventes_consignation_sum_prix + $commande->ventes_consignation_sum_prix_cgt + (optional($commande->conditionnement)->nombre_cageot * $cgt), 0, ',', ' ') }} Ar
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($commande->etat_commande == 'payé')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> {{$commande->etat_commande}}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Non payé
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{route('commande.liste.vente.detail', ['id' => $commande->id]) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{route('pdf.download' , ['id'=>$commande->id])}}" class="text-amber-600 hover:text-amber-900 transition-colors duration-200" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                    <p class="text-lg font-medium">Aucune donnée trouvée</p>
                                    <p class="text-sm mt-1">Aucune commande ne correspond à vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($commandes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{$commandes->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('tr[data-href]').click(function(e) {
            // Évite les conflits si on clique sur un lien ou un bouton
            if (!$(e.target).is('a, i, button') && !$(e.target).closest('a, button').length) {
                window.location = $(this).data('href');
            }
        });
    });
</script>
@endsection

@push('styles')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    
    .pagination li {
        margin: 0 0.25rem;
    }
    
    .pagination li a, 
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination li.active span {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
    
    .pagination li a:hover {
        background-color: #f3f4f6;
    }
</style>
@endpush