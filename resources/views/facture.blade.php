<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture C-{{ $commande->id }}</title>
    <style>
        body { 
            font-family: 'courier'; 
            font-weight: bold;
            color: black;
            font-size: 12px;
            background-color: white;
            padding: 15px;
        }
        a{
            text-decoration: none;
        }
        .header { 
            margin-bottom: 25px; 
            padding: 10px 0;
        }
        .company-info { 
            float: left; 
            width: 50%; 
            padding-bottom: 15px;
        }
        .invoice-info { 
            float: right; 
            width: 40%; 
            text-align: right;
            padding-bottom: 15px;
        }
        .clear { clear: both; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0;
        }
        th, td { 
            border: 1px solid black; 
            padding: 8px 8px; 
            text-align: left;
        }
        th { 
            background-color: #f0f0f0; 
            padding: 8px 8px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-danger { 
            color: black; 
        }
        .text-success { color: black; }
        .text-info { 
            color: black; 
            font-style: italic; 
        }
        .fw-bold { font-weight: bold; }
        .fw-bolder { font-weight: bolder; }
        .table-active { background-color: rgba(0,0,0,.05); }
        .border-top { border-top: 1px solid black; }
        .mt-1 { margin-top: 0.5rem; }
        .pt-1 { padding-top: 0.5rem; }
        .d-flex { display: flex; }
        .flex-column { flex-direction: column; }
        .pe-4 { padding-right: 1.5rem; }
        .dashed-line {
            border-top: 1px dashed black;
            margin: 15px 0;
        }
        .double-line {
            border-top: 3px double black;
            margin: 10px 0;
        }
        h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        p {
            margin: 8px 0;
        }
        .section-spacer {
            margin: 10px 0;
        }
        .total-table {
            width: 60%; 
            margin-left: auto;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="double-line"></div>
    
    <div class="header">
        <div class="company-info">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <img src="{{ asset('images/' . $entreprise->logo) }}" alt="Logo">
            </div>
            <h2>{{$entreprise->nom}}</h2>
            <p>Tél: {{ $entreprise->numero }}</p>
            <p>Adresse: {{ $entreprise->adresse }}</p>
            <p>NIF: {{ $entreprise->nif }}</p>
            <p>STAT: {{ $entreprise->stat }}</p>
            <p>Email: {{ $entreprise->email }}</p>
        </div>
        
        <div class="invoice-info">
            <h2>FACTURE #F-{{ $commande->id }}</h2>
            <p>Date: {{ $date }}</p>
            <p>Commande: C-{{ $commande->id }}</p>
            @if($commande->client)
                <p>Client: {{ $commande->client->nom }}</p>
            @endif
            <p>Statut: 
                <span class="{{ $commande->etat_commande == 'payé' ? 'text-success' : 'text-danger' }}">
                    {{ $commande->etat_commande == 'payé' ? 'PAYÉE' : 'NON PAYÉ' }}
                </span>
            </p>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <div class="dashed-line"></div>

    <table>
        <thead>
            <tr>
                <th>ARTICLE</th>
                <th>BTL</th>
                <th>CGT</th>
                <th>QUANTITÉ</th>
                <th>PRIX UNIT.</th>
                <th>CONSIGN.</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $vente)
            <tr>
                <td>{{ $vente['article'] }}</td>
                <td class="{{ $vente['etat'] == 'non rendu' ? 'text-danger' : 'text-success' }}">
                    {{ $vente['etat'] ? ($vente['prix_consignation'] == 0 ? 0 : $vente['consignation'] / $vente['prix_consignation']) : '--' }}
                </td>
                <td class="{{ in_array($vente['etat_cgt'], ['non rendu']) ? 'text-danger' : 'text-success' }}">
                    {{ $vente['etat_cgt'] ? ($vente['consi_cgt'] == 0 ? 0 : $vente['prix_cgt'] / $vente['consi_cgt']) : '--' }}
                </td>
                <td>{{ $vente['quantite'] }} {{ $vente['type_achat'] }}</td>
                <td class="text-right">{{ number_format( ($vente['type_achat'] == 'cageot' || $vente['type_achat'] == 'pack') ? $vente['prix_cage'] : $vente['prix_unitaire'], 0, ',', ' ') }} Ar</td>
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
                            ? ($vente['prix_cage'] * $vente['quantite']) + $vente['consignation'] + $vente['prix_cgt']
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
    
    <div class="dashed-line"></div>
    <div class="section-spacer"></div>


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
    
    <div class="dashed-line"></div>
    <div class="section-spacer"></div>

    @if($nombreCageots > 0)
    <table>
        <tr>
            <th>Nombre de cageots</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>{{ $nombreCageots }} CGT</td>
            <td class="text-right">{{ number_format($cgt ?? 0, 0, ',', ' ') }} Ar</td>
            <td class="text-right">{{ number_format($valeurCageots, 0, ',', ' ') }} Ar</td>
        </tr>
    </table>
    
    <div class="dashed-line"></div>
    <div class="section-spacer"></div>
    @endif

    <table class="total-table">
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
    
    <div class="double-line"></div>

    <div style="margin-top: 40px; text-align: center; font-size: 12px;">
        <p>MERCI POUR VOTRE CONFIANCE</p>
    </div>
    
    <div class="double-line"></div>
</body>
</html>




<!-- 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture C-{{ $commande->id }}</title>
    <style>
        @page { margin: 0; padding: 0; size: 58mm auto; }
        body { 
            font-family: "Courier New", monospace;
            font-size: 10px;
            margin: 5px;
            padding: 0;
            width: 58mm;
            color: black;
            line-height: 1.2;
        }
        .header, .footer { text-align: center; }
        .header { margin-bottom: 5px; }
        .footer { margin-top: 10px; font-size: 9px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        th, td {
            padding: 3px 1px;
            border-bottom: 1px dashed #aaa;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-danger { font-weight: bold; }
        .text-success { font-weight: bold; }
        .fw-bold { font-weight: bold; }
        .divider {
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        .double-divider {
            border-top: 2px double black;
            margin: 8px 0;
        }
        .item-qty { width: 15%; }
        .item-price { width: 25%; text-align: right; }
        .item-total { width: 30%; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="fw-bold">Mourad Bars</div>
        <div>Tél: {{ $company['phone'] }}</div>
    </div>

    <div class="divider"></div>

    <div class="fw-bold">FACTURE #F-{{ $commande->id }}</div>
    <div>Date: {{ $date }}</div>
    <div>Client: {{ $commande->client->nom ?? 'Non renseigné' }}</div>
    <div>Statut: <span class="{{ $commande->etat_commande == 'payé' ? 'text-success' : 'text-danger' }}">
        {{ $commande->etat_commande == 'payé' ? 'PAYÉ' : 'NON PAYÉ' }}
    </span></div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Prix</th>
                <th class="item-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $vente)
            <tr>
                <td>{{ $vente['article'] }}</td>
                <td class="item-qty">{{ $vente['quantite'] }}{{ $vente['type_achat'] == 'unité' ? '' : $vente['type_achat'][0] }}</td>
                <td class="item-price">{{ number_format($vente['prix_unitaire'], 0, ',', ' ') }}</td>
                <td class="item-total">{{ number_format($vente['prix_unitaire'] * $vente['quantite'], 0, ',', ' ') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="fw-bold">CONSIGNATION</div>
    <table>
        <tr>
            <td>Bouteilles rendues:</td>
            <td class="text-right">{{ $totals['rendu_btl'] }}</td>
        </tr>
        <tr>
            <td>Bouteilles cassées:</td>
            <td class="text-right text-danger">{{ $totals['casse'] }}</td>
        </tr>
        <tr>
            <td>Bouteilles consignées:</td>
            <td class="text-right">{{ $totals['btl'] }}</td>
        </tr>
        @if($nombreCageots > 0)
        <tr>
            <td>Cageots consignés:</td>
            <td class="text-right">{{ $nombreCageots }}</td>
        </tr>
        @endif
    </table>

    <div class="double-divider"></div>

    <table>
        <tr>
            <td class="fw-bold">Total articles:</td>
            <td class="text-right">{{ number_format($totals['global'] - $totals['consigne'] - $valeurCageots, 0, ',', ' ') }} Ar</td>
        </tr>
        <tr>
            <td class="fw-bold">Total consignation:</td>
            <td class="text-right">{{ number_format($totals['consigne'] + $valeurCageots, 0, ',', ' ') }} Ar</td>
        </tr>
        <tr>
            <td class="fw-bold">TOTAL À PAYER:</td>
            <td class="text-right fw-bold">{{ number_format($montantTotal, 0, ',', ' ') }} Ar</td>
        </tr>
        @if($commande->etat_commande == 'non payé' && $reste > 0)
        <tr>
            <td>Déjà payé:</td>
            <td class="text-right">{{ number_format($reste, 0, ',', ' ') }} Ar</td>
        </tr>
        <tr>
            <td class="fw-bold">RESTE À PAYER:</td>
            <td class="text-right fw-bold text-danger">
                {{ number_format($montantTotal - $reste, 0, ',', ' ') }} Ar
            </td>
        </tr>
        @endif
    </table>

    <div class="double-divider"></div>

    <div class="footer">
        <div>Merci pour votre confiance</div>
        <div>{{ config('app.name') }}</div>
        <div>{{ $company['phone'] }}</div>
    </div>
</body>
</html> -->




