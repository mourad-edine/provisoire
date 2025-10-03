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

$nombreCageots = 0;
$valeurCageots = $nombreCageots * ($cgt ?? 0);
$totalConsigne = ($totalconsigne ?? 0) + $valeurCageots;
$montantTotal = ($deconsigneglobale - ($reste ?? 0) < 0 ? 0 : $deconsigneglobale - ($reste ?? 0)) + $totalConsigne;
    $netAPayer=$commande->etat_client == 1
    ? $prixGlobale
    : ($prixGlobale + ($cgt * $nombreCageots));
    @endphp

    <div class="container mx-auto px-4">
        <!-- Header avec breadcrumb -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
            <div class="w-full">
                <div class="bg-white shadow-sm border border-gray-100 overflow-hidden">
                    <!-- En-tête avec titre -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-cog mr-3 text-blue-600"></i>
                            Gestion de la commande #{{ $commande_id }}
                        </h3>
                    </div>

                    <!-- Grille des actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-6">
                        <!-- Carte Détails commande -->
                        <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-blue-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-300">
                                    <i class="fas fa-file-alt text-blue-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Détails commande</h4>
                                    <p class="text-xs text-gray-500">Voir les informations détaillées</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Historique paiements -->
                        <a href="{{ route('paiment.boissons', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                    <i class="fas fa-history text-green-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Historique paiements</h4>
                                    <p class="text-xs text-gray-500">Consulter l'historique</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Articles à rendre -->
                        @if($exist == true)
                        <a href="{{ route('vente.rendu', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-amber-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                    <i class="fas fa-undo text-amber-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors">Articles à rendre</h4>
                                    <p class="text-xs text-gray-500">Gestion des retours</p>
                                </div>
                            </div>
                        </a>
                        @endif

                        <!-- Carte Compte rendu -->
                        @if($commande->etat_client == 2)
                        <a href="{{ route('rendre.boissons', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-indigo-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-500 transition-colors duration-300">
                                    <i class="fas fa-clipboard-list text-indigo-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">Compte rendu</h4>
                                    <p class="text-xs text-gray-500">Rapport détaillé</p>
                                </div>
                            </div>
                        </a>
                        @endif

                        <!-- Carte Paiement -->
                        @if($commande->etat_commande == 'non payé' && $commande->etat_client != 2)
                        <a href="{{ route('pay.index', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-emerald-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-500 transition-colors duration-300">
                                    <i class="fas fa-credit-card text-emerald-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Paiement</h4>
                                    <p class="text-xs text-gray-500">Procéder au paiement</p>
                                </div>
                            </div>
                        </a>
                        @endif

                        <!-- Carte Déconsignation -->
                        <a href="{{ route('reglement.index', ['id' => $commande_id]) }}"
                            class="group bg-white border-2 border-gray-200 hover:border-purple-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition-colors duration-300">
                                    <i class="fas fa-exchange-alt text-purple-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">Déconsignation</h4>
                                    <p class="text-xs text-gray-500">Gestion consignes</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Nouvelle vente -->
                        <a href="{{ route('vente.page') }}"
                            class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                    <i class="fas fa-cart-plus text-green-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Nouvelle vente</h4>
                                    <p class="text-xs text-gray-500">Créer une vente</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Barre de statut en bas -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Statuts -->
                            <div class="flex flex-wrap gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-700">Commande :</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $commande->etat_commande == 'payé' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                        <i class="fas fa-{{ $commande->etat_commande == 'payé' ? 'check' : 'clock' }} mr-2 text-xs"></i>
                                        {{ ucfirst($commande->etat_commande) }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-700">Client :</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $commande->etat_client == 2 ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                        <i class="fas fa-{{ $commande->etat_client == 2 ? 'user-check' : 'user' }} mr-2 text-xs"></i>
                                        {{ $commande->etat_client == 2 ? 'Compte rendu prêt' : 'En traitement' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions rapides -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700 hidden sm:block">Actions :</span>
                                <div class="flex gap-1">
                                    <button class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200" title="Partager">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <button class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all duration-200" title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
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
        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="block sm:inline">{{ session('error') }}</span>
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
        @php
            $bouteillesARendre = $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation']) : 0;
        @endphp
        <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
            type="checkbox"
            name="check_bouteille"
            id="check_bouteille{{ $vente['id'] }}"
            {{ $bouteillesARendre == 0 ? 'disabled' : '' }}>
        <label class="ml-2 text-sm text-gray-700" for="check_bouteille{{ $vente['id'] }}">
            {{ $bouteillesARendre }}
        </label>
    </div>
</td>

<td class="px-6 py-4 whitespace-nowrap">
    <input type="number"
        name="quantite_buteille"
        id="quantite_buteille{{ $vente['id'] }}"
        class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        placeholder="Quantité"
        min="0"
        step="1"
        data-max="{{ $bouteillesARendre }}"
        {{ $bouteillesARendre == 0 ? 'readonly' : '' }}>
</td>

<td class="px-6 py-4 whitespace-nowrap">
    <input type="number"
        name="casse"
        id="casse{{ $vente['id'] }}"
        class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        placeholder="Casse"
        min="0"
        step="1"
        data-max="{{ $bouteillesARendre }}"
        {{ $bouteillesARendre == 0 ? 'readonly' : '' }}>
</td>


                                    

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="submit"
                                            @php
                                            $hasBouteilles=$vente['prix_consignation'] !=0 && ($vente['consignation'] / $vente['prix_consignation'])> 0;
                                            $hasCageots = $vente['consi_cgt'] != 0 && ($vente['prix_cgt'] / $vente['consi_cgt']) > 0;
                                            @endphp
                                            {{ !($hasBouteilles || $hasCageots) ? 'disabled' : '' }}
                                            class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-3 py-1 rounded text-sm font-medium transition duration-150 flex items-center">
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

                        </tbody>
                    </table>
                </div>

                <!-- Conditionnements Details -->
                @php
                // Correction : Accéder au premier élément du tableau puis à conditionnements
                $firstCommande = $conditionnements[0] ?? null;
                $conditionnementsData = $firstCommande['conditionnements'] ?? [];
                $hasConditionnements = count($conditionnementsData) > 0;
                @endphp

                @if($hasConditionnements)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-6">
                    <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                        <h6 class="font-semibold text-gray-700">DÉTAILS DU CONDITIONNEMENT</h6>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type Cageot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Cageot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Cageot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($conditionnementsData as $emballage)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $emballage['id'] ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $emballage['type_cageot'] ?? 'N/A' }} BTL</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cgt ?? 0 }} Ar/CGT</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $emballage['nombre_cageot'] ?? 0 }} CGT</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                            {{ number_format(($emballage['nombre_cageot'] ?? 0) * ($cgt ?? 0), 0, ',', ' ') }} Ar
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                            $etat = $emballage['etat'] ?? 'non rendu';
                                            $bgColor = $etat == 'rendu' ? 'green' : 'yellow';
                                            $textColor = $etat == 'rendu' ? 'green' : 'yellow';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $bgColor }}-100 text-{{ $textColor }}-800">
                                                {{ $etat }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if(isset($emballage['created_at']))
                                            {{ \Carbon\Carbon::parse($emballage['created_at'])->format('d/m/Y H:i') }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('payer.condi') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="commande_id" value="{{ $firstCommande['id'] ?? '' }}">
                                                <input type="hidden" name="conditionnement_id" value="{{ $emballage['id'] ?? '' }}">
                                                <input type="hidden" name="cgt" value="{{ $cgt ?? 0 }}">
                                                <input type="hidden" name="montant_total" value="{{ ($emballage['nombre_cageot'] ?? 0) * ($cgt ?? 0) }}">

                                                <div class="flex items-center space-x-2">
                                                    <input type="number"
                                                        name="quantite_cageot"
                                                        class="w-20 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                        placeholder="0"
                                                        min="0"
                                                        max="{{ $emballage['nombre_cageot'] ?? 0 }}"
                                                        step="1"
                                                        value="0">
                                                    <button type="submit"
                                                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center font-medium text-sm">
                                                        <i class="fas fa-check mr-1 text-sm"></i> Valider
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mt-6">
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input[name='quantite_buteille'], input[name='casse']").forEach(input => {
        input.addEventListener("input", function () {
            let rowId = this.id.replace(/[^0-9]/g, ""); // récupère l'id numérique (vente['id'])
            let quantite = parseInt(document.getElementById("quantite_buteille" + rowId)?.value || 0);
            let casse = parseInt(document.getElementById("casse" + rowId)?.value || 0);
            let max = parseInt(this.dataset.max);

            if (quantite + casse > max) {
                alert("⚠️ La somme (Quantité + Casse) ne doit pas dépasser " + max + " bouteilles.");
                this.value = "";
            }
        });
    });
});
</script>

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