@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <!-- Navigation Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex flex-wrap -mb-px space-x-2 md:space-x-8">
            <a href="{{ route('commande.liste.vente') }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-list-alt mr-2"></i> Listes par commandes
            </a>
            <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Détails commande
            </a>
            <a href="{{ route('paiment.boissons' ,['id' => $commande_id ]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-history mr-2"></i> Historique des paiements
            </a>
            <a href="{{ route('vente.rendu' ,['id' => $commande_id ]) }}" class="py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 border-blue-500 flex items-center">
                <i class="fas fa-list mr-2"></i> Article à rendre
            </a>
            @if($commande->etat_client == 2)
            <a href="{{ route('rendre.boissons',['id' => $commande_id ]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Compte rendu
            </a>
            @endif
        </nav>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gray-10 px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <h5 class="text-lg font-bold text-dark mb-2 md:mb-0">
                <i class="fas fa-receipt mr-2"></i>ARTICLE - A RENDRE C-{{$commande->id}}
            </h5>
            <div class="flex gap-2">
                <a href="{{route('rendrepdf.download',['id' => $commande->id ])}}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                    <i class="fas fa-print mr-1"></i>Facture
                </a>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i>Retour
                </a>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- Ventes Table -->
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">CGT/BTL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">BTL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">CGT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
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
                        @endphp

                        @forelse($ventes as $vente)
                        @php
                        $highlightedId = session('highlighted_id');
                        $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                        $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp

                        <tr id="row-{{$vente['id']}}" class="{{ $highlightedId == $vente['id'] ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{$vente['id']}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$vente['article']}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                @if($vente['etat_client'] == 1)
                                <span class="font-semibold text-red-600">à rendre</span>
                                @elseif($vente['etat_client_commande'] == 2)
                                <span class="font-semibold text-red-600">à disposition</span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">
                                    {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                </span>
                                @endif
                                @else
                                <span class="text-gray-400">--</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $vente['etat'] == 'non rendu' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $vente['etat'] ? ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ in_array($vente['etat_cgt'], ['non rendu']) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $vente['etat_cgt'] ? ($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']) : '--' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $vente['etat_payement'] == 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    <i class="fas {{ $vente['etat_payement'] == 0 ? 'fa-times-circle text-red-500 mr-1' : 'fa-check-circle text-green-500 mr-1' }}"></i>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{$vente['quantite']}} {{$vente['type_achat']}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format(($vente['type_achat'] == 'cageot' || $vente['type_achat'] == 'pack') ? $vente['prix_cage'] : $vente['prix_unitaire'], 0, ',', ' ') }} Ar
                                @unless($vente['etat_client'] == 1 || $vente['etat'] == 'rendu' || $vente['etat'] == 'non consigné' || !isset($vente['etat']))
                                + {{ number_format($vente['prix_consignation'], 0, ',', ' ') }} Ar
                                @endunless
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                @php
                                $prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                ? ($vente['prix_cage'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt']
                                : ($vente['prix_unitaire'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt'];

                                if($commande->etat_client == 1) {
                                $prix_total -= $vente['consignation'] + $vente['prix_cgt'];
                                }
                                $prix_total_deconsigne = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                ? ($vente['prix_cage'] * $vente['quantite'])
                                : ($vente['prix_unitaire'] * $vente['quantite']);
                                $casse += $vente['casse'];
                                $casse_cgt += $vente['casse_cgt'];
                                $rendu_cgt += $vente['rendu_cgt'];
                                $rendu_btl += $vente['rendu_btl'];
                                $prix_total_consigne = $vente['consignation'] + $vente['prix_cgt'];
                                $totalbtl += $vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation'];
                                $totalcgt += $vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt'];
                                $totalconsigne += $prix_total_consigne;
                                $deconsigneglobale += $prix_total_deconsigne;
                                $prixGlobale += $prix_total;
                                @endphp
                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Action buttons would go here -->
                            </td>
                        </tr>

                        <!-- Modal for each vente -->
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="venteModal2{{$vente['id']}}">
                            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <div class="bg-gray-800 text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                                        <h3 class="text-lg font-semibold">Déconsignation</h3>
                                        <button type="button" class="text-white close-modal">
                                            <span class="text-xl">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('rendre.rendu') }}" method="POST">
                                        @csrf
                                        <div class="px-4 py-6">
                                            <input type="hidden" name="vente_id" value="{{ $vente['id'] }}">
                                            <input type="hidden" name="commande_id" value="{{ $vente['numero_commande'] }}">
                                            <input type="hidden" name="consignation_id" value="{{ $vente['consignation_id'] }}">
                                            <input type="hidden" name="article_id" value="{{ $vente['article_id'] }}">
                                            <input type="hidden" name="total_btl" value="{{ $vente['prix_consignation'] != 0 ? $vente['consignation'] / $vente['prix_consignation'] : 0 }}">
                                            <input type="hidden" name="total_cgt" value="{{ $vente['consi_cgt'] != 0 ? $vente['prix_cgt'] / $vente['consi_cgt'] : 0 }}">

                                            <!-- Bouteille Section -->
                                            <div class="mb-4" id="bouteille_container">
                                                @if($vente['etat'] == 'non rendu')
                                                <div class="flex items-center mb-2">
                                                    <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300" 
                                                           type="checkbox" name="check_bouteille" id="check_bouteille{{$vente['id']}}">
                                                    <label class="ml-2 text-sm text-gray-700" for="check_bouteille{{$vente['id']}}">
                                                        Bouteille - {{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation']) : 0 }}
                                                    </label>
                                                </div>
                                                <input type="number" name="quantite_buteille" 
                                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                                       placeholder="nombre de bouteille à rendre"
                                                       max="{{ $vente['prix_consignation'] != 0 ? ($vente['consignation'] / $vente['prix_consignation']) : 0 }}" 
                                                       min="1" step="1">
                                                @else
                                                <p class="text-{{ $vente['etat'] == 'avec BTL' ? 'gray-500' : 'green-600' }} text-sm">
                                                    Bouteille {{ $vente['etat'] == 'avec BTL' ? 'non consignée' : 'rendu' }}
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Cageot Section -->
                                            <div class="mb-4" id="cageot_container">
                                                @if($vente['etat_cgt'] == 'non rendu')
                                                <div class="flex items-center mb-2">
                                                    <input class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300" 
                                                           type="checkbox" name="check_cageot" id="check_cageot{{$vente['id']}}">
                                                    <label class="ml-2 text-sm text-gray-700" for="check_cageot{{$vente['id']}}">
                                                        Cageot - ({{ $vente['consi_cgt'] != 0 ? $vente['prix_cgt'] / $vente['consi_cgt'] : 0 }} cageot(s))
                                                    </label>
                                                </div>
                                                <input type="number" name="quantite_cageot"
                                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="nombre cageot à rendre"
                                                       max="{{ isset($vente['prix_cgt']) && isset($vente['consi_cgt']) && $vente['consi_cgt'] > 0 ? floor($vente['prix_cgt'] / $vente['consi_cgt']) : 0 }}"
                                                       min="0" step="1"
                                                       @if(!isset($vente['prix_cgt']) || !isset($vente['consi_cgt']) || $vente['consi_cgt'] <=0) disabled @endif>
                                                @else
                                                <p class="text-{{ in_array($vente['etat_cgt'], ['avec CGT', 'non condi°']) ? 'gray-500' : 'green-600' }} text-sm">
                                                    @if($vente['etat_cgt'] == 'conditionné')
                                                    <span class="text-red-600">Bouteilles conditionnées en cageot</span>
                                                    @else
                                                    Cageot {{ in_array($vente['etat_cgt'], ['avec CGT', 'non condi°']) ? 'non consigné' : 'rendu' }}
                                                    @endif
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Additional form sections would go here -->
                                        </div>
                                        <div class="bg-gray-100 px-4 py-3 rounded-b-md flex justify-end space-x-3">
                                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 close-modal">
                                                Annuler
                                            </button>
                                            @if($bouteilleNonRendu || $cageotNonRendu)
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150">
                                                Rendre
                                            </button>
                                            @else
                                            <button type="button" class="bg-blue-400 text-white px-4 py-2 rounded text-sm font-medium cursor-not-allowed" disabled>
                                                Rendre
                                            </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center text-gray-400">
                                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                    <p class="text-lg">Aucune donnée disponible</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                        <!-- Total Rows -->
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="2" class="px-6 py-3 text-right text-sm text-gray-700"></td>
                            <td class="px-6 py-3 text-sm text-gray-700">Cageot vide rendu</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{$rendu_cgt}}</td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700">Bouteille pleine rendu</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{$rendu_btl}}</td>
                            <td class="px-6 py-3 text-sm text-gray-700"></td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700"></td>
                        </tr>

                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="2" class="px-6 py-3 text-right text-sm text-gray-700"></td>
                            <td class="px-6 py-3 text-sm text-gray-700">Bouteille pleine cassé :</td>
                            <td class="px-6 py-3 text-sm text-red-600">{{$casse}}</td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700">Bouteille pleine consigné :</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{$totalbtl}}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">Total déconsigné:</td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700"></td>
                        </tr>

                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="2" class="px-6 py-3 text-right text-sm text-gray-700"></td>
                            <td class="px-6 py-3 text-sm text-gray-700">Cageot vide endommagé / perdu :</td>
                            <td class="px-6 py-3 text-sm text-red-600">{{$casse_cgt}}</td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700">Cageot vide consigné :</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{$totalcgt + optional($conditionnement->conditionnement)->nombre_cageot}}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">Total consignation:</td>
                            <td colspan="2" class="px-6 py-3 text-sm text-gray-700"></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($ventes->hasPages())
                <div class="mt-6 flex justify-center">
                    <div class="bg-white px-4 py-3 border border-gray-200 rounded-lg">
                        {{ $ventes->links('pagination::tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Additional modals would go here -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gestion des modals
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Gestion des cases à cocher pour la casse
        document.querySelectorAll('input[type="checkbox"][name="check_bouteille_casse"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const modalBody = this.closest('.modal-body');
                const venteId = this.id.replace('check_bouteille_casse', '');

                const inputCasse = modalBody.querySelector(`#bouteille_casse_input${venteId}`);
                const cageotContainer = modalBody.querySelector('#cageot_container');
                const bouteilleContainer = modalBody.querySelector('#bouteille_container');
                const titre = modalBody.querySelector('#titre');
                const cageotCasseContainer = modalBody.querySelector(`#cageot_casse_container${venteId}`);

                if (inputCasse && cageotContainer && bouteilleContainer && cageotCasseContainer) {
                    const isChecked = this.checked;
                    inputCasse.style.display = isChecked ? 'block' : 'none';
                    cageotContainer.style.display = isChecked ? 'none' : 'block';
                    bouteilleContainer.style.display = isChecked ? 'none' : 'block';
                    cageotCasseContainer.style.display = isChecked ? 'block' : 'none';
                    titre.style.display = isChecked ? 'block' : 'none';
                }
            });
        });

        // Gestion de la checkbox "Tout régler"
        const allCheckbox = document.getElementById('all');
        const sommeInput = document.querySelector('input[name="somme"]');

        if (allCheckbox && sommeInput) {
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    sommeInput.value = '';
                    sommeInput.readOnly = true;
                } else {
                    sommeInput.value = '';
                    sommeInput.readOnly = false;
                }
            });

            sommeInput.addEventListener('input', function() {
                const max = parseFloat(this.max);
                const value = parseFloat(this.value) || 0;

                if (value > max) {
                    this.value = max;
                    alert(`Le montant ne peut pas dépasser ${max} Ar`);
                }
            });
        }
    });
</script>

@endsection