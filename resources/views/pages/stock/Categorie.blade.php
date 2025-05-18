@extends('layouts.AdminLayout')

@section('title', 'Gestion des stocks')

@section('content')
<div class="container-fluid">

    <!-- Onglets -->
    <ul class="nav nav-tabs mb-1 border-bottom" id="parametresTabs" role="tablist">
        <li class="nav-item me-2" role="presentation">
            <a href="{{ route('stock.liste') }}" class="nav-link {{ request()->routeIs('stock.liste') ? 'active' : '' }}">
                <i class="fas fa-warehouse me-1"></i>Listes globales
            </a>
        </li>
        <li class="nav-item me-2" role="presentation">
            <a href="{{ route('stock.faible.liste') }}" class="nav-link {{ request()->routeIs('stock.faible.liste') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle me-1"></i>Stocks faibles
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('stock.categorie.liste') }}" class="nav-link {{ request()->routeIs('stock.categorie.liste') ? 'active' : '' }}">
                <i class="fas fa-th-large me-1"></i>Catégories
            </a>
        </li>
    </ul>

    <!-- Cartes -->
    <div class="row">
        @forelse($categories as $categorie)
        @php
            $iconList = ['box-open', 'warehouse', 'cubes', 'pallet'];
            $icon = $iconList[$loop->index % count($iconList)];
        @endphp

        <div class="col-xl-3 col-md-6 mb-2">
            <a href="{{ route('stock.liste.id', ['id' => $categorie->id]) }}" class="text-decoration-none text-reset">
                <div class="card h-100 border border-secondary-subtle shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">{{ $categorie->nom }}</h6>
                                <h4 class="mb-0 fw-semibold">{{ $categorie->articles_count }} <small class="text-muted">articles</small></h4>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="card text-center shadow-sm border">
                <div class="card-body py-5">
                    <i class="fas fa-box-open fa-3x text-secondary mb-3"></i>
                    <h5 class="fw-semibold">Aucune catégorie disponible</h5>
                    <p class="text-muted">Vous n'avez pas encore créé de catégories pour vos articles.</p>
                    <a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-1"></i>Ajouter une catégorie
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

   

    .icon-square {
        width: 2.75rem;
        height: 2.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.25rem;
        font-size: 1.25rem;
    }

    .nav-tabs .nav-link {
        color: #333;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom: 2px solid #000;
    }

    .card {
        border-radius: 0px;
    }
</style>
@endsection
