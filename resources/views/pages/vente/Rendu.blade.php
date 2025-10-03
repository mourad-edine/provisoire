@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="bg-white rounded-sm shadow-md overflow-hidden">
        <div class="flex justify-between items-center mb-6">
        <div>
            <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
                
                <li role="presentation">
                    <a href="{{ route('vente.rendu', ['id' => $commande->id]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('vente.rendu' , ['id' => $commande->id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-large mr-1"></i> article à rendre
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ route('article.rendu.historique' , ['id' => $commande->id]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('article.rendu.historique' , ['id' => $commande->id])  ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-list mr-1"></i> Historiques des retours
                    </a>
                </li>
                
            </ul>
        </div>
        
    </div>
        <!-- Header -->
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
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>

            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- FORMULAIRE PRINCIPAL POUR RENDU MULTIPLE -->
            <form id="multipleForm" method="POST" action="{{ route('article.rendu.all') }}">
                @csrf
                @method('PUT')
                
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-white">ID</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Article</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Statut</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Quantité</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Bouteille à rendre</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Casse</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Déjà rendu</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Déjà cassé</th>
                                <th class="px-6 py-3 text-xs font-medium text-white text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ventes as $vente)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $vente->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $vente->article->nom }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($vente->etat === 1)
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Rendu</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Non Rendu</span>
                                    @endif
                                </td>
                                            
                                <td class="px-6 py-4 text-sm">

                                @if(($vente->quantite >=  $vente->article->conditionnement) && ($vente->type_achat == 'bouteille'))
                                            @php
                                            $nouvelle_quantite = $vente->quantite;
                                            $qf = intdiv($nouvelle_quantite, $vente->article->conditionnement);
                                            $rf = $nouvelle_quantite % $vente->article->conditionnement;
                                            @endphp
                                            {{ $qf }} cageot/pack{{ $qf > 1 ? 's' : '' }}
                                            @if($rf > 0)
                                            et {{ $rf }} unité{{ $rf > 1 ? 's' : '' }}
                                            @endif
                                @else
                                    {{ $vente->quantite }} {{$vente->type_achat}}
                                @endif
                                </td>

                                <!-- Input pour bouteilles à rendre -->
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           name="ventes[{{ $vente->id }}][rendu]" 
                                           class="border border-gray-300 rounded px-2 py-1 w-20 text-center rendu-input" 
                                           data-quantite="{{ ($vente->type_achat == 'cageot'|| $vente->type_achat == 'pack') ? $vente->quantite * $vente->article->conditionnement : $vente->quantite }}"
                                           value="0"
                                           min="0"
                                           data-vente-id="{{ $vente->id }}">
                                </td>

                                <!-- Input pour casse -->
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           name="ventes[{{ $vente->id }}][casse]" 
                                           class="border border-gray-300 rounded px-2 py-1 w-20 text-center casse-input" 
                                           data-quantite="{{ ($vente->type_achat == 'cageot'|| $vente->type_achat == 'pack') ? $vente->quantite * $vente->article->conditionnement : $vente->quantite }}"
                                           value="0"
                                           min="0"
                                           data-vente-id="{{ $vente->id }}">
                                </td>

                                <td class="px-6 py-4 text-sm">{{ $vente->articlerendus->sum('quantite') ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm">{{ $vente->articlerendus->sum('quantite_casse') ?? 0 }}</td>

                                <!-- Bouton rendre (unique) -->
                                <td class="px-6 py-4 text-right">
                                    @if($vente->etat !== 1)
                                    <button type="button" 
                                            class="rendre-single bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                            data-vente-id="{{ $vente->id }}">
                                        <i class="fas fa-plus mr-1"></i>Rendre
                                    </button>
                                    @else
                                    <span class="text-gray-500 ">Déjà rendu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                    <p class="text-lg">Aucune donnée disponible</p>
                                </td>
                            </tr> 
                            @endforelse                     
                        </tbody>
                    </table>
                </div>

                <!-- Rendre Multiple -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium flex items-center">
                        <i class="fas fa-plus mr-1"></i>Rendre multiple
                    </button>
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
                alert(`Le total des bouteilles rendues et cassées (${totalRendu}) ne peut pas dépasser ${quantiteMax}`);
                return;
            }
            
            if (renduValue === 0 && casseValue === 0) {
                alert('Veuillez saisir au moins une bouteille à rendre ou une casse');
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
    
    // Validation pour le formulaire multiple (optionnel)
    document.getElementById('multipleForm').addEventListener('submit', function(e) {
        let isValid = true;
        let errorMessage = '';
        
        document.querySelectorAll('.rendu-input, .casse-input').forEach(input => {
            const venteId = input.getAttribute('data-vente-id');
            const renduInput = document.querySelector(`.rendu-input[data-vente-id="${venteId}"]`);
            const casseInput = document.querySelector(`.casse-input[data-vente-id="${venteId}"]`);
            
            const renduValue = parseInt(renduInput.value) || 0;
            const casseValue = parseInt(casseInput.value) || 0;
            const quantiteMax = parseInt(renduInput.getAttribute('data-quantite'));
            const totalRendu = renduValue + casseValue;
            
            if (totalRendu > quantiteMax) {
                isValid = false;
                errorMessage = `Le total des bouteilles rendues et cassées ne peut pas dépasser ${quantiteMax} pour un article`;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
        }
    });
});
</script>

@endsection