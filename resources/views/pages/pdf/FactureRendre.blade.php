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
            <h2>{{$entreprise->nom}}</h2>
            <p>Tél: {{ $entreprise->numero }}</p>
            <p>Adresse: {{ $entreprise->adresse }}</p>
            <p>NIF: {{ $entreprise->nif }}</p>
            <p>STAT: {{ $entreprise->stat }}</p>
            <p>Email: {{ $entreprise->email }}</p>
        </div>
        
        <div class="invoice-info">
            <h2>FACTURE #F-{{ $commande->id }}</h2>
            <p>Date: {{ $commande->created_at }}</p>
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
                <th>ARTICLE à rendre</th>
                <th>QUANTITÉ RESTANTE</th>
                <th>QUANTITE RENDU.</th>
                <th>QUANTITE CASSE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $key => $vente)
            <tr>
                <td>{{ $vente->article->nom }}</td>
                
                <td>{{ $vente->quantite}} {{ $vente->type_achat }}</td>
                <td class="text-right">
                     {{ $vente->articlerendus->sum('quantite') ?? 0 }} {{ $vente['type_achat'] }}
                </td>
                <td class="text-right">
                    {{ $vente->articlerendus->sum('quantite_casse') ?? 0 }} {{ $vente->type_achat}}

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="dashed-line"></div>
    <div class="section-spacer"></div>

    <div style="margin-top: 40px; text-align: center; font-size: 12px;">
        <p>MERCI POUR VOTRE CONFIANCE</p>
    </div>
    
    <div class="double-line"></div>
</body>
</html>
