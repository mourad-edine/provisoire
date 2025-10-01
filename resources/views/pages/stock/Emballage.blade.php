@extends('layouts.AdminLayout')

@section('title', 'Détails emballage')

@section('content')
<div class="max-w-screen-4xl mx-auto px-4 py-6">
    <!-- En-tête -->
    <!-- <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Emballages</h1>
        <div class="flex space-x-4">
            <button id="toggleView" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2  transition-colors duration-200">
                Voir Bouteilles Pleines
            </button>
        </div>
    </div> -->
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
                <!-- Bouteilles 30-33cl -->
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Bouteilles 30-33cl</h3>
                        <i class="fas fa-wine-bottle text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">

                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">340,50 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">15 Nov 2023</span>
                            </div>
                            <div class="flex justify-between font-semibold text-sm">
                                <span class="text-gray-700">Total:</span>
                                <span class="text-gray-700">110 bouteilles</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouteilles 50-65cl -->
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Bouteilles 50-65cl</h3>
                        <i class="fas fa-wine-bottle text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">

                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">275,80 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">14 Nov 2023</span>
                            </div>
                            <div class="flex justify-between font-semibold text-sm">
                                <span class="text-gray-700">Total:</span>
                                <span class="text-gray-700">55 bouteilles</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouteilles 100cl -->
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Bouteilles 100cl</h3>
                        <i class="fas fa-wine-bottle text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">

                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">190,25 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">16 Nov 2023</span>
                            </div>
                            <div class="flex justify-between font-semibold text-sm">
                                <span class="text-gray-700">Total:</span>
                                <span class="text-gray-700">38 bouteilles</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cageots Vides -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Cageot 24 Bouteilles</h3>
                        <i class="fas fa-box text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-white border border-gray-100">
                            <span class="text-sm text-gray-700">Total cageots</span>
                            <span class="text-sm font-semibold text-gray-700">8</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">96,00 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">13 Nov 2023</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Cageot 20 Bouteilles</h3>
                        <i class="fas fa-box text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-white border border-gray-100">
                            <span class="text-sm text-gray-700">Total cageots</span>
                            <span class="text-sm font-semibold text-gray-700">6</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">72,00 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">14 Nov 2023</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Cageot 6 Bouteilles</h3>
                        <i class="fas fa-box text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-white border border-gray-100">
                            <span class="text-sm text-gray-700">Total cageots</span>
                            <span class="text-sm font-semibold text-gray-700">10</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Valeur réelle:</span>
                                <span class="font-semibold text-green-600">45,00 Ar</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mise à jour:</span>
                                <span class="text-gray-500">15 Nov 2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Bouteilles Vides - Alcools Forts -->
        <div class="bg-white shadow-sm p-6 border border-gray-100">
            <div class="bg-blue-50 border border-gray-200 p-4 mb-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-glass-whiskey text-gray-600 mr-3 text-lg"></i>
                    Bouteilles Vides - Alcools Forts
                    <span class="ml-3 text-sm font-normal text-gray-600 bg-gray-100 px-2 py-1">Inventaire</span>
                </h2>
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
                                Mise à jour
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Exemple 1 -->
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-1 h-6 bg-gray-500 mr-3"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Whisky Jack Daniel's</div>
                                        <div class="text-xs text-gray-500">70cl</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <span class="text-sm font-semibold text-gray-700">
                                    18 bouteilles
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <span class="text-sm font-semibold text-green-600">
                                    450,00 Ar
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                15 Nov 2023
                            </td>
                        </tr>

                        <!-- Exemple 2 -->
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-1 h-6 bg-gray-600 mr-3"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Vodka Grey Goose</div>
                                        <div class="text-xs text-gray-500">150cl</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <span class="text-sm font-semibold text-gray-700">
                                    8 bouteilles
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border-r border-gray-200">
                                <span class="text-sm font-semibold text-green-600">
                                    400,00 Ar
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                14 Nov 2023
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-200">
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700 border-r border-gray-200">
                                TOTAL
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200">
                                <span class="text-sm font-bold text-gray-800">
                                    26 bouteilles
                                </span>
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200">
                                <span class="text-sm font-bold text-green-700">
                                    850,00 Ar
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
                    <div class="text-lg font-bold text-gray-700">26</div>
                    <div class="text-xs text-gray-600">Total bouteilles</div>
                </div>
                <div class="bg-green-50 border border-green-100 p-3 text-center">
                    <div class="text-lg font-bold text-green-700">850 Ar</div>
                    <div class="text-xs text-green-600">Valeur totale</div>
                </div>
            </div>
        </div>
    </div>


</div>


@endsection