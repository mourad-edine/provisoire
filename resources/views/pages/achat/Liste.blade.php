@extends('layouts.AdminLayout')

@section('title', 'Liste des Achats')

@section('content')
<style>
    .highlighted {
        background-color: rgba(72, 187, 120, 0.2) !important;
        transition: background-color 1.5s ease-out;
        box-shadow: 0 0 0 2px rgba(72, 187, 120, 0.3);
    }
</style>

<div class=" mx-auto">
    @php
    $highlightedId = session('highlighted_id');
    @endphp

    <!-- En-tête de section -->

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
                                <i class="fas fa-undo text-amber-600 group-hover:text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors"> Nouvel achat
                                </h4>
                                <p class="text-xs text-gray-500">Acheter</p>
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
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- En-tête de la carte -->
        <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                <i class="fas fa-receipt mr-2 text-blue-500"></i>Historique des achats
            </h2>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-5 rounded-md flex items-center" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <div>
                    <p class="font-medium text-green-700">Succès!</p>
                    <p class="text-green-600">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="overflow-x-auto  shadow-sm border border-gray-200">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-800 text-white">
                       <tr>
                            <th class="py-2 px-2 text-left font-medium">ID</th>
                            <th class="py-2 px-2 text-left font-medium">Article</th>
                            <th class="py-2 px-2 text-right font-medium">Prix unité</th>
                            <th class="py-2 px-2 text-right font-medium">Prix / cageot</th>
                            <th class="py-2 px-2 text-left font-medium">Commande</th>
                            <th class="py-2 px-2 text-center font-medium">Quantité</th>
                            <th class="py-2 px-2 text-center font-medium">État</th>
                            <th class="py-2 px-2 text-right font-medium">Total</th>
                            <th class="py-2 px-2 text-left font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($achats as $achat)
                        <tr id="achat-{{ $achat['id'] }}" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-3 px-4 font-mono text-blue-600">{{ $achat['id'] }}</td>
                            <td class="py-3 px-4 font-medium">{{ $achat['article'] }}</td>
                            <td class="py-3 px-4 text-right">{{ number_format($achat['prix_unite'], 0, ',', ' ') }} Ar</td>
                            <td class="py-3 px-4 text-right">{{ number_format($achat['prix_unite'] * $achat['conditionnement'], 0, ',', ' ') }} Ar</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    C-{{ $achat['numero_commande'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $achat['quantite'] }} - {{ $achat['type_achat'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Payé
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-semibold text-green-700">{{ number_format($achat['prix'], 0, ',', ' ') }} Ar</td>
                            <td class="py-3 px-4">{{ $achat['created_at'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-8 px-4 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 py-5">
                                    <i class="fas fa-receipt text-4xl mb-3 text-gray-300"></i>
                                    <p class="font-medium">Aucun achat trouvé</p>
                                    <p class="text-sm mt-1">Aucun achat n'a été enregistré pour le moment</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $achats->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>



@endsection