@extends('layouts.AdminLayout')

@section('title', 'Gestion des Achats')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête de section -->
    

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <ul class="flex" id="parametresTabs" role="tablist">
            <li class="flex-1">
                <a href="{{ route('achat.commande') }}" class="no-underline">
                    <div class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium border-b-2 transition-all duration-200 ease-in-out {{ request()->routeIs('achat.commande') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <i class="fas fa-list mr-2"></i>Listes par commandes
                    </div>
                </a>
            </li>
            <li class="flex-1">
                <a href="{{ route('achat.liste') }}" class="no-underline">
                    <div class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium border-b-2 transition-all duration-200 ease-in-out {{ request()->routeIs('achat.liste') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <i class="fas fa-shopping-cart mr-2"></i>Listes achats
                    </div>
                </a>
            </li>
            <li class="flex-1">
                <a href="{{ route('achat.page') }}" class="no-underline">
                    <div class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-200 ease-in-out hover:from-blue-600 hover:to-blue-700">
                        <i class="fas fa-cart-plus mr-2"></i>Nouvel achat
                    </div>
                </a>
            </li>
        </ul>
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
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
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
            
            <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-4 px-4 text-left font-medium">ID</th>
                            <th class="py-4 px-4 text-left font-medium">Numéro commande</th>
                            <th class="py-4 px-4 text-left font-medium">Fournisseur</th>
                            <th class="py-4 px-4 text-left font-medium">Date commande</th>
                            <th class="py-4 px-4 text-center font-medium">Nombre d'achat</th>
                            <th class="py-4 px-4 text-right font-medium">Total</th>
                            <th class="py-4 px-4 text-center font-medium">Actions</th>
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
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('achat.commande.detail', ['id' => $commande->id]) }}" 
                                       class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition-colors duration-200" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pdf.achat', ['id' => $commande->id]) }}" 
                                       class="text-gray-600 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200" 
                                       title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </a>
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

<style>
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