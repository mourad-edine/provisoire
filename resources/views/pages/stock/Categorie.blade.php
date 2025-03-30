@extends('layouts.AdminLayout')

@section('title', 'Gestion des stocks')

@section('content')
<div class="container-fluid px-4">

    <div class="shadow mb-4">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a style="text-decoration: none;" href="{{route('stock.liste')}}">
                        <button class="nav-link " id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                            <i class="fas fa-wine-bottle me-2"></i>Listes globales
                        </button>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a style="text-decoration: none;" href="{{route('stock.faible.liste')}}">
                        <button class="nav-link " id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                            <i class="fas fa-user me-2"></i>Stock faibles
                        </button>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a style="text-decoration: none;" href="{{route('stock.categorie.liste')}}">
                        <button class="nav-link active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                            <i class="fas fa-user me-2"></i>Categorie
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Categories Cards -->
    <div class="row">
        @forelse($categories as $categorie)
        @php
        $colorClasses = [
        0 => ['border' => 'primary', 'icon' => 'box-open'],
        1 => ['border' => 'success', 'icon' => 'wine-bottle'],
        2 => ['border' => 'info', 'icon' => 'cubes'],
        3 => ['border' => 'warning', 'icon' => 'pallet']
        ];
        $index = $loop->index % 4;
        $currentColor = $colorClasses[$index];
        @endphp

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-lg border-start-{{ $currentColor['border'] }} shadow-sm h-100 hover-lift">
                <a class="text-decoration-none" href="{{ route('stock.liste.id', ['id' => $categorie->id]) }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2 small">{{ $categorie->nom }}</h6>
                                <h3 class="mb-0">{{ $categorie->articles_count }} <small class="text-muted">articles</small></h3>
                            </div>
                            <div class="icon-circle bg-{{ $currentColor['border'] }}-subtle">
                                <i class="fas fa-{{ $currentColor['icon'] }} text-{{ $currentColor['border'] }}"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune catégorie disponible</h5>
                    <p class="text-muted mb-4">Vous n'avez pas encore créé de catégories pour vos articles.</p>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-2"></i>Ajouter une catégorie
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
    .icon-circle {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-pills .nav-link.active {
        background-color: #4e73df;
        color: white;
    }

    .nav-pills .nav-link {
        color: #4e73df;
        border: 1px solid #dddfeb;
    }

    .border-start-lg {
        border-left-width: 0.25rem !important;
    }
</style>
@endsection