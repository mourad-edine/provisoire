@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="max-w-screen-4xl mx-auto px-4 py-6">

    <!-- Onglets de navigation -->
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

    <!-- Carte principale -->
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-4 py-3">
            <h6 class="text-gray-700 font-bold">LISTE GLOBALE</h6>
            <a href="{{ url('/dashboard') }}"
                class="bg-gray-700 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Retour dashboard
            </a>
        </div>

        <!-- Barre de recherche + filtres -->
        <div class="flex flex-wrap items-center gap-2 px-4 py-3">
            <form action="{{ route('stock.liste') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @csrf
                <!-- Champ de recherche -->
                <div class="relative w-72">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Rechercher..."
                        value="{{ old('search', request('search')) }}"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
               shadow-sm transition duration-200">
                </div>


                <!-- Dropdown tri -->
                <div class="relative">
                    <button type="button"
                        class="inline-flex items-center px-3 py-1.5 text-sm border rounded-md text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-sort mr-1"></i> Trier par
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul class="absolute mt-1 w-40 bg-white border rounded-md shadow z-10 hidden group-hover:block">
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="nom_asc">Nom (A-Z)</button></li>
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="nom_desc">Nom (Z-A)</button></li>
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="prix_asc">Prix (Croissant)</button></li>
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="prix_desc">Prix (Décroissant)</button></li>
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="stock_asc">Stock (Croissant)</button></li>
                        <li><button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100" type="submit" value="stock_desc">Stock (Décroissant)</button></li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="p-4">
            <div class="">
                <table class="w-full border border-gray-200 text-sm text-center">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-2 py-2 border border-gray-200">id</th>
                            <th class="px-2 py-2 border border-gray-200">nom</th>
                            <th class="px-2 py-2 border border-gray-200">categorie</th>
                            <th class="px-2 py-2 border border-gray-200">quantite</th>
                            <th class="px-2 py-2 border border-gray-200">valeur réelle détails(Ar)</th>
                            <th class="px-2 py-2 border border-gray-200">valeur réelle gros(Ar)</th>
                            <th class="px-2 py-2 border border-gray-200">mise à jour</th>
                            <th class="px-2 py-2 border border-gray-200">actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 border border-gray-200">{{ $article->id }}</td>
                            <td class="px-2 py-2 border border-gray-200">{{ $article->nom }}</td>
                            <td class="px-2 py-2 border border-gray-200">{{ $article->categorie->nom }}</td>
                            <td class="px-2 py-2 border border-gray-200">
                                @php
                                $quotient = intdiv($article->quantite, $article->conditionnement);
                                $reste = $article->quantite % $article->conditionnement;
                                @endphp
                                @if($article->quantite > 24)
                                <span class="text-green-600">{{ $quotient }} cageot{{ $quotient > 1 ? 's' : '' }} et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}</span>
                                @else
                                <span class="text-red-600">{{ $quotient }} cageot{{ $quotient > 1 ? 's' : '' }} et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 border border-gray-200">
                                {{ number_format($article->quantite * $article->prix_gros, 0, ',', ' ') }} Ar
                            </td>
                            <td class="px-2 py-2 border border-gray-200">
                                {{ number_format($article->quantite * $article->prix_unitaire, 0, ',', ' ') }} Ar
                            </td>

                            <td class="px-2 py-2 border border-gray-200">{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-2 py-2 border border-gray-200">
                                <div class="relative inline-block">
                                    <button onclick="toggleMenu({{ $article->id }})" class="text-gray-500 hover:text-gray-700 p-1">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="menu-{{ $article->id }}" class="hidden absolute right-0 mt-1 w-40 bg-white border border-gray-200 shadow-lg z-10">
                                        <a href="{{route('achat.page')}}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                            <i class="fas fa-plus text-blue-500 mr-2"></i>Ajouter
                                        </a>
                                        <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                            <i class="fas fa-trash mr-2 text-red-500"></i>Supprimer
                                        </a>
                                        <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2 text-green-500"></i>Voir
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-3 border border-gray-200">
                                <div class="bg-yellow-50 text-yellow-700 px-3 py-2 border border-yellow-200 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Pas de donnée trouvé --
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->appends(['search' => request('search')])->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <script>
            function toggleMenu(articleId) {
                const menu = document.getElementById('menu-' + articleId);
                // Fermer tous les autres menus ouverts
                document.querySelectorAll('[id^="menu-"]').forEach(otherMenu => {
                    if (otherMenu.id !== 'menu-' + articleId) {
                        otherMenu.classList.add('hidden');
                    }
                });
                menu.classList.toggle('hidden');
            }

            // Fermer le menu quand on clique ailleurs
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });
        </script>
    </div>

</div>
@endsection