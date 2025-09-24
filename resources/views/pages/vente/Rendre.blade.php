@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Navigation Tabs -->
    <!-- <div class="border-b border-gray-200 mb-6">
        <nav class="flex flex-wrap -mb-px">
            <a href="{{ route('commande.liste.vente') }}" class="mr-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-list-alt mr-2"></i>Listes par commandes
            </a>
            <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="mr-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Détails commande
            </a>
            <a href="{{ route('vente.liste') }}" class="mr-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-history mr-2"></i>Historique des paiements
            </a>
            <a href="{{ route('rendre.boissons', ['id' => $commande_id]) }}" class="mr-8 py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 border-blue-500 flex items-center">
                <i class="fas fa-file-alt mr-2"></i>Compte rendu
            </a>
        </nav>
    </div> -->

    <!-- Card Principal -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-10 px-6 py-4 flex justify-between items-center border-b border-gray-800">
            <h5 class="text-lg font-semibold text-dark">VENTE - COMPTE-RENDU</h5>
            <div>
                <a href="{{route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
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

            <!-- Table Vente -->
            <form action="{{route('rendre.store')}}" method="POST">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client_id }}">
                <input type="hidden" name="commande_id" value="{{ $commande_id }}">
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sélectionner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bouteilles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cageot/Pack</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ventes as $vente)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end items-center space-x-2">
                                        <input type="checkbox" 
                                               name="check[{{ $vente->id }}]" 
                                               checked
                                               class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                                        <input type="hidden"
                                               value="{{ optional($vente->article)->id }}"
                                               name="article_id[{{ $vente->id }}]"
                                               required>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $vente->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ optional($vente->article)->nom ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{$vente->quantite}} - {{$vente->type_achat}}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" 
                                           step="1" 
                                           min="0"
                                           name="bouteilles[{{ $vente->id }}]"
                                           id="bouteilles_{{ $vente->id }}"
                                           class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bouteilles-input"
                                           data-conditionnement="{{ optional($vente->article)->conditionnement }}"
                                           data-id="{{ $vente->id }}"
                                           max="{{ $vente->type_achat == 'cageot' ? $vente->quantite * optional($vente->article)->conditionnement : $vente->quantite }}"
                                           oninput="updateCageots(this)"
                                           readonly>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" 
                                           step="1" 
                                           min="0"
                                           name="cageots[{{ $vente->id }}]"
                                           id="cageots_{{ $vente->id }}"
                                           class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cageots-input"
                                           data-conditionnement="{{ optional($vente->article)->conditionnement }}"
                                           data-id="{{ $vente->id }}"
                                           max="{{ $vente->quantite }}"
                                           oninput="updateBouteilles(this)"
                                           {{ $vente->type_achat == 'bouteille' ? 'readonly' : '' }}>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="hidden" value="{{$commande_id}}" name="commande_id">
                                    <input type="number" 
                                           step="1" 
                                           min="0"
                                           name="unite[{{ $vente->id }}]"
                                           class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           max="{{ $vente->type_achat == 'bouteille' ? $vente->quantite : (optional($vente->article)->conditionnement - 1) }}"
                                           placeholder="0">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ optional($vente->commande)->etat_commande ?? '—' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                        <p class="text-lg">Aucune vente enregistrée</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Bouton de soumission -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-medium transition duration-150 flex items-center">
                        <i class="fas fa-save mr-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCageots(input) {
        const id = input.getAttribute('data-id');
        const conditionnement = parseFloat(input.getAttribute('data-conditionnement')) || 1;
        const bouteillesValue = parseFloat(input.value) || 0;
        
        const cageotsInput = document.getElementById(`cageots_${id}`);
        let cageotsValue = bouteillesValue / conditionnement;
        
        // Si la valeur est inférieure à 1, on met 0
        // Sinon on prend la partie entière (floor)
        cageotsValue = cageotsValue < 1 ? 0 : Math.floor(cageotsValue);
        
        cageotsInput.value = cageotsValue;
    }

    function updateBouteilles(input) {
        const id = input.getAttribute('data-id');
        const conditionnement = parseFloat(input.getAttribute('data-conditionnement')) || 1;
        const cageotsValue = parseFloat(input.value) || 0;
        
        const bouteillesInput = document.getElementById(`bouteilles_${id}`);
        const bouteillesValue = cageotsValue * conditionnement;
        
        bouteillesInput.value = bouteillesValue % 1 === 0 ? bouteillesValue : bouteillesValue.toFixed(2);
    }
</script>

@endsection