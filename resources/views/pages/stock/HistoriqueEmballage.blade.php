@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container mx-auto p-4">


    <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
        <div>
            <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <a href="{{ route('emballage.achat') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('emballage.achat') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-cart-plus mr-1"></i> Achat d'emballage
                    </a>
                </li>
                <li class="mr-2" role="presentation">
                    <a href="{{ route('depense.historique') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('depense.historique') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-list mr-1"></i> Historique des achats
                    </a>
                </li>

            </ul>
        </div>
        <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>
    <!-- Cartes de synthèse -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Dépenses ce mois -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-calendar-alt text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Dépenses ce mois</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $totalmois ?? '0' }} Ar</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépenses du jour -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-calendar-day text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Aujourd'hui</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $totalJour ?? '0' }} Ar</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouteille acheté aujourd'hui -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-wine-bottle text-yellow-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Bouteille acheté aujourd'hui</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $bouteillejour ?? '0' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouteille acheté ce mois ci -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-wine-bottle text-yellow-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Bouteille acheté ce mois-ci</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $bouteillemois ?? '0' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cageot acheté aujourd'hui -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-box text-orange-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cageot acheté aujourd'hui</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $cageotjour ?? '0' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cageot acheté ce mois ci -->
        <div class="bg-white shadow-sm hover:shadow-md transition-shadow duration-200 h-full border-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-50 flex items-center justify-center mr-3 border-0">
                        <i class="fas fa-box-open text-orange-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cageot acheté ce mois-ci</p>
                        <h5 class="text-lg font-semibold text-gray-900">{{ $cageotmois ?? '0' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau des dépenses -->
<div class="bg-white shadow-md mb-4 border-0 container mx-auto p-4">
    <!-- En-tête de section -->
    <div class="border-b border-gray-200">
        <div class="bg-blue-50 border-0 p-2">
            <h2 class="text-md font-semibold text-gray-800 flex items-center">
                <i class="fas fa-wine-bottle-alt text-gray-600 mr-3 text-lg"></i>
                Historique des achats d'emballage
                <span class="ml-3 text-sm font-normal text-gray-600 bg-gray-100 px-2 py-1 border-0">Inventaire</span>
            </h2>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="py-3">
        <!-- Message de succès -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative mb-6 border-0" role="alert">
            <div class="flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button type="button" class="text-green-700 hover:text-green-900" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Tableau -->
        <div class="overflow-x-auto border border-gray-200 border-0">
            <table class="min-w-full bg-white text-center" id="dataTable">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Date</th>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Description</th>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Montant</th>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Moyen de paiement</th>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Quantité</th>
                        <th class="py-2 px-4 border-b border-gray-600 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depenses ?? [] as $item)
                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                        <td class="py-4 px-4 font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-4 text-gray-700">
                            {{ $item->description }}
                        </td>
                        <td class="py-4 px-4 font-semibold text-gray-900">
                            {{ number_format($item->montant, 2, ',', ' ') }} Ar
                        </td>
                        <td class="py-4 px-4 text-gray-700">
                            {{ $item->mode_paye }}
                        </td>
                        <td class="py-4 px-4 text-gray-700">
                            {{ $item->quantite }}
                        </td>
                        <td class="py-4 px-4">
                            <form action="{{ route('depense.destroy', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 hover:bg-red-50 text-red-600 transition duration-200 border-0"
                                    onclick="return confirm('Supprimer cette dépense ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                                <p class="text-lg">Aucune dépense enregistrée</p>
                                <p class="text-sm text-gray-400 mt-1">Les dépenses apparaîtront ici</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    // Fonctions pour gérer le modal
    function openModal() {
        document.getElementById('depenseModal').classList.remove('hidden');
        document.getElementById('depenseModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('depenseModal').classList.remove('flex');
        document.getElementById('depenseModal').classList.add('hidden');
        // Réinitialiser le formulaire
        document.getElementById('depenseForm').reset();
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('depenseModal').addEventListener('click', function(e) {
        if (e.target.id === 'depenseModal') {
            closeModal();
        }
    });

    // Gérer la soumission du formulaire
    document.getElementById('depenseForm').addEventListener('submit', function(e) {
        // Validation côté client optionnelle
        const montant = document.getElementById('montant').value;
        const description = document.getElementById('description').value;

        if (!description.trim()) {
            e.preventDefault();
            alert('Veuillez saisir une description');
            return;
        }

        if (!montant || parseFloat(montant) <= 0) {
            e.preventDefault();
            alert('Veuillez saisir un montant valide');
            return;
        }
    });
</script>

@endsection