@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="bg-white rounded-sm shadow-md overflow-hidden">
        <!-- Navigation Tabs -->
       <div class="border-b border-gray-200">
            <div class="px-6">
                <ul class="flex" id="parametresTabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('vente.rendu', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{ request()->routeIs('vente.rendu', ['id' => $commande_id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-large mr-2"></i> Articles à rendre
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('article.rendu.historique', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{ request()->routeIs('article.rendu.historique', ['id' => $commande_id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-list mr-2"></i> Historique des retours
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{request()->routeIs('commande.liste.vente.detail', ['id' => $commande_id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-list mr-2"></i> Details commandes
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Header Section -->
        <div class="bg-white px-6 py-4 border-b">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class=" md:mb-0">
                    <!-- <h1 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-receipt mr-3 text-indigo-600"></i>
                        ARTICLE - A RENDRE C-{{ $commande->id }}
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Gestion des retours d'articles pour cette commande</p> -->
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('rendrepdf.download', ['id' => $commande->id]) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                        <i class="fas fa-print mr-2"></i>Facture
                    </a>
                    <a href="{{ url()->previous() }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages d'alerte -->
        <div class="px-6 pt-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                    <span class="font-semibold">Erreurs de validation :</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="p-6">
            <!-- Table Section -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <!-- <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-history mr-2 text-indigo-600"></i>
                        Historique des retours
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">Liste de tous les retours effectués pour cette commande</p>
                </div> -->

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Article
                                </th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Bouteilles rendues
                                </th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Bouteilles cassées
                                </th>
                                <th class="px-6 py-2 text-right text-xs font-medium text-white uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($articlerendus as $articlerendu)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">#{{ $articlerendu->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $articlerendu->vente->article->nom }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Livré
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-wine-bottle mr-2 text-blue-600"></i>
                                        <span class="text-sm text-gray-900 font-medium">
                                            {{ $articlerendu->quantite }} Bouteille(s)
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-times mr-2 text-red-600"></i>
                                        <span class="text-sm text-gray-900 font-medium">
                                            {{ $articlerendu->quantite_casse }} Bouteille(s)
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <i class="fas fa-list mr-2 text-yellow-500"></i>                                    
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <p class="text-lg font-medium mb-2">Aucun retour enregistré</p>
                                        <p class="text-sm">Aucun retour n'a été effectué pour cette commande.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                @if($articlerendus->count() > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <p class="text-sm text-gray-600 mb-2 sm:mb-0">
                            Affichage de <span class="font-semibold">{{ $articlerendus->count() }}</span> retour(s)
                        </p>
                       
                    </div>
                </div>
                @endif
            </div>

            <!-- Informations complémentaires -->
            @if($articlerendus->count() > 0)
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Statistiques des retours -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-wine-bottle text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-medium">Total bouteilles rendues</p>
                            <p class="text-2xl font-bold text-blue-700">
                                {{ $articlerendus->sum('quantite') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-full mr-4">
                            <i class="fas fa-times text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-red-600 font-medium">Total bouteilles cassées</p>
                            <p class="text-2xl font-bold text-red-700">
                                {{ $articlerendus->sum('quantite_casse') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-green-600 font-medium">Total retours</p>
                            <p class="text-2xl font-bold text-green-700">
                                {{ $articlerendus->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Styles supplémentaires -->
<style>
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }
    
    .transition {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection