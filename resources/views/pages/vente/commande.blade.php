@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<style>
    .btn-vibrant-blue {
    background-color: var(--vibrant-blue);
    border-color: var(--vibrant-blue);
    color: white;
}
</style>
<div class="">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <ul class="nav nav-tabs  mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('commande.liste.vente')}}">
                <button class="nav-link active" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-list-alt me-2"></i>Listes par commandes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a style="text-decoration: none;" href="{{route('vente.liste')}}">
                <button class="nav-link" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-shopping-cart me-2"></i>Listes ventes
                </button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-decoration-none p-0" href="{{route('vente.page')}}">
                <button class="nav-link active  text-white bg-dark">
                    <i class="fas fa-cart-plus me-2 text-white"></i> Nouvel vente
                </button>
            </a>
        </li>

    </ul>
    <div class="card shadow mb-4">
        <div class="p-3 mb-3 bg-light rounded shadow-sm">
            <form method="GET" action="{{ route('commande.liste.vente') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="search" class="form-label">Nom|numero commande</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="date_debut" class="form-label">Date début</label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="date_fin" class="form-label">Date fin</label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="tri" class="form-label">Trier par date</label>
                    <select name="tri" id="tri" class="form-control">
                        <option value="desc" {{ request('tri') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                        <option value="asc" {{ request('tri') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="fa fa-search"></i>Rechercher</button>
                </div>
            </form>
        </div>
        

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
                                <span class=" text-danger fw-bold"> à rendre</span>
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

                                @php
                                $btlcgt = $commande->ventes_total + $commande->ventes_consignation_sum_prix + $commande->ventes_consignation_sum_prix_cgt + (optional($commande->conditionnement)->nombre_cageot * $cgt);
                                @endphp
                            </td>
                            <td>@if($commande->etat_commande == 'payé' )
                                <span class="fw-bold text-success">
                                    {{$commande->etat_commande}}
                                </span>
                                @else
                                <span class="fw-bold text-danger">non payé</span>
                                @endif
                            </td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="{{route('commande.liste.vente.detail', ['id' => $commande->id]) }}" class=""><i class="fas fa-eye"></i></a>
                                <a href="{{route('pdf.download' , ['id'=>$commande->id])}}" class="ml-3"><i class="fas fa-print text-warning"></i></a>
                                @if($commande->etat_commande == 'payé')
                                <span class="text-success ml-3">
                                    <i class="fas fa-edit text-secondary" style="cursor: not-allowed; opacity: 0.5;"></i>
                                </span>
                                @else
                                <a href="#" class="ml-3">
                                    <i class="fas fa-edit text-warning" data-toggle="modal"></i>
                                </a>
                                @endif


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

<!-- Modal Nouvelle vente -->

<script>

</script>


@endsection