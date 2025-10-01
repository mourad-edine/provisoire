@extends('layouts.AdminLayout')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-6 text-sm">
    <!-- Cartes d'actions principales -->
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
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 mt-4">
        <!-- Achat de ce mois -->
        <div class="bg-white border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Achat ce mois</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ number_format($achatMois, 0, ',', ' ') }} Ar</h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <!-- Ventes ce mois -->
        <div class="bg-white border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Ventes ce mois</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ number_format($venteMois, 0, ',', ' ') }} Ar</h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </div>

        <!-- Bénéfice mois -->
        <div class="bg-white border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Bénéfice mois</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ number_format($beneficeMois, 0, ',', ' ') }} Ar</h3>
                </div>
                <div class="p-2 bg-purple-50 text-purple-600">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Dépenses ce mois -->
        <div class="bg-white border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Dépenses ce mois</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ number_format($depensemois, 0, ',', ' ') }} Ar</h3>
                </div>
                <div class="p-2 bg-yellow-50 text-yellow-600">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sélecteur d'année -->
    <div class="bg-white border border-gray-200 mb-6">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center mb-2 md:mb-0">
                    <i class="fas fa-chart-bar mr-2"></i>
                    ANALYSE FINANCIÈRE
                </h2>
                <form method="GET" action="{{ route('stat') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <select id="yearSelect" name="annee" class="bg-white border border-gray-300 px-3 py-2 text-xs focus:outline-none focus:border-blue-500 appearance-none pr-8">
                            @for($i = 2020; $i <= 2025; $i++)
                                <option value="{{ $i }}" {{ $i == ($selectedYear ?? date('Y')) ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 text-xs font-medium hover:bg-blue-700 transition-colors flex items-center gap-1">
                        <i class="fas fa-search"></i>
                        Analyser
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tableaux financiers -->
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

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-6">
        <!-- Chiffre d'Affaires -->
        <div class="bg-white border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-receipt mr-2"></i>
                    CHIFFRE D'AFFAIRES
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left border-b border-gray-200">Mois</th>
                            <th class="px-3 py-2 text-right border-b border-gray-200">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $caParMois[$num] ?? 0;
                                $totalCA += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border-b border-gray-200">{{ $mois }}</td>
                                <td class="px-3 py-2 text-right border-b border-gray-200 text-green-600">
                                    {{ number_format($montant, 0, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td class="px-3 py-2 font-semibold border-t border-gray-200">TOTAL</td>
                            <td class="px-3 py-2 text-right font-semibold border-t border-gray-200 text-green-600">
                                {{ number_format($totalCA, 0, ',', ' ') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Dépenses -->
        <div class="bg-white border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-credit-card mr-2"></i>
                    DÉPENSES
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left border-b border-gray-200">Mois</th>
                            <th class="px-3 py-2 text-right border-b border-gray-200">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $depensesParMois[$num] ?? 0;
                                $totalDepense += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border-b border-gray-200">{{ $mois }}</td>
                                <td class="px-3 py-2 text-right border-b border-gray-200 text-red-600">
                                    {{ number_format($montant, 0, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td class="px-3 py-2 font-semibold border-t border-gray-200">TOTAL</td>
                            <td class="px-3 py-2 text-right font-semibold border-t border-gray-200 text-red-600">
                                {{ number_format($totalDepense, 0, ',', ' ') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Dépenses Divers -->
        <div class="bg-white border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    DÉPENSES DIVERSES
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left border-b border-gray-200">Mois</th>
                            <th class="px-3 py-2 text-right border-b border-gray-200">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $depensesDiversParMois[$num] ?? 0;
                                $totalDepensesDivers += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border-b border-gray-200">{{ $mois }}</td>
                                <td class="px-3 py-2 text-right border-b border-gray-200 text-yellow-600">
                                    {{ number_format($montant, 0, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td class="px-3 py-2 font-semibold border-t border-gray-200">TOTAL</td>
                            <td class="px-3 py-2 text-right font-semibold border-t border-gray-200 text-yellow-600">
                                {{ number_format($totalDepensesDivers, 0, ',', ' ') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Bénéfice -->
        <div class="bg-white border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    BÉNÉFICE
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left border-b border-gray-200">Mois</th>
                            <th class="px-3 py-2 text-right border-b border-gray-200">Montant</th>
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
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border-b border-gray-200">{{ $mois }}</td>
                                <td class="px-3 py-2 text-right border-b border-gray-200 font-semibold {{ $benefice < 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ number_format($benefice, 0, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td class="px-3 py-2 font-semibold border-t border-gray-200">TOTAL</td>
                            <td class="px-3 py-2 text-right font-semibold border-t border-gray-200 {{ $totalBenefice < 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ number_format($totalBenefice, 0, ',', ' ') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Recherche par date -->
    <div class="bg-white border border-gray-200">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-900 flex items-center">
                <i class="fas fa-calendar-day mr-2"></i>
                ANALYSE PAR DATE
            </h2>
        </div>
        
        <div class="p-4">
            <form id="dateSearchForm" action="{{ route('stat') }}" class="mb-4">
                <div class="flex flex-col md:flex-row gap-3 items-start md:items-end">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Date</label>
                        <input name="date_vente" type="date" id="searchDate" value="{{ date('Y-m-d') }}" 
                               class="w-full border border-gray-300 px-3 py-2 text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 text-xs font-medium hover:bg-blue-700 transition-colors flex items-center gap-1">
                        <i class="fas fa-chart-bar"></i>
                        Analyser
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Résumé -->
                <div class="bg-gray-50 border border-gray-200 p-4">
                    <div class="text-center">
                        <div class="p-2 bg-blue-600 text-white inline-block mb-2">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Résumé du Jour</h4>
                        
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-bold text-gray-900">{{ $ventes->count() }}</div>
                                <div class="text-xs text-gray-600">Transactions</div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3">
                                <div class="text-xl font-bold text-green-600">
                                    {{ number_format($ventes->sum(function($vente) {
                                        return ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                                            ? $vente->quantite * $vente->prix * ($vente->article->conditionnement ?? 1)
                                            : $vente->quantite * $vente->prix;
                                    }), 0, ',', ' ') }}
                                </div>
                                <div class="text-xs text-gray-600">Chiffre d'Affaires</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles vendus -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-boxes mr-2"></i>
                                ARTICLES VENDUS
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left border-b border-gray-200">Article</th>
                                        <th class="px-3 py-2 text-right border-b border-gray-200">Prix</th>
                                        <th class="px-3 py-2 text-right border-b border-gray-200">Quantité</th>
                                        <th class="px-3 py-2 text-right border-b border-gray-200">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($ventes) > 0)
                                        @foreach($ventes as $vente)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-3 py-2 border-b border-gray-200">{{ $vente->article->nom ?? 'Article inconnu' }}</td>
                                                <td class="px-3 py-2 text-right border-b border-gray-200">{{ number_format($vente->prix, 0, ',', ' ') }} Ar</td>
                                                <td class="px-3 py-2 text-right border-b border-gray-200">{{ $vente->quantite }} - {{ ucfirst($vente->type_achat) }}</td>
                                                <td class="px-3 py-2 text-right border-b border-gray-200 text-green-600 font-semibold">
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
                                            <td colspan="4" class="px-3 py-4 text-center text-gray-500">
                                                <i class="fas fa-box-open mb-1 block"></i>
                                                Aucune vente enregistrée
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
@endsection