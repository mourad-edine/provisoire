@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid mx-auto px-4">
    <!-- En-tête de page -->
    <div class="flex items-center justify-between mb-6">
        <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 flex items-center gap-2" onclick="openModal()">
            <i class="fas fa-plus-circle text-white text-sm"></i> Nouvelle Dépense
        </button>
    </div>

    <!-- Modal pour ajouter une dépense -->
    <div id="depenseModal" 
     class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    
    <!-- Contenu du modal -->
    <div class="bg-white w-full max-w-3xl mx-4 rounded-lg shadow-lg p-6 relative">
        
        <!-- En-tête -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Nouvelle Dépense</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Formulaire -->
        <form id="depenseForm" action="{{ route('depense.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" id="description" name="description" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    placeholder="Description de la dépense">
            </div>

            <!-- Montant -->
            <div>
                <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Montant (Ar)</label>
                <input type="number" id="montant" name="montant" step="0.01" min="0" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    placeholder="0.00">
            </div>

            <!-- Quantité -->
            <div>
                <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                <input type="number" id="quantite" name="quantite" min="1" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <!-- Mode de paiement -->
            <div>
                <label for="mode_paye" class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                <select id="mode_paye" name="mode_paye" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Sélectionnez un mode de paiement</option>
                    <option value="Espèces">Espèces</option>
                    <option value="Carte bancaire">Carte bancaire</option>
                    <option value="Virement">Virement</option>
                    <option value="Chèque">Chèque</option>
                    <option value="Mobile Money">Mobile Money</option>
                </select>
            </div>

            <!-- Type de dépense -->
            

            <!-- Date -->
            <div>
                <label for="date_depense" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" id="date_depense" name="created_at"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    value="{{ date('Y-m-d') }}">
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3 pt-5 border-t">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                    Annuler
                </button>
                <button type="submit"
                    class="px-5 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>


    <!-- Cartes de synthèse -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Dépenses ce mois -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Dépenses ce mois</p>
                        <h5 class="text-lg font-semibold">{{ $totalmois ?? '0' }} Ar</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépenses du jour -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-day text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Aujourd'hui</p>
                        <h5 class="text-lg font-semibold">{{ $totalJour ?? '0' }} Ar</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouteille acheté aujourd'hui -->
       

        <!-- Bouteille acheté ce mois ci -->
       
    </div>

    <!-- Tableau des dépenses -->
    <div class="bg-white shadow-md rounded-lg mb-4">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h6 class="text-lg font-semibold text-gray-900">Historique des Dépenses</h6>
            <div class="relative">
                <a class="cursor-pointer p-2" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v text-gray-400 text-sm"></i>
                </a>
                <div class="absolute right-0 z-10 w-44 bg-white rounded-lg shadow-lg py-2 hidden dropdown-menu">
                    <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100">Options :</div>
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2" href="#">
                        <i class="fas fa-file-export"></i>Exporter
                    </a>
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2" href="#">
                        <i class="fas fa-filter"></i>Filtrer
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2" href="#">
                        <i class="fas fa-sync-alt"></i>Actualiser
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6 text-sm">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 text-center" id="dataTable">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 border-b">Date</th>
                            <th class="py-3 px-4 border-b">Description</th>
                            <th class="py-3 px-4 border-b">Montant</th>
                            <th class="py-3 px-4 border-b">Moyen de paiement</th>
                            <th class="py-3 px-4 border-b">Quantité</th>
                            <th class="py-3 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($depenses ?? [] as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ $item->description }}</td>
                            <td class="py-3 px-4 border-b font-semibold">{{ number_format($item->montant, 2, ',', ' ') }} Ar</td>
                            <td class="py-3 px-4 border-b">{{ $item->mode_paye }}</td>
                            <td class="py-3 px-4 border-b">{{ $item->quantite }}</td>
                            <td class="py-3 px-4 border-b">
                                <form action="{{ route('depense.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 hover:bg-gray-100 rounded" onclick="return confirm('Supprimer cette dépense ?')">
                                        <i class="fas fa-trash text-yellow-500"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">
                                Aucune dépense enregistrée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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