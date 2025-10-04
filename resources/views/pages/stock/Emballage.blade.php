@extends('layouts.AdminLayout')

@section('title', 'Détails emballage')

@section('content')
<div class="max-w-screen-4xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <a href="{{ route('stock.liste') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-warehouse mr-1"></i> Listes globales
                    </a>
                </li>
                <li class="mr-2" role="presentation">
                    <a href="{{ route('stock.faible.liste') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.faible.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Stocks faibles
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ route('stock.categorie.liste') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.categorie.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-large mr-1"></i> Catégories
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ route('sortie.stat') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('sortie.stat') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-recycle mr-1"></i> Mouvement stock
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ route('emballage.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('emballage.index') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-recycle mr-1"></i> Emballages
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <a href="{{route('emballage.achat')}}" class="p-2 border-none bg-blue-600 text-white"> <i class="fa fa-plus"></i> acheter</a>
        </div>
    </div>
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Section Bouteilles Vides - Bières et Softs -->
    <div id="emptyBottlesSection">
        <div class="bg-white shadow-sm p-6 mb-6 border border-gray-100">
            <div class="bg-blue-50 border border-gray-200 p-4 mb-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-wine-bottle-alt text-gray-600 mr-3 text-lg"></i>
                    Bouteilles Vides - Bierre & boissoins-gazeuse
                    <span class="ml-3 text-sm font-normal text-gray-600 bg-gray-100 px-2 py-1">Inventaire</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($emballages as $type => $data)
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Bouteilles {{ $type }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{route('emballage.bouteille' , ['type' => $type])}}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200" title="Modifier">
                                <i class="fas fa-list"></i>
                            </a>

                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-white border border-gray-100">
                            <span class="text-sm text-gray-700">Total bouteilles</span>
                            <div id="display-bouteille-{{ $type }}" class="flex items-center space-x-2">
                                <span class="text-sm font-semibold text-gray-700">{{ $data['total_vide'] }}</span>
                            </div>

                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">{{ number_format($data['valeur_reelle'], 0, ',', ' ') }} Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">-------</span>
                            </div>
                            <div class="flex justify-between font-semibold text-sm">
                                <span class="text-gray-700">Total:</span>
                                <span class="text-gray-700">{{ $data['total_vide'] }} bouteilles</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Cageots Vides -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($cageots as $cageot)
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Cageot de {{$cageot->type_cageot}} Bouteilles</h3>
                        <div class="flex space-x-2">
                            <button onclick="toggleEdit('cageot-{{ $cageot->id }}')" class="text-blue-600 hover:text-blue-800 transition-colors duration-200" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="resetQuantity('cageot-{{ $cageot->id }}')" class="text-red-600 hover:text-red-800 transition-colors duration-200" title="Réinitialiser">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-white border border-gray-100">
                            <span class="text-sm text-gray-700">Total cageots</span>
                            <div id="display-cageot-{{ $cageot->id }}" class="flex items-center space-x-2">
                                <span class="text-sm font-semibold text-gray-700">{{$cageot->quantite}}</span>
                            </div>
                            <div id="edit-cageot-{{ $cageot->id }}" class="hidden">
                                <form id="form-cageot-{{ $cageot->id }}" class="flex items-center space-x-2" method="POST" action="{{ route('emballage.edit') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type" value="cageot">
                                    <input type="hidden" name="id" value="{{ $cageot->id }}">
                                    <input type="number" name="quantite" value="{{$cageot->quantite}}" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                    <button type="submit" class="text-green-600 hover:text-green-800" title="Valider">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="cancelEdit('cageot-{{ $cageot->id }}')" class="text-gray-600 hover:text-gray-800" title="Annuler">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">{{$cageot->quantite * $cageot->prix}}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">------</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section Bouteilles Vides - Alcools Forts -->
        <div class="bg-white shadow-sm p-6 border border-gray-100">
            <div class="bg-blue-50 border border-gray-200 p-4 mb-4 flex flex-wrap justify-between items-center rounded-lg">
    <!-- Titre à gauche -->
    <div class="flex items-center">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-glass-whiskey text-gray-600 mr-3 text-lg"></i>
            Bouteilles Vides - Alcools Forts
            <span class="ml-3 text-sm font-normal text-gray-600 bg-gray-100 px-2 py-1 rounded">
                Inventaire
            </span>
        </h2>
    </div>

    <!-- Barre de recherche à droite -->
    <div class="bg-gray-100 px-4 py-3 rounded-lg flex items-center gap-3">
        <form action="{{ route('emballage.index') }}" method="GET" class="flex items-center gap-3">
            <div class="relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ old('search', request('search')) }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Rechercher..."
                >
            </div>
            <button 
                type="submit"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white text-gray-600 hover:bg-gray-50 flex items-center transition"
            >
                <i class="fas fa-search mr-2"></i>
                Rechercher
            </button>
        </form>
    </div>
</div>


            <!-- Tableau des bouteilles -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                Nom
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                Quantité
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200">
                                Valeur (Ar)
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($articles as $article)
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-1 h-6 bg-gray-500 mr-3"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{$article->nom}}</div>
                                        <div class="text-xs text-gray-500"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <div id="display-alcool-{{ $article->id }}">
                                        <span class="text-sm font-semibold text-gray-700">
                                            {{$article->vides}} bouteilles
                                        </span>
                                    </div>
                                    <div id="edit-alcool-{{ $article->id }}" class="hidden">
                                        <form id="form-alcool-{{ $article->id }}" class="flex items-center space-x-2" method="POST" action="{{ route('emballage.bouteille.edit') }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="type" value="alcool">
                                            <input type="hidden" name="id" value="{{ $article->id }}">
                                            <input type="number" name="quantite" value="{{$article->vides}}" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                            <button type="submit" class="text-green-600 hover:text-green-800" title="Valider">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" onclick="cancelEdit('alcool-{{ $article->id }}')" class="text-gray-600 hover:text-gray-800" title="Annuler">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <span class="text-sm font-semibold text-green-600">
                                    {{$article->vides * $article->prix_consignation}} Ar
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap relative">
                                <div class="flex justify-center">
                                    <!-- Bouton menu -->
                                    <button onclick="toggleMenu('menu-{{ $article->id }}')"
                                        class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>

                                <!-- Menu déroulant caché par défaut -->
                                <div id="menu-{{ $article->id }}"
                                    class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow-md z-10">
                                    <button onclick="toggleEdit('alcool-{{ $article->id }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                        <i class="fas fa-edit mr-2"></i> Modifier
                                    </button>
                                    <button onclick="resetQuantity('alcool-{{ $article->id }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-undo mr-2"></i> Réinitialiser
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-200">
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700 border-r border-gray-200">
                                TOTAL
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200">
                                <span class="text-sm font-bold text-gray-800">
                                    {{$articles->sum('vides')}} bouteilles
                                </span>
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200">
                                <span class="text-sm font-bold text-green-700">
                                    {{$articles->sum(fn($a) => $a->vides * $a->prix_consignation)}} Ar
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                Dernière mise à jour
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Résumé minimal -->
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="bg-gray-50 border border-gray-100 p-3 text-center">
                    <div class="text-lg font-bold text-gray-700">{{ $articles->sum('vides') }}bouteilles</div>
                    <div class="text-xs text-gray-600">Total bouteilles</div>
                </div>
                <div class="bg-green-50 border border-green-100 p-3 text-center">
                    <div class="text-lg font-bold text-green-700">{{$articles->sum(fn($a) => $a->vides * $a->prix_consignation)}} Ar</div>
                    <div class="text-xs text-green-600">Valeur totale</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMenu(id) {
        // Fermer tous les autres menus
        document.querySelectorAll('[id^="menu-"]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });

        // Ouvrir/fermer le menu cliqué
        const menu = document.getElementById(id);
        menu.classList.toggle('hidden');
    }

    // Fermer si on clique à l'extérieur
    document.addEventListener('click', function(e) {
        if (!e.target.closest('td')) {
            document.querySelectorAll('[id^="menu-"]').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });

    // Fonction pour basculer entre l'affichage et l'édition
    function toggleEdit(elementId) {
        const displayElement = document.getElementById(`display-${elementId}`);
        const editElement = document.getElementById(`edit-${elementId}`);

        displayElement.classList.add('hidden');
        editElement.classList.remove('hidden');
    }

    // Fonction pour annuler l'édition
    function cancelEdit(elementId) {
        const displayElement = document.getElementById(`display-${elementId}`);
        const editElement = document.getElementById(`edit-${elementId}`);

        displayElement.classList.remove('hidden');
        editElement.classList.add('hidden');
    }

    // Fonction pour réinitialiser la quantité
    function resetQuantity(elementId) {
        if (confirm('Êtes-vous sûr de vouloir réinitialiser cette quantité à 0 ?')) {
            const form = document.getElementById(`form-${elementId}`);
            const input = form.querySelector('input[name="quantite"]');

            // Mettre la valeur à 0
            input.value = 0;

            // Soumettre le formulaire automatiquement
            form.submit();
        }
    }

    // Ajouter un écouteur d'événement pour la confirmation sur la soumission des formulaires
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[id^="form-"]');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const input = this.querySelector('input[name="quantite"]');
                const newValue = input.value;
                const type = this.querySelector('input[name="type"]').value;
                const id = this.querySelector('input[name="id"]').value;

                if (confirm(`Êtes-vous sûr de vouloir modifier la quantité à ${newValue} ?`)) {
                    // Soumettre le formulaire
                    this.submit();
                }
            });
        });
    });
</script>



@endsection