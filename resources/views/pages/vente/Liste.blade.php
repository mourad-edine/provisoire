@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="">

    <!-- Navigation Tabs -->
    <ul class="flex border-b mb-4">
        <li class="mr-4">
            <a href="{{ route('commande.liste.vente') }}" class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-blue-600">
                <i class="fas fa-list-alt mr-2"></i> Listes par commandes
            </a>
        </li>
        <li class="mr-4">
            <a href="{{ route('vente.liste') }}" class="inline-flex items-center px-4 py-2 text-blue-600 border-b-2 border-blue-600 font-semibold">
                <i class="fas fa-shopping-cart mr-2"></i> Listes ventes
            </a>
        </li>
        <li class="mr-4">
            <a href="{{route('vente.page')}}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-800">
                <i class="fas fa-cart-plus mr-2 text-white"></i> Nouvelle vente
            </a>
        </li>
    </ul>

    <!-- Main Card -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-4">
            @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <!-- Ventes Table -->
            <div class="overflow-x-auto mb-4">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2 text-left">Article</th>
                            <th class="px-3 py-2">CGT/BTL</th>
                            <th class="px-3 py-2">BTL</th>
                            <th class="px-3 py-2">CGT</th>
                            <th class="px-3 py-2">Statut</th>
                            <th class="px-3 py-2">Quantité</th>
                            <th class="px-3 py-2">Prix</th>
                            <th class="px-3 py-2">Total</th>
                            <th class="px-3 py-2">Bénéfice</th>
                            <th class="px-3 py-2 text-right">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $prixGlobale = 0; $deconsigneglobale = 0; $totalconsigne = 0; 
                            $totalbtl = 0; $totalcgt = 0; $casse = 0; $casse_cgt = 0;
                            $rendu_btl = 0; $rendu_cgt = 0; 
                        @endphp

                        @forelse($ventes as $vente)
                        @php
                            $highlightedId = session('highlighted_id');
                            $bouteilleNonRendu = $vente['etat'] == 'non rendu';
                            $cageotNonRendu = $vente['etat_cgt'] == 'non rendu';
                        @endphp

                        <tr class="{{ $highlightedId == $vente['id'] ? 'bg-blue-100' : '' }}">
                            <td class="px-3 py-2 font-semibold">{{$vente['article']}}</td>
                            <td class="px-3 py-2">
                                @if(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0) > 0)
                                    @if($vente['etat_client'] == 1)
                                        <span class="px-2 py-1 rounded bg-red-600 text-white text-xs">à rendre</span>
                                    @elseif($vente['etat_client_commande'] == 2 )
                                        <span class="px-2 py-1 rounded bg-yellow-400 text-xs">à disposition</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-gray-200 text-gray-800 text-xs">
                                            {{ number_format(($vente['consignation'] ?? 0) + ($vente['prix_cgt'] ?? 0), 0, ',', ' ') }} Ar
                                        </span>
                                    @endif
                                @else
                                    <span>--</span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $vente['etat'] == 'non rendu' ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                                    {{ $vente['etat'] ? ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $vente['etat_cgt'] == 'non rendu' ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                                    {{ $vente['etat_cgt'] ? ($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']) : '--' }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $vente['etat_payement'] == 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    <i class="fas {{ $vente['etat_payement'] == 0 ? 'fa-times-circle' : 'fa-check-circle' }} mr-1"></i>
                                </span>
                            </td>
                            <td class="px-3 py-2 font-bold">{{$vente['quantite']}} {{$vente['type_achat']}}</td>
                            <td class="px-3 py-2">
                                {{ number_format($vente['prix_unitaire'], 0, ',', ' ') }} Ar
                                @unless($vente['etat_client'] == 1 || $vente['etat'] == 'rendu' || $vente['etat'] == 'non consigné' || !isset($vente['etat']))
                                    + {{ number_format($vente['prix_consignation'], 0, ',', ' ') }} Ar
                                @endunless
                            </td>
                            <td class="px-3 py-2">
                                @php
                                    $prix_total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                                        ? ($vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement']) + $vente['consignation'] + $vente['prix_cgt']
                                        : ($vente['prix_unitaire'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt'];
                                @endphp
                                {{ number_format($prix_total, 0, ',', ' ') }} Ar
                            </td>
                            <td class="px-3 py-2">--</td>
                            <td class="px-3 py-2 text-right">
                                @if($vente['etat_client_commande'] != 2)
                                <a href="{{ route('commande.liste.vente.detail', ['id' => $vente['numero_commande']]) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-3 py-4 text-center text-gray-500">
                                <i class="fas fa-exclamation-circle mr-2"></i> Aucune donnée disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $ventes->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
