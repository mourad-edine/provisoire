@extends('layouts.AdminLayout')

@section('title', 'Déconsignation - Commande C-' . $commande->id)

@section('content')
@php
$prixGlobale = 0;
$deconsigneglobale = 0;
$totalconsigne = 0;
$totalbtl = 0;
$totalcgt = 0;
$casse = 0;
$casse_cgt = 0;
$rendu_btl = 0;
$rendu_cgt = 0;

foreach ($ventes as $vente) {
$prix_base = $vente['cat'] == 'gros' ? $vente['prix_unitaire'] : $vente['prix_gros'];
$prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
? ($vente['quantite'] * $vente['prix_cage']) + ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0)
: ($prix_base * $vente['quantite']) + ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0);

if ($commande->etat_client == 1) {
$prix_total -= ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0);
}

$prix_total_deconsigne = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
? ($vente['quantite'] * $vente['prix_cage'])
: ($prix_base * $vente['quantite']);

$casse += $vente['casse'] ?? 0;
$casse_cgt += $vente['casse_cgt'] ?? 0;
$rendu_cgt += $vente['rendu_cgt'] ?? 0;
$rendu_btl += $vente['rendu_btl'] ?? 0;
$prix_total_consigne = ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0);

$totalbtl += $vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation'];
$totalcgt += $vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt'];
$totalconsigne += $prix_total_consigne;
$deconsigneglobale += $prix_total_deconsigne;
$prixGlobale += $prix_total;
}

$nombreCageots = optional($conditionnement->conditionnement)->nombre_cageot ?? 0;
$valeurCageots = $nombreCageots * ($cgt ?? 0);
$totalConsigne = ($totalconsigne ?? 0) + $valeurCageots;
$montantTotal = ($deconsigneglobale - ($reste ?? 0) < 0 ? 0 : $deconsigneglobale - ($reste ?? 0)) + $totalConsigne;
    $netAPayer=$commande->etat_client == 1
    ? $prixGlobale
    : ($prixGlobale + ($cgt * $nombreCageots));
    @endphp

    <div class="container mx-auto px-4">
        <!-- Header avec breadcrumb -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="w-full">
                <div class="bg-white  shadow-sm mb-4">
                    <div class="flex flex-wrap gap-2 justify-start">
                        <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-file-alt mr-2"></i>Détails commande
                        </a>
                        <a href="{{ route('paiment.boissons', ['id' => $commande_id]) }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-history mr-2"></i>Historique des paiements
                        </a>
                        @if($exist == true)
                        <a href="{{ route('vente.rendu', ['id' => $commande_id]) }}" class="border border-yellow-500 text-yellow-600 hover:bg-yellow-50 px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-undo mr-2"></i>Articles à rendre
                        </a>
                        @endif
                        @if($commande->etat_client == 2)
                        <a href="{{ route('rendre.boissons', ['id' => $commande_id]) }}" class="border border-blue-400 text-blue-500 hover:bg-blue-50 px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-clipboard-list mr-2"></i>Compte rendu
                        </a>
                        @endif
                        @if($commande->etat_commande == 'non payé' && $commande->etat_client != 2)
                        <a href="{{ route('pay.index', ['id' => $commande_id]) }}" class="border border-green-600 text-green-600 hover:bg-green-50 px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-credit-card mr-2"></i>Paiement
                        </a>
                        @endif
                        <a href="{{ route('reglement.index', ['id' => $commande_id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-exchange-alt mr-2"></i>Déconsignation
                        </a>
                        <a href="{{ route('vente.page') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-cart-plus mr-2"></i>Nouvelle vente
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('commande.liste.vente') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Commandes</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">C-{{ $commande->id }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Déconsignation</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Informations commande -->
        <div class="mb-6">
            <div class="bg-white  shadow-sm border-l-4 border-blue-500">
                <div class="px-6 py-4 flex flex-wrap items-center justify-between border-b border-gray-200">
                    <h6 class="font-semibold text-gray-700">
                        <i class="fas fa-receipt mr-2 text-blue-500"></i>Commande C-{{ $commande->id }} - Déconsignation
                    </h6>
                    <div class="flex gap-2 mt-2 md:mt-0">
                        <a href="{{ route('pdf.download', ['id' => $commande_id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-print mr-1"></i> Facture
                        </a>
                        <a href="{{ url()->previous() }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-arrow-left mr-1"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="flex items-center">
                            <div class="bg-blue-500 p-2 rounded mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <small class="text-gray-500 text-sm">Client</small>
                                <p class="font-semibold text-gray-800">{{ $commande->client->nom ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-blue-400 p-2 rounded mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <small class="text-gray-500 text-sm">Téléphone</small>
                                <p class="font-semibold text-gray-800">{{ $commande->client->telephone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-yellow-500 p-2 rounded mr-3">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <small class="text-gray-500 text-sm">Date commande</small>
                                <p class="font-semibold text-gray-800">{{ $commande->created_at }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-{{ $commande->etat_commande == 'non payé' ? 'red' : 'green' }}-500 p-2 rounded mr-3">
                                <i class="fas fa-{{ $commande->etat_commande == 'non payé' ? 'times' : 'check' }}-circle text-white"></i>
                            </div>
                            <div>
                                <small class="text-gray-500 text-sm">État</small>
                                <p class="font-semibold text-gray-800">{{ $commande->etat_commande }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Déconsignation Section -->
        <div class="bg-white  shadow-lg border-0 overflow-hidden">
            <div class="p-6">
                <!-- Articles Table -->
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bouteille</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité BTL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Casse BTL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cageot</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité CGT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Casse CGT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ventes as $vente)
                            <tr class="hover:bg-gray-50">
                                <form action="{{ route('payer.consignation') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="vente_id" value="{{ $vente['id'] }}">
                                    <input type="hidden" name="commande_id" value="{{ $vente['numero_commande'] }}">
                                    <input type="hidden" name="consignation_id" value="{{ $vente['consignation_id'] }}">
                                    <input type="hidden" name="article_id" value="{{ $vente['article_id'] }}">
                                    <input type="hidden" name="total_btl" value="{{ $vente['prix_consignation'] != 0 ? $vente['consignation'] / $vente['prix_consignation'] : 0 }}">
                                    <input type="hidden" name="total_cgt" value="{{ $vente['consi_cgt'] != 0 ? $vente['prix_cgt'] / $vente['consi_cgt'] : 0 }}">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $vente['article'] }}</div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center mb-2">
                                            <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300" 
                                                   type="checkbox" 
                                                   name="check_bouteille" 
                                                   id="check_bouteille{{ $vente['id'] }}"
                                                   {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'disabled' : '') : 'disabled' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="check_bouteille{{ $vente['id'] }}">
                                                {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation']) : 0 }}
                                            </label>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="quantite_buteille" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Quantité" 
                                               min="0" 
                                               step="1"
                                               {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="casse" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Casse" 
                                               min="0" 
                                               step="1"
                                               {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center mb-2">
                                            <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300" 
                                                   type="checkbox" 
                                                   name="check_cageot" 
                                                   id="check_cageot{{ $vente['id'] }}"
                                                   {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'disabled' : '') : 'disabled' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="check_cageot{{ $vente['id'] }}">
                                                {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt']) : 0 }}
                                            </label>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="quantite_cageot" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Quantité" 
                                               min="0" 
                                               step="1"
                                               {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="cageot_casse" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Casse" 
                                               min="0" 
                                               step="1"
                                               {{ $vente['consi_cgt'] != 0 ? ($vente['prix_cgt'] / $vente['consi_cgt'] == 0 ? 'readonly' : '') : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-150 flex items-center">
                                            <i class="fas fa-check mr-1"></i> Valider
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                        <p class="text-lg">Aucune donnée disponible</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            <!-- Cageots supplémentaires -->
                            @if(optional($conditionnement->conditionnement)->id)
                            <tr class="bg-blue-50 hover:bg-blue-100">
                                <form action="{{ route('payer.condi') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="commande_id" value="{{ $commande_id }}">
                                    <input type="hidden" name="conditionnement_id" value="{{ optional($conditionnement->conditionnement)->id ?? '' }}">
                                    <input type="hidden" name="cgt" value="{{ $cgt }}">
                                    <input type="hidden" name="nombre_cageot" value="{{ optional($conditionnement->conditionnement)->nombre_cageot ?? 0 }}">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-blue-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-box text-white text-xs"></i>
                                            </div>
                                            <div class="font-semibold text-gray-900">Cageots supplémentaires</div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4" colspan="2"></td>

                                    <td class="px-6 py-4"></td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center mb-2">
                                            <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300" 
                                                   type="checkbox" 
                                                   name="check_cageot" 
                                                   id="check_cageot_global"
                                                   {{ optional($conditionnement->conditionnement)->nombre_cageot > 0 ? '' : 'disabled' }}>
                                            <label class="ml-2 text-sm text-gray-700" for="check_cageot_global">
                                                {{ optional($conditionnement->conditionnement)->nombre_cageot ?? 0 }} unités
                                            </label>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="quantite_cageot" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Quantité" 
                                               min="0" 
                                               step="1"
                                               {{ optional($conditionnement->conditionnement)->nombre_cageot > 0 ? '' : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" 
                                               name="cageot_casse" 
                                               class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Casse" 
                                               min="0" 
                                               step="1"
                                               {{ optional($conditionnement->conditionnement)->nombre_cageot > 0 ? '' : 'readonly' }}>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium transition duration-150 flex items-center">
                                            <i class="fas fa-check mr-1"></i> Valider
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Conditionnement Details -->
                @if(optional($conditionnement->conditionnement)->id)
                <div class="bg-white border border-gray-200  shadow-sm mt-6">
                    <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                        <h6 class="font-semibold text-gray-700">DÉTAILS DU CONDITIONNEMENT</h6>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Cageot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Cageot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($conditionnement->conditionnement)->id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cgt }} Ar/CGT</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($conditionnement->conditionnement)->nombre_cageot }} CGT</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">{{ number_format(optional($conditionnement->conditionnement)->nombre_cageot * $cgt, 0, ',', ' ') }} Ar</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ optional($conditionnement->conditionnement)->etat == 'rendu' ? 'green' : 'yellow' }}-100 text-{{ optional($conditionnement->conditionnement)->etat == 'rendu' ? 'green' : 'yellow' }}-800">
                                                {{ optional($conditionnement->conditionnement)->etat ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($conditionnement->conditionnement)->created_at ? optional($conditionnement->conditionnement)->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="openModal()" class="text-blue-600 hover:text-blue-900 border border-blue-600 hover:bg-blue-50 px-3 py-1 rounded text-sm transition duration-150 flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mt-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Aucun conditionnement enregistré pour cette commande</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de déconsignation cageot -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="venteModal2">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg  bg-white">
            <div class="mt-3">
                <div class="bg-blue-600 text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        <i class="fas fa-box mr-2"></i>Déconsignation cageot
                    </h3>
                    <button type="button" class="text-white close-modal" onclick="closeModal()">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payer.condi') }}" method="POST">
                    @csrf
                    <div class="px-4 py-6">
                        <input type="hidden" name="commande_id" value="{{ $commande_id }}">
                        <input type="hidden" name="conditionnement_id" value="{{ optional($conditionnement->conditionnement)->id ?? '' }}">
                        <input type="hidden" name="cgt" value="{{ $cgt }}">
                        <input type="hidden" name="nombre_cageot" value="{{ optional($conditionnement->conditionnement)->nombre_cageot ?? 0 }}">
                        <input type="hidden" name="montant_total" value="{{ (optional($conditionnement->conditionnement)->nombre_cageot ?? 0) * $cgt }}">
                        <input type="hidden" name="montant_tot" value="{{ $montantTotal }}">
                        <input type="hidden" name="totalconsigne" value="{{ $totalconsigne + ((optional($conditionnement->conditionnement)->nombre_cageot ?? 0) * $cgt) }}">
                        <input type="hidden" name="reste" value="{{ $reste }}">
                        <input type="hidden" name="prixGlobale" value="{{ $prixGlobale }}">

                        <div class="mb-4">
                            <label for="quantite_cageot_modal" class="block text-sm font-semibold text-gray-700 mb-2">Quantité de cageots à rendre</label>
                            <input type="number" 
                                   id="quantite_cageot_modal" 
                                   name="quantite_cageot" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Quantité de cageots à rendre" 
                                   min="0" 
                                   step="1"
                                   value="{{ optional($conditionnement->conditionnement)->nombre_cageot ?? 0 }}">
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded px-3 py-2">
                            <small class="text-blue-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                Montant total: {{ number_format((optional($conditionnement->conditionnement)->nombre_cageot ?? 0) * $cgt, 0, ',', ' ') }} Ar
                            </small>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-4 py-3 rounded-b-md flex justify-end space-x-3">
                        <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 close-modal" onclick="closeModal()">
                            <i class="fas fa-times mr-1"></i> Annuler
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150">
                            <i class="fas fa-check mr-1"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('venteModal2').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('venteModal2').classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Gestion soumission des formulaires de déconsignation
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Traitement...';
                });
            });

            // Gestion des cases à cocher pour activer/désactiver les champs
            document.querySelectorAll('[name="check_bouteille"], [name="check_cageot"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const row = this.closest('tr');
                    if (this.name === 'check_bouteille') {
                        const quantiteInput = row.querySelector('[name="quantite_buteille"]');
                        const casseInput = row.querySelector('[name="casse"]');
                        if (this.checked) {
                            quantiteInput.removeAttribute('readonly');
                            casseInput.removeAttribute('readonly');
                        } else {
                            quantiteInput.setAttribute('readonly', 'readonly');
                            casseInput.setAttribute('readonly', 'readonly');
                            quantiteInput.value = '';
                            casseInput.value = '';
                        }
                    } else {
                        const quantiteInput = row.querySelector('[name="quantite_cageot"]');
                        const casseInput = row.querySelector('[name="cageot_casse"]');
                        if (this.checked) {
                            quantiteInput.removeAttribute('readonly');
                            casseInput.removeAttribute('readonly');
                        } else {
                            quantiteInput.setAttribute('readonly', 'readonly');
                            casseInput.setAttribute('readonly', 'readonly');
                            quantiteInput.value = '';
                            casseInput.value = '';
                        }
                    }
                });
            });

            // Fermer le modal en cliquant en dehors
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('venteModal2');
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
@endsection