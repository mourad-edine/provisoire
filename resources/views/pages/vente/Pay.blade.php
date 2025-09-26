@extends('layouts.AdminLayout')

@section('title', 'Paiement - Commande C-' . $commande->id)

@section('content')
@php
$prixGlobale = 0;
$deconsigneglobale = 0; // Variable correctement initialisée
$totalconsigne = 0;
$totalbtl = 0;
$totalcgt = 0;
$casse = 0;
$casse_cgt = 0;
$rendu_btl = 0;
$rendu_cgt = 0;

foreach($ventes as $vente) {
$prix_base = $vente['cat'] == 'gros' ? $vente['prix_unitaire'] : $vente['prix_gros'];

$prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
? ($vente['quantite'] * $vente['prix_cage']) + $vente['consignation'] + $vente['prix_cgt']
: ($prix_base * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt'];

if ($commande->etat_client == 1) {
$prix_total -= $vente['consignation'] + $vente['prix_cgt'];
}

$prix_total_deconsigne = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
? ($vente['quantite'] * $vente['prix_cage'])
: ($prix_base * $vente['quantite']);

$casse += $vente['casse'];
$casse_cgt += $vente['casse_cgt'];
$rendu_cgt += $vente['rendu_cgt'];
$rendu_btl += $vente['rendu_btl'];

$prix_total_consigne = $vente['consignation'] + $vente['prix_cgt'];

$totalbtl += $vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation'];
$totalcgt += $vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt'];

$totalconsigne += $prix_total_consigne;
$deconsigneglobale += $prix_total_deconsigne; // Variable correctement assignée
$prixGlobale += $prix_total;
}

$nombreCageots = optional($conditionnement->conditionnement)->nombre_cageot ?? 0;
$valeurCageots = $nombreCageots * ($cgt ?? 0);
$totalConsigne = ($totalconsigne ?? 0) + $valeurCageots;
$montantTotal = ($deconsigneglobale - $reste < 0 ? 0 : $deconsigneglobale - $reste) + $totalConsigne;
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
    
    <!-- <div class="mb-6">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Paiement</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div> -->

    <!-- Informations commande -->
    <!-- <div class="mb-6">
        <div class="bg-white  shadow-sm border-l-4 border-blue-400">
            <div class="px-6 py-4 flex flex-wrap items-center justify-between border-b border-gray-200">
                <h6 class="font-semibold text-gray-700">
                    <i class="fas fa-receipt mr-2 text-blue-500"></i>Commande C-{{ $commande->id }}
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
                        <div class="bg-blue-500 p-2  mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Client</small>
                            <p class="font-semibold text-gray-800">{{ $commande->client->nom ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-blue-400 p-2  mr-3">
                            <i class="fas fa-phone text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Téléphone</small>
                            <p class="font-semibold text-gray-800">{{ $commande->client->telephone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-yellow-500 p-2  mr-3">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <div>
                            <small class="text-gray-500 text-sm">Date commande</small>
                            <p class="font-semibold text-gray-800">{{ $commande->created_at }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-{{ $commande->etat_commande == 'non payé' ? 'red' : 'green' }}-500 p-2  mr-3">
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
    </div> -->

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3  relative mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Payment Section -->
    <div class="bg-white  shadow-lg border-0 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('regler.payement') }}" method="POST" id="payment-form">
                @csrf
                <!-- Hidden Inputs -->
                <input type="hidden" name="commande_id" value="{{ $commande_id }}">
                <input type="hidden" name="montant_total" value="{{ $deconsigneglobale }}">
                <input type="hidden" name="montant_tot" value="{{ $montantTotal }}">
                <input type="hidden" name="totalconsigne" value="{{ $totalconsigne + (optional($conditionnement->conditionnement)->nombre_cageot * $cgt) }}">

                <!-- Payment Status -->
                @if($deconsigneglobale - $reste <= 0)
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-4  mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                        <div>
                            <h6 class="font-semibold mb-1">Paiement complet</h6>
                            <p class="mb-0">Le paiement pour cette commande a déjà été effectué.</p>
                        </div>
                    </div>
                </div>
                @else
                <!-- Payment Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200  shadow-sm mb-6">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h6 class="font-semibold text-gray-700">DÉTAILS DU PAIEMENT</h6>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-gray-600">Montant eau:</span>
                                            <span class="font-semibold text-gray-800">{{ number_format($deconsigneglobale - $reste, 0, ',', ' ') }} Ar</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-gray-600">Consignations:</span>
                                            <span class="font-semibold text-blue-600">{{ number_format($totalConsigne, 0, ',', ' ') }} Ar</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="bg-gray-50 p-4  text-center">
                                            <small class="text-gray-500 block">Total à payer</small>
                                            <h3 class="font-bold text-blue-600 text-2xl mb-0">{{ number_format($montantTotal, 0, ',', ' ') }} Ar</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Input -->
                        <div class="bg-white border border-gray-200  shadow-sm mb-6">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h6 class="font-semibold text-gray-700">MONTANT À RÉGLER</h6>
                            </div>
                            <div class="p-4">
                                <div class="mb-4">
                                    <label for="somme" class="block text-sm font-semibold text-gray-700 mb-2">Montant (Ar)</label>
                                    <div class="flex mb-3">
                                        <input
                                            type="number"
                                            id="somme"
                                            name="somme"
                                            class="flex-1 border border-gray-300 -l-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Saisissez le montant"
                                            min="0"
                                            max="{{ $prixGlobale - $reste }}"
                                            step="100"
                                            required>
                                        <span class="bg-gray-600 text-white px-4 py-3 -r-lg">
                                            Ar
                                        </span>
                                    </div>
                                    <small class="text-gray-500 text-sm mt-5">
                                        Montant maximum: {{ number_format($prixGlobale - $reste, 0, ',', ' ') }} Ar <span class="text-red-700">*</span>
                                    </small>
                                </div>

                                <!-- Pay All Option -->
                                <div class="flex items-center mb-4">
                                    <input class="h-5 w-5 text-blue-600  focus:ring-blue-500 border-gray-300" type="checkbox" id="all" name="all">
                                    <label class="ml-2 text-sm font-semibold text-gray-700" for="all">
                                        Tout régler en Argent (Avec BTL + CGT)
                                    </label>
                                </div>
                                <div class="bg-blue-50 border border-blue-200  px-3 py-2">
                                    <small class="text-blue-700">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Montant total: {{ number_format($montantTotal, 0, ',', ' ') }} Ar
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- Payment Transaction -->
                        <div class="bg-white border border-gray-200  shadow-sm">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h6 class="font-semibold text-gray-700">TRANSACTION</h6>
                            </div>
                            <div class="p-4">
                                <!-- Received Amount -->
                                <div class="mb-4">
                                    <label for="montant-recu" class="block text-sm font-semibold text-gray-700 mb-2">Montant reçu (Ar)</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            id="montant-recu"
                                            name="recu"
                                            class="flex-1 border border-gray-300 -l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Montant remis par le client"
                                            >
                                        <span class="bg-gray-600 text-white px-4 py-2 -r-lg">
                                            Ar
                                        </span>
                                    </div>
                                </div>

                                <!-- Change Amount -->
                                <div class="mb-4">
                                    <label for="montant-rendu" class="block text-sm font-semibold text-gray-700 mb-2">Monnaie à rendre (Ar)</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            id="montant-rendu"
                                            class="flex-1 border border-gray-300 -l-lg px-4 py-2 bg-gray-100"
                                            readonly
                                            value="0">
                                        <span class="bg-gray-600 text-white px-4 py-2 -r-lg">
                                            Ar
                                        </span>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="pt-3 border-t border-gray-200">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4  font-semibold transition duration-150 flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i> Confirmer le paiement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gestion de la checkbox "Tout régler"
        const allCheckbox = document.getElementById('all');
        const sommeInput = document.getElementById('somme');
        const montantRecuInput = document.getElementById('montant-recu');
        const montantRenduInput = document.getElementById('montant-rendu');

        if (allCheckbox && sommeInput) {
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    sommeInput.value = '{{ $montantTotal }}';
                    sommeInput.readOnly = true;
                    sommeInput.classList.add('bg-gray-100');
                } else {
                    sommeInput.value = '';
                    sommeInput.readOnly = false;
                    sommeInput.classList.remove('bg-gray-100');
                }
                calculateChange();
            });
        }

        // Calcul de la monnaie à rendre
        function calculateChange() {
            if (montantRecuInput && montantRenduInput) {
                const received = parseFloat(montantRecuInput.value) || 0;
                let amountDue = 0;

                if (allCheckbox && allCheckbox.checked) {
                    amountDue = parseFloat('{{ $montantTotal }}');
                } else if (sommeInput) {
                    amountDue = parseFloat(sommeInput.value) || 0;
                }

                const change = received - amountDue;
                montantRenduInput.value = change > 0 ? change.toFixed(0) : '0';

                if (change > 0) {
                    montantRenduInput.classList.remove('bg-gray-100');
                    montantRenduInput.classList.add('bg-yellow-100', 'text-yellow-800');
                } else {
                    montantRenduInput.classList.remove('bg-yellow-100', 'text-yellow-800');
                    montantRenduInput.classList.add('bg-gray-100');
                }
            }
        }

        // Écouter les changements sur les inputs
        if (montantRecuInput) {
            montantRecuInput.addEventListener('input', calculateChange);
        }

        if (sommeInput) {
            sommeInput.addEventListener('input', calculateChange);

            sommeInput.addEventListener('blur', function() {
                const max = parseFloat(this.max);
                const value = parseFloat(this.value) || 0;

                if (value > max) {
                    this.value = max;
                    alert(`Le montant ne peut pas dépasser ${max.toLocaleString('fr-FR')} Ar`);
                }

                calculateChange();
            });
        }

        // Gestion soumission du formulaire
        const paymentForm = document.getElementById('payment-form');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                const reste = parseFloat("{{ $deconsigneglobale - $reste }}");

                if (reste > 0) {
                    const montantSaisi = parseFloat(sommeInput.value) || 0;
                    if (montantSaisi <= 0) {
                        e.preventDefault();
                        alert('Veuillez saisir un montant valide');
                        return;
                    }
                }

                const montantRecu = parseFloat(montantRecuInput.value) || 0;
                // if (montantRecu <= 0) {
                //     e.preventDefault();
                //     alert('Veuillez saisir le montant reçu');
                //     return;
                // }

                const submitBtn = paymentForm.querySelector('[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement en cours...';
            });
        }

        // Initialiser le calcul
        calculateChange();
    });
</script>
@endsection