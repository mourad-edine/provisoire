@extends('layouts.AdminLayout')

@section('title', 'Historique Paiements')

@section('content')
<div class="container-fluid px-4">
    <!-- Navigation par onglets -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="w-full">
            <div class="bg-white shadow-sm  border border-gray-100 overflow-hidden">
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
                    <a href="#"
                        class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                <i class="fas fa-user text-green-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Information client</h4>
                                <p class="text-xs text-gray-500">
                                <p class="text-gray-500 text-sm flex items-center">
                                    <i class="fas fa-user mr-1"></i>
                                    Client : {{ $clients->nom }}
                                </p>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- En-tête de page -->
   
    <!-- Statistiques rapides -->


    <!-- Tableau des paiements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list-alt mr-2 text-blue-500"></i>
                    Détail des transactions
                </h3>
                <div class="relative flex justify-end">
                    <div class="mr-2">
                        <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3 md:mt-0">
                        <button class="flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition-colors">
                            <i class="fas fa-print mr-1.5"></i>
                            Facture
                        </button>
                        <a href="{{ url()->previous() }}" class="flex items-center px-3 py-1.5 border border-gray-300 hover:bg-gray-50 text-gray-600 rounded-md text-sm transition-colors">
                            <i class="fas fa-arrow-left mr-1.5"></i>
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i> ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-file-invoice mr-1"></i> Facture
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i> Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-money-bill mr-1"></i> Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1"></i> Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-exchange-alt mr-1"></i> Type d'opération
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-credit-card mr-1"></i> Méthode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-cog mr-1"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($clients->commandes as $commande)
                        @foreach ($commande->payements as $payement)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $payement->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    F-{{ $payement->id }}-{{ $commande->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $clients->nom ?? 'Client occasionnel' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                {{ number_format($payement->somme, 0, ',', ' ') }} Ar
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-day mr-2 text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($payement->created_at)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payement->operation }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $payement->mode_paye }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1 rounded" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900 transition-colors duration-200 p-1 rounded" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1 rounded" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-money-bill-wave text-4xl mb-3 opacity-50"></i>
                                    <p class="text-lg font-medium">Aucun paiement trouvé</p>
                                    <p class="text-sm mt-1">Aucune transaction n'a été enregistrée pour ce client</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Résumé financier -->
            @if($clients->commandes->flatMap->payements->count() > 0)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-500 mr-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total des transactions</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ number_format($clients->commandes->flatMap->payements->sum('somme'), 0, ',', ' ') }} Ar
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-green-100 text-green-500 mr-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dernière transaction</p>
                            <p class="text-lg font-semibold text-gray-800">
                                @php
                                $lastPayment = $clients->commandes->flatMap->payements->sortByDesc('created_at')->first();
                                @endphp
                                @if($lastPayment)
                                {{ \Carbon\Carbon::parse($lastPayment->created_at)->format('d/m/Y') }}
                                @else
                                N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
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