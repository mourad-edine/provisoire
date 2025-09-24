@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-6">

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
    </ul>

    <!-- Carte principale -->
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-4 py-3 bg-gray-50">
            <h6 class="text-gray-700 font-bold">STOCK FAIBLE</h6>
            <a href="{{ url('/dashboard') }}"
               class="bg-gray-700 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Retour dashboard
            </a>
        </div>

        <!-- Barre de recherche + filtres -->
        <div class="flex flex-wrap items-center gap-2 px-4 py-3">
            <form action="{{ route('stock.faible.liste') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @csrf
                <!-- Champ de recherche -->
                <input type="text" name="search" placeholder="Rechercher..."
                       value="{{ old('search', request('search')) }}"
                       class="w-64 border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">

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
            <div class="overflow-x-auto">
                <table class="w-full border text-sm text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-2 py-2">id</th>
                            <th class="px-2 py-2">nom</th>
                            <th class="px-2 py-2">categorie</th>
                            <th class="px-2 py-2">P.Vente</th>
                            <th class="px-2 py-2">P.Cageot</th>
                            <th class="px-2 py-2">quantite</th>
                            <th class="px-2 py-2">consignation</th>
                            <th class="px-2 py-2">mise à jour</th>
                            <th class="px-2 py-2">date</th>
                            <th class="px-2 py-2">ajouter</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2">{{ $article->id }}</td>
                            <td class="px-2 py-2">{{ $article->nom }}</td>
                            <td class="px-2 py-2">{{ $article->categorie_id }}</td>
                            <td class="px-2 py-2">{{ $article->prix_unitaire }} Ar</td>
                            <td class="px-2 py-2">{{ $article->prix_conditionne ? $article->prix_conditionne :'pas de prix' }} Ar</td>
                            <td class="px-2 py-2 text-red-600">
                                @php
                                    $quotient = intdiv($article->quantite, $article->conditionnement);
                                    $reste = $article->quantite % $article->conditionnement;
                                @endphp
                                {{ $quotient }} cageot{{ $quotient > 1 ? 's' : '' }}
                                @if($reste > 0) et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }} @endif
                            </td>
                            <td class="px-2 py-2">{{ $article->prix_consignation ? $article->prix_consignation .' Ar' :'pas de prix' }}</td>
                            <td class="px-2 py-2">{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td class="px-2 py-2">{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-2 py-2">
                                <a href="{{route('achat.page')}}" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="10" class="px-4 py-3">
                                <div class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded-md text-sm">
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
                    {{ $articles->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
