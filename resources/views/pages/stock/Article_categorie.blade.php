@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="w-full px-4">

    <!-- Onglets -->
    <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
        <li class="mr-2">
            <a href="{{route('stock.liste')}}" class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                {{ request()->routeIs('stock.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-wine-bottle mr-2"></i> Listes globales
            </a>
        </li>
        <li class="mr-2">
            <a href="{{route('stock.faible.liste')}}" class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                {{ request()->routeIs('stock.faible.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-user mr-2"></i> Stock faible
            </a>
        </li>
        <li>
            <a href="{{route('stock.categorie.liste')}}" class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                {{ request()->routeIs('stock.categorie.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-user mr-2"></i> Catégorie
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
                <input type="text" 
                       class="border border-gray-300 rounded text-sm px-3 py-1.5 focus:ring focus:ring-blue-200 focus:outline-none" 
                       name="search" 
                       placeholder="Rechercher..." 
                       value="{{ old('search', request('search')) }}">

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
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-3 py-2 border">ID</th>
                        <th class="px-3 py-2 border">Nom</th>
                        <th class="px-3 py-2 border">Catégorie</th>
                        <th class="px-3 py-2 border">P. Vente</th>
                        <th class="px-3 py-2 border">P.C</th>
                        <th class="px-3 py-2 border">Quantité</th>
                        <th class="px-3 py-2 border">Consignation</th>
                        <th class="px-3 py-2 border">Mise à jour</th>
                        <th class="px-3 py-2 border">Date création</th>
                        <th class="px-3 py-2 border">Ajouter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $article->id }}</td>
                        <td class="px-3 py-2 border">{{ $article->nom }}</td>
                        <td class="px-3 py-2 border">{{ $article->categorie_id }}</td>
                        <td class="px-3 py-2 border">{{ $article->prix_unitaire }} Ar</td>
                        <td class="px-3 py-2 border">{{ $article->prix_conditionne ? $article->prix_conditionne .' Ar' : 'pas de prix' }}</td>
                        <td class="px-3 py-2 border">
                            @php
                                $quotient = intdiv($article->quantite, $article->conditionnement);
                                $reste = $article->quantite % $article->conditionnement;
                                $affichage = $quotient;
                            @endphp
                            @if($quotient > 0)
                                <span class="text-green-600">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}</span>
                            @else
                                <span class="text-red-600">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}</span>
                            @endif
                            @if($reste > 0)
                                et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}
                            @endif
                        </td>
                        <td class="px-3 py-2 border">{{ $article->prix_consignation ? $article->prix_consignation . ' Ar' : 'pas de prix' }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                        <td class="px-3 py-2 border text-center">
                            <a href="{{ route('achat.page') }}" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-3 py-4 text-center">
                            <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 px-3 py-2 rounded">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Pas de donnée trouvée --
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3">
            {{ $articles->appends(['search' => request('search')])->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
