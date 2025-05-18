@extends('layouts.AdminLayout')

@section('title', 'Gestion Client')

@section('content')
<div class="container-fluid px-4">

    <ul class="nav nav-tabs mb-4" id="clientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none; color : #333;" href="{{route('client.commande' , ['id'=> $client->id] )}}">
                <button class="nav-link active">
                    <i class="fas fa-id-card me-2"></i>Profil client & Emballage
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{route('client.historique' , ['id'=> $client->id] )}}">
                <i class="fas fa-history me-2"></i> Historique
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none; color : #333;" href="{{route('client.commande' , ['id'=> $client->id] )}}">
                <button class="nav-link">
                    <i class="fas fa-wine-bottle me-2"></i>Commandes
                </button>
            </a>
        </li>
    </ul>

    <div class="d-flex justify-content-end m-2">
        <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm fw-bold">
            Retour
        </a>
    </div>

    <div class="card shadow mb-4" style="border-top: #c0c0c0 solid 10px; border-radius: 0;">
        <div class="card-body bg-light">
            <div class="row">
                <!-- Identité client -->
                <div class="col-md-4 border-end pe-4">
                    <h6 class="text-uppercase text-dark mb-3 fw-bold">Identité client</h6>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Nom complet</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ $client->nom ?? 'Non renseigné' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Téléphone</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ $client->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Email</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ $client->email ?? 'Non renseigné'}}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Adresse</label>
                        <div class="d-flex">
                            <i class="fas fa-map-marker-alt me-2 text-secondary mt-1"></i>
                            <p class="fw-bold mb-0 small">{{ $client->adresse ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Données commerciales -->
                <div class="col-md-4 border-end pe-4">
                    <h6 class="text-uppercase text-dark mb-3 fw-bold">Données commerciales</h6>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Type de client</label>
                        <span class="fw-bold">{{ $client->type_client ?? 'Particulier' }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Dernière visite</label>
                        <div class="d-flex align-items-center">
                            <i class="far fa-calendar-alt me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ $derniereVisite }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Nombre de commandes</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ $client->commandes_count }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Commandes impayées</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                            <p class="fw-bold mb-0">{{ $client->nombre_com_no_paye }}</p>
                        </div>
                    </div>
                </div>

                <!-- Situation financière -->
                <div class="col-md-4 ps-4">
                    <h6 class="text-uppercase text-dark mb-3 fw-bold">Situation financière</h6>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Total commandes</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-receipt me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ number_format($client->commandes_total, 0, ',', ' ') }} Ar</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Créance totale</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ number_format($client->commandes_total_non_paye, 0, ',', ' ') }} Ar</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Paiements reçus</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hand-holding-usd me-2 text-secondary"></i>
                            <p class="fw-bold mb-0">{{ number_format($client->payement_fait, 0, ',', ' ') }} Ar</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Reste à payer</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-balance-scale me-2 {{ $client->reste_a_payer > 0 ? 'text-danger' : 'text-success' }}"></i>
                            <p class="fw-bold mb-0 {{ $client->reste_a_payer > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($client->reste_a_payer, 0, ',', ' ') }} Ar
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1 d-block fw-bold">Consignes en cours</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-boxes me-2 text-secondary"></i>
                            <div>
                                <span class="me-2 fw-bold">{{ $client->sum_cgt }} cageots</span>
                                <span class="fw-bold text-dark">{{ $client->sum_btl }} bouteilles</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des commandes récentes -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Dernières commandes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>N° Commande</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{ $commande->id }}</td>
                            <td>{{ $commande->created_at }}</td>
                            <td>{{ number_format($commande->ventes->sum('total'), 0, ',', ' ') }} Ar</td>
                            <td>
                                <span class="badge badge-{{ $commande->etat_commande == 'payé' ? 'success' : 'danger' }}">
                                    {{ ucfirst($commande->etat_commande) }}
                                </span>
                            </td>
                            <td>
                                <a href="" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune commande trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    </div> -->

</div>
@endsection