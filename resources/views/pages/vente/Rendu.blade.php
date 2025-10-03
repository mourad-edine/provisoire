@extends('layouts.AdminLayout')

@section('title', 'Articles à rendre')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="bg-white rounded-sm shadow-md overflow-hidden">
        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200">
            <div class="px-6">
                <ul class="flex" id="parametresTabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('vente.rendu', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{ request()->routeIs('vente.rendu', ['id' => $commande->id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-large mr-2"></i> Articles à rendre
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('article.rendu.historique', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{ request()->routeIs('article.rendu.historique', ['id' => $commande_id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-list mr-2"></i> Historique des retours
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('commande.liste.vente.detail', ['id' => $commande_id]) }}"
                            class="inline-flex items-center px-4 py-3 rounded-t-lg border-b-2 
                            {{request()->routeIs('commande.liste.vente.detail', ['id' => $commande_id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                            <i class="fas fa-th-list mr-2"></i> Details commandes
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Header Section -->
        <div class="bg-white px-6 py-2 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-4 md:mb-0">
                    <!-- <h1 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-receipt mr-3 text-indigo-600"></i>
                        COMMANDE C-{{ $commande->id }} - Gestion des retours
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Gérez les retours d'articles pour cette commande</p> -->
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('rendrepdf.download', ['id' => $commande->id]) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                        <i class="fas fa-print mr-2"></i>Facture
                    </a>
                    <a href="{{ url()->previous() }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages d'alerte -->
        <div class="px-6 pt-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                    <span class="font-semibold">Erreurs de validation :</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="p-6">
            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <i class="fas fa-shopping-cart text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 font-medium">Total Articles</p>
                            <p class="text-lg font-bold text-blue-700">{{ $ventes->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-medium">Articles rendus</p>
                            <p class="text-lg font-bold text-green-700">
                                {{ $ventes->where('etat', 1)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-yellow-600 font-medium">En attente</p>
                            <p class="text-lg font-bold text-yellow-700">
                                {{ $ventes->where('etat', '!=', 1)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                            <i class="fas fa-exchange-alt text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-purple-600 font-medium">Retours effectués</p>
                            <p class="text-lg font-bold text-purple-700">
                                {{ $ventes->sum(function($vente) { return $vente->articlerendus->count(); }) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire principal -->
            <form id="multipleForm" method="POST" action="{{ route('article.rendu.all') }}">
                @csrf
                @method('PUT')
                
                <!-- Table Section -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-6">
                    <!-- Table Header -->
                    <div class="bg-gray-50 px-6 py-2 border-b border-gray-200">
                        <!-- <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-list-alt mr-2 text-indigo-600"></i>
                            Liste des articles à rendre
                        </h3> -->
                            <!-- <p class="text-gray-600 text-sm mt-1">Saisissez les quantités à rendre pour chaque article</p> -->
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-700">
                                <tr>
                                   
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Article
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Quantité initiale
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Bouteilles à rendre
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Casse
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Déjà rendu
                                    </th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Déjà cassé
                                    </th>
                                    <th class="px-6 py-2 text-right text-xs font-medium text-white uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($ventes as $vente)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $vente->article->nom }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        @if($vente->etat === 1)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Rendu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Non Rendu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if(($vente->quantite >= $vente->article->conditionnement) && ($vente->type_achat == 'bouteille'))
                                                @php
                                                    $nouvelle_quantite = $vente->quantite;
                                                    $qf = intdiv($nouvelle_quantite, $vente->article->conditionnement);
                                                    $rf = $nouvelle_quantite % $vente->article->conditionnement;
                                                @endphp
                                                <span class="font-medium">{{ $qf }} cageot/pack{{ $qf > 1 ? 's' : '' }}</span>
                                                @if($rf > 0)
                                                <span class="text-gray-600">+ {{ $rf }} unité{{ $rf > 1 ? 's' : '' }}</span>
                                                @endif
                                            @else
                                                <span class="font-medium">{{ $vente->quantite }}</span>
                                                <span class="text-gray-600">{{ $vente->type_achat }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <input type="number" 
                                               name="ventes[{{ $vente->id }}][rendu]" 
                                               class="border border-gray-300 rounded px-3 py-2 w-20 text-center rendu-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150" 
                                               data-quantite="{{ ($vente->type_achat == 'cageot'|| $vente->type_achat == 'pack') ? $vente->quantite * $vente->article->conditionnement : $vente->quantite }}"
                                               value="0"
                                               min="0"
                                               data-vente-id="{{ $vente->id }}"
                                               placeholder="0">
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <input type="number" 
                                               name="ventes[{{ $vente->id }}][casse]" 
                                               class="border border-gray-300 rounded px-3 py-2 w-20 text-center casse-input focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150" 
                                               data-quantite="{{ ($vente->type_achat == 'cageot'|| $vente->type_achat == 'pack') ? $vente->quantite * $vente->article->conditionnement : $vente->quantite }}"
                                               value="0"
                                               min="0"
                                               data-vente-id="{{ $vente->id }}"
                                               placeholder="0">
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-900">
                                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                            <span class="font-medium">{{ $vente->articlerendus->sum('quantite') ?? 0 }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-900">
                                            <i class="fas fa-times-circle mr-2 text-red-500"></i>
                                            <span class="font-medium">{{ $vente->articlerendus->sum('quantite_casse') ?? 0 }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap text-right">
                                        @if($vente->etat !== 1)
                                        <button type="button" 
                                                class="rendre-single bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center"
                                                data-vente-id="{{ $vente->id }}">
                                            <i class="fas fa-plus mr-2"></i>Rendre
                                        </button>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-check mr-1"></i>Déjà rendu
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-4"></i>
                                            <p class="text-lg font-medium mb-2">Aucun article à rendre</p>
                                            <p class="text-sm">Tous les articles ont été traités.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="mb-3 sm:mb-0">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold">{{ $ventes->where('etat', '!=', 1)->count() }}</span> 
                            article(s) en attente de retour
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                onclick="document.getElementById('multipleForm').reset()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-redo mr-2"></i>Réinitialiser
                        </button>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                            <i class="fas fa-layer-group mr-2"></i>Rendre multiple
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour gérer le rendu unique -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du rendu unique
    document.querySelectorAll('.rendre-single').forEach(button => {
        button.addEventListener('click', function() {
            const venteId = this.getAttribute('data-vente-id');
            
            // Récupérer les valeurs des inputs pour cette ligne
            const renduInput = document.querySelector(`.rendu-input[data-vente-id="${venteId}"]`);
            const casseInput = document.querySelector(`.casse-input[data-vente-id="${venteId}"]`);
            
            const renduValue = parseInt(renduInput.value) || 0;
            const casseValue = parseInt(casseInput.value) || 0;
            
            // Validation
            const quantiteMax = parseInt(renduInput.getAttribute('data-quantite'));
            const totalRendu = renduValue + casseValue;
            
            if (totalRendu > quantiteMax) {
                alert(`❌ Le total des bouteilles rendues et cassées (${totalRendu}) ne peut pas dépasser ${quantiteMax}`);
                return;
            }
            
            if (renduValue === 0 && casseValue === 0) {
                alert('⚠️ Veuillez saisir au moins une bouteille à rendre ou une casse');
                return;
            }
            
            // Confirmation
            if (!confirm(`Êtes-vous sûr de vouloir enregistrer ce retour ?\n\nBouteilles à rendre: ${renduValue}\nBouteilles cassées: ${casseValue}`)) {
                return;
            }
            
            // Créer un formulaire dynamique pour la soumission unique
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("article.rendu") }}';
            
            // Ajouter les tokens CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Ajouter la méthode PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Ajouter l'ID de la vente
            const venteIdInput = document.createElement('input');
            venteIdInput.type = 'hidden';
            venteIdInput.name = 'vente_id';
            venteIdInput.value = venteId;
            form.appendChild(venteIdInput);
            
            // Ajouter les valeurs rendu et casse
            const renduHidden = document.createElement('input');
            renduHidden.type = 'hidden';
            renduHidden.name = 'rendu';
            renduHidden.value = renduValue;
            form.appendChild(renduHidden);
            
            const casseHidden = document.createElement('input');
            casseHidden.type = 'hidden';
            casseHidden.name = 'casse';
            casseHidden.value = casseValue;
            form.appendChild(casseHidden);
            
            // Soumettre le formulaire
            document.body.appendChild(form);
            form.submit();
        });
    });
    
    // Validation pour le formulaire multiple
    document.getElementById('multipleForm').addEventListener('submit', function(e) {
        let hasError = false;
        let errorMessages = [];
        
        document.querySelectorAll('.rendu-input').forEach(input => {
            const venteId = input.getAttribute('data-vente-id');
            const renduInput = document.querySelector(`.rendu-input[data-vente-id="${venteId}"]`);
            const casseInput = document.querySelector(`.casse-input[data-vente-id="${venteId}"]`);
            
            const renduValue = parseInt(renduInput.value) || 0;
            const casseValue = parseInt(casseInput.value) || 0;
            const quantiteMax = parseInt(renduInput.getAttribute('data-quantite'));
            const totalRendu = renduValue + casseValue;
            
            if (totalRendu > quantiteMax) {
                hasError = true;
                errorMessages.push(`Le total des bouteilles rendues et cassées ne peut pas dépasser ${quantiteMax}`);
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('❌ Erreurs de validation:\n\n' + errorMessages.join('\n'));
        } else {
            if (!confirm('Êtes-vous sûr de vouloir enregistrer tous ces retours ?')) {
                e.preventDefault();
            }
        }
    });

    // Amélioration UX : focus sur les inputs
    document.querySelectorAll('.rendu-input, .casse-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.select();
        });
    });
});
</script>

<style>
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }
    
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endsection