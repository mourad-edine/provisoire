@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">
    <!-- Navigation par onglets -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ul class="nav nav-tabs" id="clientTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('client.profil', ['id' => $client_id]) }}">
                    <i class="fas fa-id-card me-2"></i>Profil client et Emballage
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{route('client.historique', ['id' => $client_id])}}">
                    <i class="fas fa-history me-2"></i> Historique
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('client.commande', ['id' => $client_id]) }}">
                    <i class="fas fa-wine-bottle me-2"></i>Commandes
                </a>
            </li>
        </ul>
        
        <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <!-- Formulaire de recherche -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <input type="hidden" name="client_id" value="{{ $client_id }}">

                <div class="col-md-2">
                    <label for="search" class="form-label">Nom | N° commande</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Rechercher...">
                </div>
                <div class="col-md-2">
                    <label for="date_debut" class="form-label">Date début</label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label for="date_fin" class="form-label">Date fin</label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label for="tri" class="form-label">Trier par date</label>
                    <select name="tri" id="tri" class="form-select form-select-sm">
                        <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                        <option value="asc" {{ request('tri') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-dark btn-sm">
                        <i class="fas fa-search me-1"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des commandes -->
    <div class="card shadow">
    <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>id client</th>
                            <th>date commande</th>
                            <th>nombre d'achat</th>
                            <th>sous-total</th>
                            <th>consignation</th>
                            <th>total</th>
                            <th>état</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>C-{{$commande->id}}</td>
                            <td>{{$commande->client ? $commande->client->nom : 'client passager'}}</td>
                            <td>{{$commande->created_at}}</td>
                            <td>{{$commande->ventes_count}} </td>
                            <td>{{$commande->ventes_total }}Ar</td>
                            <td>
                                @if($commande->etat_client == 1)
                                <span class="fw-boldtext-danger"> à rendre</span>
                                @elseif($commande->etat_client == 2)
                                <span class="fw-bold text-danger">à disposition</span>
                                @else
                                {{ number_format(
                                        $commande->ventes_consignation_sum_prix 
                                        + $commande->ventes_consignation_sum_prix_cgt 
                                        + optional($commande->conditionnement)->nombre_cageot * $cgt, 
                                        0, ',', ' '
                                ) }} Ar
                                @endif
                            </td>
                            <td>
                                @if($commande->etat_client == 1)
                                {{ number_format($commande->ventes_total, 0, ',', ' ') }} Ar
                                @else
                                {{ number_format($commande->ventes_total + $commande->ventes_consignation_sum_prix + $commande->ventes_consignation_sum_prix_cgt + (optional($commande->conditionnement)->nombre_cageot * $cgt), 0, ',', ' ') }} Ar
                                @endif
                            </td>
                            <td>@if($commande->etat_commande == 'payé')
                                <span class="text-success">
                                    {{$commande->etat_commande}}
                                </span>
                                @else
                                <span class="text-danger">non payé</span>
                                @endif
                            </td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('commande.liste.vente.detail', ['id' => $commande->id]) }}" class=""><i class="fas fa-eye"></i></a>
                                <a href="{{route('pdf.download' , ['id'=>$commande->id])}}" class="ml-3"><i class="fas fa-print text-warning"></i></a>
                                


                                <form action="#" method="POST" style="display:inline;">

                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="venteModal2{{$commande->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">regler payement</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('regler.payement')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="commande_id" value="{{$commande->id}}">
                                            <p>voulez-vous regler le payement de cette commande {{$commande->id}}?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Payer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="9" class=""><div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pas de donnée trouvé -- 
                    </div></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{$commandes->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        border: none;
        color: #495057;
        padding: 0.75rem 1.25rem;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        background-color: transparent;
    }
    .table th {
        white-space: nowrap;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>
@endpush