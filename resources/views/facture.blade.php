<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture C-{{ $commande->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { margin-bottom: 20px; }
        .company-info { float: left; width: 50%; }
        .invoice-info { float: right; width: 40%; text-align: right; }
        .clear { clear: both; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-danger { color: #dc3545; }
        .text-success { color: #28a745; }
        .text-info { color: #17a2b8; }
        .fw-bold { font-weight: bold; }
        .fw-bolder { font-weight: bolder; }
        .table-active { background-color: rgba(0,0,0,.05); }
        .border-top { border-top: 1px solid #dee2e6; }
        .mt-1 { margin-top: 0.25rem; }
        .pt-1 { padding-top: 0.25rem; }
        .d-flex { display: flex; }
        .flex-column { flex-direction: column; }
        .pe-4 { padding-right: 1.5rem; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h2>Mourad - Bars</h2>
            <p>Tél: {{ $company['phone'] }}</p>
        </div>
        <div class="invoice-info">
            <h2>Facture #F-{{ $commande->id }}</h2>
            <p>Date: {{ $date }}</p>
            <p>Commande: C-{{ $commande->id }}</p>
            @if($commande->client)
                <p>Client: {{ $commande->client->nom }}</p>
            @endif
            <p>Statut: 
                <span class="{{ $commande->etat_commande == 'payé' ? 'text-success' : 'text-danger' }}">
                    {{ $commande->etat_commande == 'payé' ? 'Payée' : 'Non payé' }}
                </span>
            </p>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Article</th>
                <th>BTL</th>
                <th>CGT</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Consignation</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $vente)
            <tr>
                <td>{{ $vente['id'] }}</td>
                <td>{{ $vente['article'] }}</td>
                <td class="{{ $vente['etat'] == 'non rendu' ? 'text-danger' : 'text-success' }}">
                    {{ $vente['etat'] ? ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                </td>
                <td class="{{ in_array($vente['etat_cgt'], ['non rendu']) ? 'text-danger' : 'text-success' }}">
                    {{ $vente['etat_cgt'] ? ($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']) : '--' }}
                </td>
                <td>{{ $vente['quantite'] }} {{ $vente['type_achat'] }}</td>
                <td class="text-right">{{ number_format($vente['prix_unitaire'], 0, ',', ' ') }} Ar</td>
                <td class="text-right">
                    @if(($vente['consignation'] + $vente['prix_cgt']) > 0)
                        @if($vente['etat_client'] == 1)
                            <span class="text-danger">à rendre</span>
                        @elseif($vente['etat_client_commande'] == 2)
                            <span class="text-danger">à disposition</span>
                        @else
                            {{ number_format($vente['consignation'] + $vente['prix_cgt'], 0, ',', ' ') }} Ar
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">
                    @php
                        $total = ($vente['type_achat'] === 'cageot' || $vente['type_achat'] === 'pack')
                            ? ($vente['prix_unitaire'] * $vente['quantite'] * $vente['conditionnement']) + $vente['consignation'] + $vente['prix_cgt']
                            : ($vente['prix_unitaire'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt'];

                        if($commande->etat_client == 1) {
                            $total -= $vente['consignation'] + $vente['prix_cgt'];
                        }
                    @endphp
                    {{ number_format($total, 0, ',', ' ') }} Ar
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Résumé -->
    <table class="table-active">
        <tr>
            <td class="fw-bold">Bouteilles rendues:</td>
            <td>{{ $totals['rendu_btl'] }}</td>
            <td class="fw-bold">Cageots rendus:</td>
            <td>{{ $totals['rendu_cgt'] }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Bouteilles cassées:</td>
            <td class="text-danger">{{ $totals['casse'] }}</td>
            <td class="fw-bold">Cageots endommagés:</td>
            <td class="text-danger">{{ $totals['casse_cgt'] }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Bouteilles consignées:</td>
            <td>{{ $totals['btl'] }}</td>
            <td class="fw-bold">Cageots consignés:</td>
            <td>{{ $totals['cgt'] + $nombreCageots }}</td>
        </tr>
    </table>

    @if($nombreCageots > 0)
    <table>
        <tr>
            <th>Nombre de cageots</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>{{ $nombreCageots }} CGT</td>
            <td class="text-right">{{ number_format($cgt, 0, ',', ' ') }} Ar</td>
            <td class="text-right">{{ number_format($valeurCageots, 0, ',', ' ') }} Ar</td>
        </tr>
    </table>
    @endif

    <!-- Totaux finaux -->
    <div style="margin-top: 20px;">
        <table style="width: 50%; margin-left: auto;">
            <tr>
                <th>Total déconsigné:</th>
                <td class="text-right">{{ number_format($totals['deconsigne'], 0, ',', ' ') }} Ar</td>
            </tr>
            <tr>
                <th>Total consignation:</th>
                <td class="text-right">{{ number_format($totals['consigne'] + $valeurCageots, 0, ',', ' ') }} Ar</td>
            </tr>
            <tr>
                <th>Total global:</th>
                <td class="text-right">{{ number_format($totals['global'], 0, ',', ' ') }} Ar</td>
            </tr>
            
            @if($commande->etat_commande == 'non payé')
            <tr>
                <th>Reste à payer:</th>
                <td class="text-right text-danger">{{ number_format($commande->etat_client == 1 ? $montantTotal - ($totals['consigne'] + $valeurCageots) : $montantTotal, 0, ',', ' ') }} Ar</td>
            </tr>
            @endif
            
            @if($reste > 0)
            <tr>
                <th>Déjà payé:</th>
                <td class="text-right">{{ number_format($reste, 0, ',', ' ') }} Ar</td>
            </tr>
            @endif
            
            <tr>
                <td colspan="2" class="text-end pe-4 fw-bold">
                    <div class="d-flex flex-column">
                        <span>{{ max($totals['deconsigne'] - $reste, 0) }} Ar (déconsigne)</span>
                        <span class="text-success">+ {{ number_format($totals['consigne'], 0, ',', ' ') }} Ar (consigne)</span>
                        @if($nombreCageots > 0)
                        <span class="text-info">+ {{ number_format($valeurCageots, 0, ',', ' ') }} Ar (cageots)</span>
                        @endif
                        <div class="border-top mt-1 pt-1">
                            <span class="fw-bolder">= {{ number_format($montantTotal, 0, ',', ' ') }} Ar (total)</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 10px;">
        <p>Merci pour votre confiance</p>
    </div>
</body>
</html>