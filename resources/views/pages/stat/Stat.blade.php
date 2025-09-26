@extends('layouts.AdminLayout')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-6 text-sm">
    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @php
        $cards = [
            [
                'title' => 'Nouvelle vente',
                'value' => 'Commencer',
                'icon' => 'fa-cash-register',
                'color' => 'bg-green-500',
                'text' => 'text-white',
                'link' => route('vente.page'),
                'action' => true
            ],
            [
                'title' => 'Approvisionnement',
                'value' => 'Acheter',
                'icon' => 'fa-pallet',
                'color' => 'bg-blue-500',
                'text' => 'text-white',
                'link' => route('achat.page'),
                'action' => true
            ],
           [
    'title' => 'Statistiques',
    'value' => 'statistique',
    'icon' => 'fa-chart-bar', // Icône plus appropriée
    'color' => 'bg-purple-500',
    'text' => 'text-white',
    'link' => route('stat'),
    'action' => true
]
        ];
        @endphp

        @foreach ($cards as $card)
        <div>
            @if(isset($card['link']))
            <a href="{{ $card['link'] }}" class="no-underline block group">
            @endif
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full overflow-hidden transition-transform duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                    <div class="{{ $card['color'] }} {{ $card['text'] }} p-4">
                        <div class="flex items-center">
                            <div class="rounded-full p-2 mr-3 bg-white bg-opacity-30">
                                <i class="fas {{ $card['icon'] }}"></i>
                            </div>
                            <div class="flex-grow">
                                <h6 class="mb-1 text-sm font-medium">{{ $card['title'] }}</h6>
                                <h5 class="mb-0 font-bold flex items-center">
                                    {{ $card['value'] }}
                                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @if(isset($card['link']))
            </a>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Tableau des articles -->
    
</div>
<style>
    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #cbd5e0;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .financial-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .financial-table th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        padding: 1rem;
        border-bottom: 2px solid #cbd5e0;
    }

    .financial-table td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    .financial-table tr:hover td {
        background-color: #f7fafc;
    }

    .financial-table tfoot td {
        background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
        font-weight: 700;
        border-top: 2px solid #cbd5e0;
    }

    .positive-value {
        color: #10b981;
        font-weight: 600;
    }

    .negative-value {
        color: #ef4444;
        font-weight: 600;
    }

    .section-header {
        background: linear-gradient(135deg, #1e293b 0%, #374151 100%);
        color: white;
        padding: 1.25rem;
    }

    .search-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
    }

    .chart-container {
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .progress-bar {
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .monthly-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .trend-indicator {
        font-size: 0.875rem;
        font-weight: 600;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 py-8">
    <div class="mx-auto sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="glass-effect  mb-8 border border-white/50">
            <div class="px-6 py-4">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">TABLEAU DE BORD FINANCIER</h1>
                            <p class="text-gray-600 text-sm">Analyse complète des performances de l'entreprise</p>
                        </div>
                    </div>
                    
                    <nav class="flex items-center space-x-1 text-sm">
                        <a href="{{ route('page.accueil') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">DASHBOARD</a>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-500">STATISTIQUES</span>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <!-- Achat de ce mois -->
            <div class="stat-card  p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Achat ce mois</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($achatMois, 0, ',', ' ') }} Ar</h3>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="stat-icon bg-red-50 text-red-500">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <div class="progress-bar mt-3">
                    <div class="progress-fill bg-red-500" style="width: 75%"></div>
                </div>
            </div>

            <!-- Ventes ce mois -->
            <div class="stat-card  p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ventes ce mois</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($venteMois, 0, ',', ' ') }} Ar</h3>
                        <div class="monthly-trend mt-2">
                            <span class="trend-indicator trend-up">+12.5%</span>
                            <span class="text-xs text-gray-500">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="stat-icon bg-green-50 text-green-500">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
                <div class="progress-bar mt-3">
                    <div class="progress-fill bg-green-500" style="width: 82%"></div>
                </div>
            </div>

            <!-- Bénéfice mois -->
            <div class="stat-card  p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Bénéfice mois</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($beneficeMois, 0, ',', ' ') }} Ar</h3>
                        <div class="monthly-trend mt-2">
                            <span class="trend-indicator trend-up">+8.3%</span>
                            <span class="text-xs text-gray-500">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="stat-icon bg-purple-50 text-purple-500">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="progress-bar mt-3">
                    <div class="progress-fill bg-purple-500" style="width: 68%"></div>
                </div>
            </div>

            <!-- Dépenses ce mois -->
            <div class="stat-card  p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Dépenses ce mois</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($depensemois, 0, ',', ' ') }} Ar</h3>
                        <div class="monthly-trend mt-2">
                            <span class="trend-indicator trend-down">-5.2%</span>
                            <span class="text-xs text-gray-500">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="stat-icon bg-yellow-50 text-yellow-500">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
                <div class="progress-bar mt-3">
                    <div class="progress-fill bg-yellow-500" style="width: 45%"></div>
                </div>
            </div>
        </div>

        <!-- Sélecteur d'année -->
        <div class="glass-effect shadow-lg mb-8 border border-white/50">
            <div class="section-header">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-3"></i>
                        ANALYSE FINANCIÈRE PAR ANNÉE
                    </h2>
                    <form method="GET" action="{{ route('stat') }}" class="flex items-center gap-3">
                        <div class="relative">
                            <select id="yearSelect" name="annee" class="bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none pr-10">
                                @for($i = 2020; $i <= 2025; $i++)
                                    <option value="{{ $i }}" {{ $i == ($selectedYear ?? date('Y')) ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        <button type="submit" class="bg-white text-gray-700 px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-50 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            Analyser
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tableaux financiers mensuels -->
        @php
            $moisNom = [
                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
            ];
            $caParMois = $ventesParMois->pluck('total', 'mois')->toArray();
            $depensesParMois = $depense->pluck('total', 'mois')->toArray();
            $depensesDiversParMois = $depensesDivers->pluck('total', 'mois')->toArray();
            $totalCA = 0;
            $totalDepense = 0;
            $totalDepensesDivers = 0;
            $totalBenefice = 0;
        @endphp

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
            <!-- Chiffre d'Affaires et Dépenses -->
            <div class="space-y-6">
                <!-- Chiffre d'Affaires -->
                <div class="chart-container  overflow-hidden">
                    <div class="section-header">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-receipt mr-2"></i>
                            CHIFFRE D'AFFAIRES MENSUEL
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="financial-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Mois</th>
                                    <th class="text-right">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                    @php
                                        $montant = $caParMois[$num] ?? 0;
                                        $totalCA += $montant;
                                        $percentage = $totalCA > 0 ? ($montant / $totalCA) * 100 : 0;
                                    @endphp
                                    <tr class="animate-slide-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                        <td class="font-semibold text-gray-800">{{ $mois }}</td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <span class="text-gray-900">{{ number_format($montant, 0, ',', ' ') }}</span>
                                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-bold text-gray-900">TOTAL ANNUEL</td>
                                    <td class="text-right font-bold text-green-600">{{ number_format($totalCA, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Dépenses -->
                <div class="chart-container  overflow-hidden">
                    <div class="section-header bg-gradient-to-r from-orange-600 to-red-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-credit-card mr-2"></i>
                            DÉPENSES MENSUELLES
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="financial-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Mois</th>
                                    <th class="text-right">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                    @php
                                        $montant = $depensesParMois[$num] ?? 0;
                                        $totalDepense += $montant;
                                    @endphp
                                    <tr>
                                        <td class="font-semibold text-gray-800">{{ $mois }}</td>
                                        <td class="text-right text-red-600">{{ number_format($montant, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-bold text-gray-900">TOTAL ANNUEL</td>
                                    <td class="text-right font-bold text-red-600">{{ number_format($totalDepense, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Dépenses Divers et Bénéfices -->
            <div class="space-y-6">
                <!-- Dépenses Divers -->
                <div class="chart-container  overflow-hidden">
                    <div class="section-header bg-gradient-to-r from-yellow-600 to-amber-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-tools mr-2"></i>
                            DÉPENSES DIVERSES
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="financial-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Mois</th>
                                    <th class="text-right">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                    @php
                                        $montant = $depensesDiversParMois[$num] ?? 0;
                                        $totalDepensesDivers += $montant;
                                    @endphp
                                    <tr>
                                        <td class="font-semibold text-gray-800">{{ $mois }}</td>
                                        <td class="text-right text-amber-600">{{ number_format($montant, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-bold text-gray-900">TOTAL ANNUEL</td>
                                    <td class="text-right font-bold text-amber-600">{{ number_format($totalDepensesDivers, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Bénéfice Mensuel -->
                <div class="chart-container  overflow-hidden">
                    <div class="section-header bg-gradient-to-r from-purple-600 to-indigo-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            BÉNÉFICE MENSUEL
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="financial-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Mois</th>
                                    <th class="text-right">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                    @php
                                        $ca = $caParMois[$num] ?? 0;
                                        $dep = $depensesParMois[$num] ?? 0;
                                        $depDivers = $depensesDiversParMois[$num] ?? 0;
                                        $benefice = $ca - $dep - $depDivers;
                                        $totalBenefice += $benefice;
                                    @endphp
                                    <tr>
                                        <td class="font-semibold text-gray-800">{{ $mois }}</td>
                                        <td class="text-right font-semibold {{ $benefice < 0 ? 'negative-value' : 'positive-value' }}">
                                            {{ number_format($benefice, 0, ',', ' ') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-bold text-gray-900">BÉNÉFICE ANNUEL</td>
                                    <td class="text-right font-bold {{ $totalBenefice < 0 ? 'negative-value' : 'positive-value' }}">
                                        {{ number_format($totalBenefice, 0, ',', ' ') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recherche par date -->
        <div class="glass-effect shadow-lg border border-white/50">
            <div class="section-header bg-gradient-to-r from-teal-600 to-cyan-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-calendar-day mr-3"></i>
                    ANALYSE DES VENTES PAR DATE
                </h2>
            </div>
            
            <div class="p-6">
                <form id="dateSearchForm" action="{{ route('stat') }}" class="mb-6 search-box p-6 ">
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionnez une date</label>
                            <div class="relative">
                                <input name="date_vente" type="date" id="searchDate" value="{{ date('Y-m-d') }}" 
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="mt-4 md:mt-6">
                            <button type="submit" class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-8 py-3 rounded-xl text-sm font-medium hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                                <i class="fas fa-chart-bar"></i>
                                Analyser les ventes
                            </button>
                        </div>
                    </div>
                </form>

                <div id="searchResults" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Résumé des ventes -->
                    <div class="lg:col-span-1">
                        <div class="chart-container  p-6 text-center">
                            <div class="mb-4">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-shopping-bag text-green-600 text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Résumé du Jour</h4>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <div class="text-2xl font-bold text-gray-900 mb-1" id="salesCount">{{ $ventes->count() }}</div>
                                    <div class="text-sm text-gray-600">Transactions</div>
                                </div>
                                
                                <div class="border-t pt-4">
                                    <div class="text-3xl font-bold text-green-600 mb-1" id="dailyTotal">
                                        {{ number_format($ventes->sum(function($vente) {
                                            return ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                                                ? $vente->quantite * $vente->prix * ($vente->article->conditionnement ?? 1)
                                                : $vente->quantite * $vente->prix;
                                        }), 0, ',', ' ') }}
                                    </div>
                                    <div class="text-sm text-gray-600">Chiffre d'Affaires</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Articles vendus -->
                    <div class="lg:col-span-2">
                        <div class="chart-container  overflow-hidden">
                            <div class="section-header bg-gradient-to-r from-blue-600 to-indigo-600">
                                <h3 class="text-lg font-semibold text-white flex items-center">
                                    <i class="fas fa-boxes mr-2"></i>
                                    ARTICLES VENDUS
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="financial-table">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Article</th>
                                                <th class="text-right">Prix Unitaire</th>
                                                <th class="text-right">Quantité</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="soldItemsTable">
                                            @if(count($ventes) > 0)
                                                @foreach($ventes as $vente)
                                                    <tr>
                                                        <td class="font-medium text-gray-900">{{ $vente->article->nom ?? 'Article inconnu' }}</td>
                                                        <td class="text-right text-gray-600">{{ number_format($vente->prix, 0, ',', ' ') }} Ar</td>
                                                        <td class="text-right text-gray-600">{{ $vente->quantite }} - {{ ucfirst($vente->type_achat) }}</td>
                                                        <td class="text-right font-semibold text-green-600">
                                                            @if(in_array($vente->type_achat, ['cageot', 'pack']))
                                                                {{ number_format($vente->quantite * $vente->prix * ($vente->article->conditionnement ?? 1), 0, ',', ' ') }}
                                                            @else
                                                                {{ number_format($vente->quantite * $vente->prix, 0, ',', ' ') }}
                                                            @endif
                                                            Ar
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="p-8 text-center">
                                                        <div class="flex flex-col items-center text-gray-400">
                                                            <i class="fas fa-box-open text-4xl mb-3"></i>
                                                            <h5 class="font-semibold mb-1">Aucune vente enregistrée</h5>
                                                            <p class="text-sm">Aucun article n'a été vendu pour cette période</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script pour gérer les modals et le dropdown -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Gestion du dropdown de tri
        const sortButton = document.getElementById('sortDropdown');
        const sortMenu = document.getElementById('sortDropdownMenu');
        sortButton.addEventListener('click', function () {
            sortMenu.classList.toggle('hidden');
        });

        // Fermer le dropdown si on clique à l'extérieur
        document.addEventListener('click', function (event) {
            if (!sortButton.contains(event.target) && !sortMenu.contains(event.target)) {
                sortMenu.classList.add('hidden');
            }
        });

        // Gestion des modals (clic à l'extérieur pour fermer)
        document.querySelectorAll('.fixed.inset-0').forEach(modal => {
            modal.addEventListener('click', function (event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection