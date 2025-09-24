@extends('layouts.AdminLayout')

@section('title', 'Statistique')

@section('content')
<div class="container mx-auto px-4 py-6 text-sm">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-4 mb-4">
        <!-- Achat de ce mois -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-money-bill-wave text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Achat de ce mois</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $achatMois }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Achats aujourd'hui -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-shopping-cart text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Achats auj.</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $achatJour }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Dépenses aujourd'hui -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-coins text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Dép. aujourd'hui</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $depensejour }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Dépenses de ce mois -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-coins text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Dép. de ce mois</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $depensemois }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Ventes aujourd'hui -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-cash-register text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Ventes auj.</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $venteJour }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Ventes mois -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-cash-register text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Ventes mois</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $venteMois }} Ar</h6>
                </div>
            </div>
        </div>
        <!-- Bénéfice mois -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
            <div class="p-4 flex items-center">
                <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center mr-2">
                    <i class="fas fa-chart-line text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0">Bénéfice mois</p>
                    <h6 class="text-sm font-semibold mb-0">{{ $beneficeMois }} Ar</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Year Selector -->
    <div class="bg-white shadow-sm rounded-lg mb-4">
        <div class="bg-gray-100 p-4 flex flex-col md:flex-row justify-between items-center">
            <h6 class="text-sm font-bold text-gray-800 mb-3 md:mb-0">ANALYSE FINANCIÈRE PAR ANNÉE</h6>
            <form method="GET" action="{{ route('stat') }}" class="flex items-center gap-3">
                <select id="yearSelect" name="annee" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($i = 2020; $i <= 2025; $i++)
                        <option value="{{ $i }}" {{ $i == ($selectedYear ?? 2024) ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-gray-100 border rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-200 flex items-center">
                    <i class="fas fa-search mr-2"></i>Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Monthly Financial Tables -->
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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
        <!-- Chiffre d'Affaires Mensuel -->
        <div class="bg-white shadow-sm rounded-lg h-full">
            <div class="bg-gray-100 p-4 rounded-t-lg">
                <h6 class="text-sm font-bold text-gray-800">Chiffre d'Affaires Mensuel</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left w-1/2">Mois</th>
                            <th class="p-2 text-right w-1/2">Montant (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $caParMois[$num] ?? 0;
                                $totalCA += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 font-semibold">{{ $mois }}</td>
                                <td class="p-2 text-right">{{ number_format($montant, 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td class="p-2">TOTAL</td>
                            <td class="p-2 text-right">{{ number_format($totalCA, 0, ',', ' ') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Dépenses Mensuelles -->
        <div class="bg-white shadow-sm rounded-lg h-full">
            <div class="bg-gray-100 p-4 rounded-t-lg">
                <h6 class="text-sm font-bold text-gray-800">Dépenses Mensuelles</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left w-1/2">Mois</th>
                            <th class="p-2 text-right w-1/2">Montant (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $depensesParMois[$num] ?? 0;
                                $totalDepense += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 font-semibold">{{ $mois }}</td>
                                <td class="p-2 text-right">{{ number_format($montant, 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td class="p-2">TOTAL</td>
                            <td class="p-2 text-right">{{ number_format($totalDepense, 0, ',', ' ') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Dépenses Divers -->
        <div class="bg-white shadow-sm rounded-lg h-full">
            <div class="bg-gray-100 p-4 rounded-t-lg">
                <h6 class="text-sm font-bold text-gray-800">Dépenses Divers</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left w-1/2">Mois</th>
                            <th class="p-2 text-right w-1/2">Montant (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moisNom as $num => $mois)
                            @php
                                $montant = $depensesDiversParMois[$num] ?? 0;
                                $totalDepensesDivers += $montant;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 font-semibold">{{ $mois }}</td>
                                <td class="p-2 text-right">{{ number_format($montant, 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td class="p-2">TOTAL</td>
                            <td class="p-2 text-right">{{ number_format($totalDepensesDivers, 0, ',', ' ') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Bénéfice Mensuel -->
        <div class="bg-white shadow-sm rounded-lg h-full">
            <div class="bg-gray-100 p-4 rounded-t-lg">
                <h6 class="text-sm font-bold text-gray-800">Bénéfice / Pertes Mensuel</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left w-1/2">Mois</th>
                            <th class="p-2 text-right w-1/2">Montant (Ar)</th>
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
                                <td class="p-2 font-semibold">{{ $mois }}</td>
                                <td class="p-2 text-right {{ $benefice < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    {{ number_format($benefice, 0, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td class="p-2">TOTAL</td>
                            <td class="p-2 text-right {{ $totalBenefice < 0 ? 'text-red-500' : 'text-green-500' }}">
                                {{ number_format($totalBenefice, 0, ',', ' ') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Date Search Section -->
    <div class="bg-white shadow-sm rounded-lg mt-4">
        <div class="bg-gray-100 p-4 rounded-t-lg">
            <h6 class="text-sm font-bold text-gray-800">Recherche vente par date</h6>
        </div>
        <div class="p-4">
            <form id="dateSearchForm" action="{{ route('stat') }}" class="mb-4 flex flex-col md:flex-row gap-4 items-center">
                <div class="w-full md:w-1/3">
                    <input name="date_vente" type="date" id="searchDate" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <button type="submit" class="bg-gray-100 border rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-200 flex items-center w-full md:w-auto">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </div>
            </form>
            <div id="searchResults" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="bg-white shadow-sm rounded-lg h-full">
                        <div class="bg-gray-100 p-4 rounded-t-lg">
                            <h6 class="text-sm font-bold text-gray-800">Articles vendus</h6>
                        </div>
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr>
                                            <th class="p-2 text-left">Article</th>
                                            <th class="p-2 text-right">Prix unitaire</th>
                                            <th class="p-2 text-right">Quantité</th>
                                            <th class="p-2 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="soldItemsTable">
                                        @if(count($ventes) > 0)
                                            @foreach($ventes as $vente)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="p-2">{{ $vente->article->nom ?? 'Article inconnu' }}</td>
                                                    <td class="p-2 text-right">{{ number_format($vente->prix, 0, ',', ' ') }} Ar</td>
                                                    <td class="p-2 text-right">{{ $vente->quantite }} - {{ ucfirst($vente->type_achat) }}</td>
                                                    <td class="p-2 text-right">
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
                                                <td colspan="4" class="p-4 text-center">
                                                    <div class="flex flex-col items-center">
                                                        <i class="fas fa-box-open text-4xl text-gray-400 mb-2"></i>
                                                        <h5 class="text-gray-500">Aucune vente enregistrée</h5>
                                                        <p class="text-xs text-gray-500">Aucun article n'a été vendu pour cette période</p>
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
                <div>
                    <div class="bg-white shadow-sm rounded-lg h-full">
                        <div class="bg-gray-100 p-4 rounded-t-lg">
                            <h6 class="text-sm font-bold text-green-600">Résumé des ventes</h6>
                        </div>
                        <div class="p-4">
                            <div class="text-center mb-4">
                                <div class="text-xs font-bold uppercase text-gray-500">Nombre de ventes</div>
                                <div class="text-xl font-bold text-gray-800" id="salesCount">{{ $ventes->count() }}</div>
                            </div>
                            <hr class="my-4">
                            <div class="text-center">
                                <div class="text-xs font-bold uppercase text-gray-500">Total du jour</div>
                                <div class="text-2xl font-bold text-green-600" id="dailyTotal">
                                    {{ number_format($ventes->sum(function($vente) {
                                        return ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                                            ? $vente->quantite * $vente->prix * $vente->article->conditionnement
                                            : $vente->quantite * $vente->prix;
                                    }), 0, ',', ' ') }} Ar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#yearSelect').change(function() {
            console.log('Chargement des données pour ' + $(this).val());
        });

        $('#dateSearchForm').submit(function(e) {
            e.preventDefault();
            const date = $('#searchDate').val();
            console.log('Recherche des ventes pour le ' + date);

            const sampleData = {
                salesCount: Math.floor(Math.random() * 15) + 5,
                dailyTotal: Math.floor(Math.random() * 10000) + 1000,
                items: [
                    { name: 'Produit A', price: 120, quantity: 3 },
                    { name: 'Produit B', price: 45, quantity: 7 },
                    { name: 'Produit C', price: 89, quantity: 2 }
                ]
            };

            $('#salesCount').text(sampleData.salesCount);
            $('#dailyTotal').text(sampleData.dailyTotal.toLocaleString('fr-FR') + ' Ar');

            let itemsHtml = '';
            sampleData.items.forEach(item => {
                itemsHtml += `
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 text-left">${item.name}</td>
                        <td class="p-2 text-right">${item.price.toLocaleString('fr-FR')} Ar</td>
                        <td class="p-2 text-right">${item.quantity}</td>
                        <td class="p-2 text-right">${(item.price * item.quantity).toLocaleString('fr-FR')} Ar</td>
                    </tr>
                `;
            });
            $('#soldItemsTable').html(itemsHtml);

            $('#searchResults').addClass('hidden').removeClass('hidden').addClass('animate-fade-in');
        });
    });
</script>
<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection