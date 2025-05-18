@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
   
    a {
        color: #333;
    }

    a:hover {
        color: #333;
    }

    .payment-card {
        transition: transform 0.2s;
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .badge-pill {
        padding: 5px 10px;
        font-size: 0.85em;
    }

    .table-responsive {
        min-height: 400px;
    }
</style>
<div class="">

    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('commande.liste.vente') }}">
                <button class="nav-link" id="commandes-tab">
                    <i class="fas fa-list-alt me-2"></i> Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{ route('vente.liste') }}">
                <button class="nav-link ">
                    <i class="fas fa-shopping-cart me-2"></i> Listes ventes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0">
                <button class="nav-link active">
                    <i class="fas fa-history me-2"></i> Historique des paiements
                </button>
            </a>
        </li>


    </ul>
    <!-- Filtres -->
    <!-- <div class="card mb-4">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date de</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date à</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i> Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->

    <!-- Tableau des paiements -->
    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white py-3 p-3">
        <h5 class="mb-0 font-weight-bold text-white">
            <i class="fas fa-receipt me-2"></i>VENTE - PAYEMENTS
        </h5>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-warning btn-sm text-white">
                <i class="fas fa-print me-1"></i>Facture
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left me-1 text-white"></i>Retour
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-secondary text-white">
                        <tr>
                            <th>#</th>
                            <th>Facture</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <td>type opération</td>
                            <th>Méthode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Paiement 1 -->
                        @forelse ($payements as $payement)

                        <tr>
                            <td>{{$payement->id}}</td>
                            <td>F-{{$payement->id}}-{{$commande->id}}</td>
                            <td>{{optional($commande->client)->nom  ? optional($commande->client)->nom : 'client occasionel'}}</td>
                            <td>{{$payement->somme . 'Ar'}}</td>
                            <td>{{$payement->created_at->format('d/m/y')}}</td>
                            <td>{{$payement->operation}}</td>
                            <td><span class="">{{$payement->mode_paye}}</span></td>
                            <td>
                                <button class="btn btn-sm">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class=""><div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pas de payement trouvé -- 
                    </div></td>
                        </tr>
                        @endforelse
                        <!-- Paiement 2 -->
                       

                        <!-- Paiement 3 -->

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-start mt-3">
                    {{ $payements->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>

            <!-- Pagination -->

        </div>
    </div>

    <!-- Stats résumé -->

</div>


@endsection