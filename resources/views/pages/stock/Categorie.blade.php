@extends('layouts.AdminLayout')

@section('title', 'Gestion des stocks')

@section('content')
<div class="w-full px-4">

    <!-- Onglets -->
    <ul class="flex border-b mb-3" id="parametresTabs" role="tablist">
        <li class="mr-2" role="presentation">
            <a href="{{ route('stock.liste') }}" 
               class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                      {{ request()->routeIs('stock.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-warehouse mr-2"></i> Listes globales
            </a>
        </li>
        <li class="mr-2" role="presentation">
            <a href="{{ route('stock.faible.liste') }}" 
               class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                      {{ request()->routeIs('stock.faible.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-exclamation-triangle mr-2"></i> Stocks faibles
            </a>
        </li>
        <li role="presentation">
            <a href="{{ route('stock.categorie.liste') }}" 
               class="inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium 
                      {{ request()->routeIs('stock.categorie.liste') ? 'border-black text-black' : 'border-transparent text-gray-600 hover:text-black hover:border-gray-300' }}">
                <i class="fas fa-th-large mr-2"></i> Catégories
            </a>
        </li>
    </ul>

    <!-- Cartes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @forelse($categories as $categorie)
        @php
            $iconList = ['box-open', 'warehouse', 'cubes', 'pallet'];
            $icon = $iconList[$loop->index % count($iconList)];
        @endphp

        <a href="{{ route('stock.liste.id', ['id' => $categorie->id]) }}" class="block">
            <div class="bg-white h-full border border-gray-200 rounded shadow-sm transform transition hover:-translate-y-1 hover:shadow-md">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h6 class="text-gray-500 uppercase text-xs mb-1">{{ $categorie->nom }}</h6>
                            <h4 class="text-lg font-semibold">
                                {{ $categorie->articles_count }}
                                <small class="text-gray-500">articles</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        @empty
        <div class="col-span-full">
            <div class="bg-white border border-gray-200 rounded shadow-sm text-center p-8">
                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                <h5 class="text-lg font-semibold">Aucune catégorie disponible</h5>
                <p class="text-gray-500 mb-4">Vous n'avez pas encore créé de catégories pour vos articles.</p>
                <a href="#" 
                   class="inline-flex items-center px-4 py-2 border border-gray-400 rounded text-gray-700 hover:bg-gray-100 transition"
                   data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fas fa-plus mr-2"></i> Ajouter une catégorie
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
