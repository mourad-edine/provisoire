@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<style>
    a{
        color: #333;
    }
    a:hover{
        color: #333;
    }
</style>
<div class="container-fluid px-3 py-4">

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('commande.liste.vente') }}" class="nav-link">
                <i class="fas fa-list-alt me-2"></i>Listes par commandes
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('vente.liste') }}" class="nav-link active">
                <i class="fas fa-shopping-cart me-2"></i>Listes ventes
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('vente.liste') }}" class="nav-link">
                <i class="fas fa-history me-2"></i>Historique des paiements
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('rendre.boissons', ['id' => $commande_id]) }}" class="nav-link">
                <i class="fas fa-file-alt me-2"></i>Compte rendu
            </a>
        </li>
    </ul>

    <!-- Card Principal -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
            <h5 class="mb-0 text-white">VENTE - COMPTE-RENDU</h5>
            <div>
                <a href="{{route('commande.liste.vente.detail', ['id' => $commande_id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left me-1 text-white"></i>Retour
                </a>
            </div>
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Table Vente -->
            <form action="{{route('rendre.store')}}" method="POST">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client_id }}">
                <input type="hidden" name="commande_id" value="{{ $commande_id }}">
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-end">Sélectionner</th>
                                <th>ID</th>
                                <th>Article</th>
                                <th>Quantité</th>
                                <th>Bouteilles</th>
                                <th>Cageot/Pack</th>
                                <th>unité</th>
                                <th>État</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventes as $vente)
                            <tr>
                                <td class="text-end">
                                    <input type="checkbox" name="check[{{ $vente->id }}]" checked>
                                    <input type="hidden"
                                                class="form-control form-control-sm"
                                                value="{{ optional($vente->article)->id }}"
                                                name="article_id[{{ $vente->id }}]"
                                                required
                                                >
                                </td>
                                <td>{{ $vente->id }}</td>
                                <td>{{ optional($vente->article)->nom ?? '—' }}</td>
                                <td>{{$vente->quantite}} - {{$vente->type_achat}}</td>

                                <td>
                                    <input type="number" step="1" min="0"
                                        name="bouteilles[{{ $vente->id }}]"
                                        id="bouteilles_{{ $vente->id }}"
                                        class="form-control form-control-sm bouteilles-input"
                                        data-conditionnement="{{ optional($vente->article)->conditionnement }}"
                                        data-id="{{ $vente->id }}"
                                        max="{{ $vente->type_achat == 'cageot' ? $vente->quantite * optional($vente->article)->conditionnement : $vente->quantite }}"
                                        oninput="updateCageots(this)"
                                        readonly>
                                </td>
                                <td>
                                    <input type="number" step="1" min="0"
                                        name="cageots[{{ $vente->id }}]"
                                        id="cageots_{{ $vente->id }}"
                                        class="form-control form-control-sm cageots-input"
                                        data-conditionnement="{{ optional($vente->article)->conditionnement }}"
                                        data-id="{{ $vente->id }}"
                                        max="{{ $vente->quantite }}"
                                        oninput="updateBouteilles(this)"
                                        {{ $vente->type_achat == 'bouteille' ? 'readonly' : '' }}
                                        >
                                </td>
                                <!-- <td>{{ optional($vente->commande)->etat_commande ?? '—' }}</td> -->
                                 <td>
                                    <input type="hidden" value="{{$commande_id}}" name="commande_id">
                                 <input type="number" step="1" min="0"
                                        name="unite[{{ $vente->id }}]"
                                        class="form-control form-control-sm cageots-input"
                                        max="{{ $vente->type_achat == 'bouteille' ? $vente->quantite : $vente->article->conditionnement - 1 }}"
                                        placeholder="0"
                                        >
                                 </td>
                                 <td>
                                {{ optional($vente->commande)->etat_commande ?? '—' }}

                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucune vente enregistrée.</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- Bouton de soumission -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1 text-white"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function updateCageots(input) {
        const id = input.getAttribute('data-id');
        const conditionnement = parseFloat(input.getAttribute('data-conditionnement')) || 1;
        const bouteillesValue = parseFloat(input.value) || 0;
        
        const cageotsInput = document.getElementById(`cageots_${id}`);
        let cageotsValue = bouteillesValue / conditionnement;
        
        // Si la valeur est inférieure à 1, on met 0
        // Sinon on prend la partie entière (floor)
        cageotsValue = cageotsValue < 1 ? 0 : Math.floor(cageotsValue);
        
        cageotsInput.value = cageotsValue;
    }

    function updateBouteilles(input) {
        const id = input.getAttribute('data-id');
        const conditionnement = parseFloat(input.getAttribute('data-conditionnement')) || 1;
        const cageotsValue = parseFloat(input.value) || 0;
        
        const bouteillesInput = document.getElementById(`bouteilles_${id}`);
        const bouteillesValue = cageotsValue * conditionnement;
        
        bouteillesInput.value = bouteillesValue % 1 === 0 ? bouteillesValue : bouteillesValue.toFixed(2);
    }
</script>

@endsection