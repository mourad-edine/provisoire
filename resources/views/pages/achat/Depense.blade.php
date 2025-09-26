@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid mx-auto px-4">
    <!-- En-tête de page -->
    <div class="flex items-center justify-between mb-6">
        <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 flex items-center gap-2" data-toggle="modal" data-target="#addExpenseModal">
            <i class="fas fa-plus-circle text-white text-sm"></i> Nouvelle Dépense
        </button>
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
                        <h5 class="text-lg font-semibold">{{$totalmois . ' Ar'}}</h5>
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
                        <h5 class="text-lg font-semibold">{{$totalJour . ' Ar'}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouteille acheté aujourd'hui -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center mr-3">
                        <i class="fas fa-wine-bottle text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Bouteille acheté aujourd'hui</p>
                        <h5 class="text-lg font-semibold">{{$bouteillejour}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouteille acheté ce mois ci -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center mr-3">
                        <i class="fas fa-wine-bottle text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Bouteille acheté ce mois-ci</p>
                        <h5 class="text-lg font-semibold">{{$bouteillemois}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cageot acheté aujourd'hui -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center mr-3">
                        <i class="fas fa-box text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cageot acheté aujourd'hui</p>
                        <h5 class="text-lg font-semibold">{{$cageotjour}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cageot acheté ce mois ci -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 h-full">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center mr-3">
                        <i class="fas fa-box-open text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Cageot acheté ce mois-ci</p>
                        <h5 class="text-lg font-semibold">{{$cageotmois}}</h5>
                    </div>
                </div>
            </div>
        </div>
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
                        @foreach($depense as $item)
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
                                    <button class="p-1 hover:bg-gray-100 rounded" onclick="return confirm('Supprimer cette dépense ?')">
                                        <i class="fas fa-trash text-yellow-500"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de dépense -->
<div class="modal fade fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <form id="expenseForm" method="POST" action="{{ route('depense.store') }}">
            @csrf
            <div class="bg-gray-800 text-white px-6 py-4 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-semibold" id="addExpenseModalLabel">Nouvelle Dépense</h5>
                    <button type="button" class="text-white text-2xl" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="px-6 py-4 space-y-4">
                <div class="space-y-2">
                    <label for="montant" class="block text-sm font-medium text-gray-700">Montant (Ar)</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="montant" id="montant" required>
                </div>

                <div id="quantiteContainer" class="space-y-2">
                    <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="quantite" id="quantite" min="1">
                </div>

                <div class="space-y-2">
                    <label for="mode_paye" class="block text-sm font-medium text-gray-700">Moyen de paiement</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="mode_paye" id="mode_paye" required>
                        <option value="Espèces">Espèces</option>
                        <option value="Mobile Money">Mobile Money</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (optionel <span class="text-red-500">*</span>)</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="description" id="description" required>
                        <option value="Bouteille">Bouteille</option>
                        <option value="cageot">cageot</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end gap-3">
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200" data-dismiss="modal">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialisation du DataTable
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
            "order": [
                [0, "desc"]
            ]
        });

        // Gestion de l'ajout de dépense
        $('#addExpenseBtn').click(function() {
            // Ici, vous pouvez ajouter la logique pour enregistrer la dépense
            alert('Fonctionnalité à implémenter: Enregistrement de la dépense');
        });
    });
</script>
@endsection     