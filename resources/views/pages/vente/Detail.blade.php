@extends('layouts.AdminLayout')

@section('title', 'Détails de la vente')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header avec breadcrumb -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
        <div class="w-full">
            <div class="bg-white shadow-md  border border-gray-100 overflow-hidden">
                <!-- En-tête avec titre -->
              <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-start">
    <div class="flex-1">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-cog mr-3 text-blue-600"></i>
            Gestion de la commande #{{ $commande_id }}
        </h3>
    </div>
    <div class="flex-1 flex justify-end">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <a href="{{ route('commande.liste.vente') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Commandes</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">C-{{ $commande->id }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
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
                            <div class="flex gap-2">
                            <a href="{{ route('pdf.download', ['id' => $commande_id]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                                <i class="fas fa-print mr-1"></i> Facture
                            </a>
                            <a href="{{ url()->previous() }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2  text-sm font-medium transition duration-150 flex items-center">
                                <i class="fas fa-arrow-left mr-1"></i> Retour
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    $nombreCageots = optional($conditionnement->conditionnements)->sum('nombre_cageot') ?? 0;
    $valeurCageots = $nombreCageots * ($cgt ?? 0);
    $totalConsigne = ($totalconsigne ?? 0) + $valeurCageots;
    $montantTotal = ($deconsigneglobale - ($reste ?? 0) < 0 ? 0 : $deconsigneglobale - ($reste ?? 0)) + $totalConsigne;
        $netAPayer=$commande->etat_client == 1
        ? $prixGlobale
        : ($prixGlobale + ($cgt * $nombreCageots));
        @endphp

    <!-- Client Information -->
    <div class="mb-6">
        <div class=" shadow-sm  border-t-gray-500 border-b-gray-500 border-t-1 border-b-1 ">
            <!-- <div class="px-6 py-4 flex flex-wrap items-center justify-between border-b border-gray-200">
                <h6 class="font-semibold text-gray-700">
                    <i class="fas fa-user-circle mr-2 text-blue-500"></i>Informations Client
                </h6>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $commande->etat_commande == 'non payé' ? 'red' : 'green' }}-100 text-{{ $commande->etat_commande == 'non payé' ? 'red' : 'green' }}-800">
                    {{ $commande->etat_commande }}
                </span>
            </div> -->
            <div class="p-6 bg-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="flex items-center">
                        <div class="bg-blue-500 p-2 rounded mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Nom</small>
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
                        <div class="bg-green-500 p-2 rounded mr-3">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Email</small>
                            <p class="font-semibold text-gray-800">{{ $commande->client->email ?? 'N/A' }}</p>
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
                        <div class="bg-green-500 p-2 rounded mr-3">
                            <i class="fas fa-dollar text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Net à payer</small>
                            <p class="font-semibold text-gray-800">{{ number_format($netAPayer, 0, ',', ' ') }} Ar</p>
                        </div>
                    </div>
                </div>
                @if($commande->client->adresse)
                <div class="flex items-center mt-4">
                    <div class="bg-gray-500 p-2 rounded mr-3">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div>
                        <small class="text-gray-500 text-sm">Adresse</small>
                        <p class="font-semibold text-gray-800">{{ $commande->client->adresse }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Calculate Totals for Net à Payer -->
    
        <!-- Net à Payer Card -->
        <!-- <div class="mb-6">
            <div class="bg-gray-700 text-white shadow">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <h5 class="text-white font-semibold mb-2 md:mb-0">
                            <i class="fas fa-wallet mr-2"></i>Net à payer
                        </h5>
                        <h5 class="font-bold text-2xl">{{ number_format($netAPayer, 0, ',', ' ') }} Ar</h5>
                    </div>
                </div>
            </div>
        </div> -->

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

        <!-- Actions Bar -->
       

        <!-- Sales Table -->
        <div class="bg-white  shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Consignation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Bouteille</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">----</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Prix unitaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ventes as $vente)
                        @php
                        $highlightedId = session('highlighted_id');
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp
                        <tr id="row-{{ $vente['id'] }}" class="{{ $highlightedId == $vente['id'] ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $vente['article'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                @if($vente['etat_client'] == 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    À rendre
                                </span>
                                @elseif($vente['etat_client_commande'] == 2)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    À disposition
                                </span>
                                @else
                                <span class="font-semibold text-blue-600">
                                    {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                </span>
                                @endif
                                @else
                                <span class="text-gray-400">--</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $vente['etat'] ? ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ---
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($vente['etat_payement'] == 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i> Impayé
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i> Payé
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $vente['quantite'] }}
                                </span>
                                <small class="text-gray-500 ml-1">{{ $vente['type_achat'] }}</small>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex justify-center">
                                    <div>{{ number_format(($vente['type_achat'] == 'cageot' || $vente['type_achat'] == 'pack') ? $vente['prix_cage'] : $vente['prix_unitaire'], 0, ',', ' ') }} Ar</div>
                                    @unless($vente['etat_client'] == 1 || $vente['etat'] == 'rendu' || $vente['etat'] == 'non consigné' || !isset($vente['etat']))
                                    <small class="text-blue-500">+ {{ number_format($vente['prix_consignation'], 0, ',', ' ') }} Ar consigne</small>
                                    @endunless
                                </div>
                            </td>
                            <td class=" whitespace-nowrap text-sm font-semibold text-blue-600">
                                @php
                                $prix_base = $vente['cat'] == 'gros' ? $vente['prix_unitaire'] : $vente['prix_gros'];
                                $prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                ? ($vente['quantite'] * $vente['prix_cage']) + ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0)
                                : ($prix_base * $vente['quantite']) + ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0);

                                if ($commande->etat_client == 1) {
                                $prix_total -= ($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0);
                                }
                                @endphp
                                <div class="flex justify-end px-5">
                                    {{ number_format($prix_total, 0, ',', ' ') }} Ar
                                </div>
                            </td>
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
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <!-- Summary Rows -->
                        <tr class="bg-gray-100">
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Cageot rendu:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ $rendu_cgt }}</td>
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Bouteille rendue:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ $rendu_btl }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900">Total consignation:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ number_format($totalconsigne + ($nombreCageots * $cgt), 0, ',', ' ') }} Ar</td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Bouteille cassée:</td>
                            <td class="px-6 py-3 font-semibold text-red-600 text-right">{{ $casse }}</td>
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Bouteille consignée:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ $totalbtl }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900">Total déconsigné:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ number_format($deconsigneglobale, 0, ',', ' ') }} Ar</td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Cageot perdu:</td>
                            <td class="px-6 py-3 font-semibold text-red-600 text-right">{{ $casse_cgt }}</td>
                            <td colspan="2" class="px-6 py-3 text-right font-semibold text-gray-900">Cageot consigné:</td>
                            <td class="px-6 py-3 font-semibold text-right text-gray-900">{{ $totalcgt + $nombreCageots }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900">Total:</td>
                            <td class="px-6 py-3 font-semibold text-blue-600 text-right">{{ number_format($prixGlobale, 0, ',', ' ') }} Ar</td>
                        </tr>
                        <tr class="font-semibold bg-gray-50">
                            <!-- Statut commande -->


                            <!-- Récapitulatif -->
                            <td colspan="8" class="px-1 py-3 text-right align-top">
                                <div class="border border-gray-200 p-4 bg-white shadow-sm rounded-md">
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-gray-700 text-sm">Déconsigne :</span>
                                        <span class="text-gray-900 text-sm">{{ $deconsigneglobale - ($reste ?? 0) < 0 ? 0 : $deconsigneglobale - ($reste ?? 0) }} Ar</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1 pt-2 mt-2 border-t border-gray-200">
                                        <span class="text-gray-700 text-sm">Consigne bouteilles :</span>
                                        <span class="text-green-600 text-sm">+ {{ number_format($totalconsigne ?? 0, 0, ',', ' ') }} Ar</span>
                                    </div>
                                    @if($nombreCageots > 0)
                                    <div class="flex justify-between items-center py-1 pt-2 mt-2 border-t border-gray-200">
                                        <span class="text-gray-700 text-sm">Cageots ({{ $nombreCageots }}) :</span>
                                        <span class="text-blue-500 text-sm">+ {{ number_format($valeurCageots, 0, ',', ' ') }} Ar</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between items-center py-2 pt-2 mt-2 border-t border-gray-200 font-bold">
                                        <span class="text-gray-900 text-sm">Reste à payer :</span>
                                        <span class="text-blue-600 text-sm">{{ number_format($montantTotal, 0, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            @if($ventes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex justify-center">
                    {{ $ventes->links('pagination::tailwind') }}
                </div>
            </div>
            @endif
        </div>
</div>

<!-- Déconsignation Modal -->
@endsection