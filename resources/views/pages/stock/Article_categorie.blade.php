@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="max-w-screen-4xl mx-auto px-4 py-6">

    <!-- Onglets -->
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
                      {{ request()->routeIs('stock.categorie.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
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


    <!-- Card -->
    <div class="bg-white shadow rounded mb-6">
        <div class="flex justify-between items-center bg-gray-100 px-4 py-3 border-b">
            <h6 class="text-gray-800 font-semibold">ARTICLE CATEGORIE</h6>
            <a href="{{ url('/dashboard') }}"
                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded shadow-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour dashboard
            </a>
        </div>

        <!-- Filtres -->
        <div class="flex flex-wrap items-center gap-2 px-4 py-3">
            <form action="{{ route('stock.liste.id',['id'=> $categorie_id]) }}" method="GET" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                @csrf
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

                <!-- Tri -->
                <div class="relative">
                    <button type="button"
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded text-sm bg-white hover:bg-gray-50">
                        <i class="fas fa-sort mr-2"></i> Trier par
                    </button>
                    <ul class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded shadow-lg hidden group-hover:block z-10">
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="nom_asc">Nom (A-Z)</button></li>
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="nom_desc">Nom (Z-A)</button></li>
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="prix_asc">Prix (Croissant)</button></li>
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="prix_desc">Prix (Décroissant)</button></li>
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="stock_asc">Stock (Croissant)</button></li>
                        <li><button class="block w-full px-3 py-1.5 text-left text-sm hover:bg-gray-100" type="submit" value="stock_desc">Stock (Décroissant)</button></li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="p-4">
            <div class="">
                <table class="w-full border border-gray-200 text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2 border border-gray-200">ID</th>
                            <th class="px-3 py-2 border border-gray-200">Nom</th>
                            <th class="px-3 py-2 border border-gray-200">Catégorie</th>
                            <th class="px-3 py-2 border border-gray-200">Quantité</th>
                            <th class="px-3 py-2 border border-gray-200">Valeur réelle(Ar)</th>
                            <th class="px-3 py-2 border border-gray-200">Mise à jour</th>
                            <th class="px-3 py-2 border border-gray-200">Date création</th>
                            <th class="px-3 py-2 border border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border border-gray-200">{{ $article->id }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $article->nom }}</td>
                            <td class="px-3 py-2 border border-gray-200">{{ $article->categorie->nom }}</td>

                            <td class="px-3 py-2 border border-gray-200">
                                @php
                                $quotient = intdiv($article->quantite, $article->conditionnement);
                                $reste = $article->quantite % $article->conditionnement;
                                $affichage = $quotient;
                                @endphp
                                @if($article->quantite > 24)
                                <span class="text-green-600">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }} et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}</span>
                                @else
                                <span class="text-red-600">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }} et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}</span>
                                @endif
                            </td>

                            <td class="px-2 py-2 border border-gray-200">
    {{ number_format($article->quantite * $article->prix_gros, 0, ',', ' ') }} Ar
</td>
<td class="px-2 py-2 border border-gray-200">
    {{ number_format($article->quantite * $article->prix_unitaire, 0, ',', ' ') }} Ar
</td>
                            <td class="px-3 py-2 border border-gray-200">{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-3 py-2 border border-gray-200">
                                <div class="relative inline-block">
                                    <button onclick="toggleMenu({{ $article->id }})" class="text-gray-500 hover:text-gray-700 p-1 items-center ml-5">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="menu-{{ $article->id }}" class="hidden absolute right-0 mt-1 w-40 bg-white border border-gray-200 shadow-lg z-10">
                                        <a href="{{ route('achat.page') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                            <i class="fas fa-plus mr-2 text-blue-500"></i>Ajouter
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
                            <td colspan="8" class="px-3 py-4 text-center border border-gray-200">
                                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-3 py-2 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Pas de donnée trouvée --
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-4 py-3">
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

        <!-- Pagination -->
        
    </div>
</div>
@endsection