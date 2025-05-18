@extends('layouts.AdminLayout')

@section('title', 'Historique Paiements')

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
<div class="d-flex justify-content-between align-items-center mb-4">
        <ul class="nav nav-tabs" id="clientTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('client.profil', ['id' => $client_id]) }}">
                    <i class="fas fa-id-card me-2"></i>Profil client et Emballage
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{route('client.historique', ['id' => $client_id])}}">
                    <i class="fas fa-history me-2"></i> Historique
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('client.commande', ['id' => $client_id]) }}">
                    <i class="fas fa-wine-bottle me-2"></i>Commandes
                </a>
            </li>
        </ul>
        
        <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>


    <!-- Entête -->
    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white py-3 p-3">
        <h5 class="mb-0 font-weight-bold text-white">
            <i class="fas fa-receipt me-2"></i>Historique des Paiements de : {{ $clients->nom }}
        </h5>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-warning btn-sm text-white">
                <i class="fas fa-print me-1"></i> Facture
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
                <i class="fas fa-arrow-left me-1 text-white"></i> Retour
            </a>
        </div>
    </div>

    <!-- Tableau -->
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
                            <th>Type d'opération</th>
                            <th>Méthode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients->commandes as $commande)
                            @foreach ($commande->payements as $payement)
                                <tr>
                                    <td>{{ $payement->id }}</td>
                                    <td>F-{{ $payement->id }}-{{ $commande->id }}</td>
                                    <td>{{ $clients->nom ?? 'Client occasionnel' }}</td>
                                    <td>{{ number_format($payement->somme, 0, ',', ' ') }} Ar</td>
                                    <td>{{ \Carbon\Carbon::parse($payement->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $payement->operation }}</td>
                                    <td><span class="text-success fw-bold">{{ $payement->mode_paye }}</span></td>
                                    <td>
                                        <button class="btn btn-sm">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="8" class="">
                                    <div class="alert alert-warning mb-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Aucun paiement trouvé pour ce client.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
