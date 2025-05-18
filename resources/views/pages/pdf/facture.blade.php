<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: rgb(0 0 0 / 80%)
        }

        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .contain {
            width: 100%;
            margin-top: 30px;
        }

        .contain div {
            display: inline-block;
            width: 32%;
            vertical-align: top;
        }

        .left,
        .center,
        .right {
            text-align: left;
        }

        .summary-section {
            margin-top: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .fin {
            margin-top: 20px;
        }

        .fin div {
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">Facture commande n° {{ $commande->numero ?? '---' }}</div>

    <div class="contain">
        <div class="left">
            <strong>Distributeur :</strong><br>
            Nom : Entreprise ABC<br>
            Adresse : -----------<br>
            Contact : -----------
        </div>

        <div class="right">
            <strong>Fournisseur :</strong><br>
            Nom : {{ $commande->fournisseur->nom ?? '-' }}<br>
            Adresse : {{ $commande->fournisseur->adresse ?? '-' }}<br>
            Contact : {{ $commande->fournisseur->telephone ?? '-' }}
        </div>
    </div>

    <div class="contain">
        <div class="center">
            <strong>Date de commande :</strong><br>
            {{ \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th>Prix / unité</th>
                <th>Quantité</th>
                <th>Prix Total</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($achats as $achat)
            <tr>
                <td>{{ $achat['article'] ?? '-' }}</td>
                <td>{{ $achat['prix_unite']}} Ar</td>
                <td>{{ $achat['quantite']}} - {{$achat['type_achat']}}</td>
                <td>{{ number_format($achat['prix'], 2, ',', ' ') }} Ar</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="summary-row">
            <span><strong>Montant liquide :</strong></span>
            <span>{{ number_format($total, 2, ',', ' ') }} Ar</span>
        </div>
    </div>

    <div class="fin">
        <div>
            <strong>Total TTC :</strong> {{ number_format($total, 2, ',', ' ') }} Ar
        </div>
        <div>
            <strong>Total quantité cageots :</strong>
            {{ $achats->where('type_achat', 'cageot')->sum('quantite') }} cageots,
        </div>
        <div>
            <strong>Total quantité packs :</strong>
            {{ $achats->where('type_achat', 'pack')->sum('quantite') }} packs,
        </div>
        <div>
            <strong>Total quantité bouteilles :</strong>
            {{ $achats->where('type_achat', 'bouteilles')->sum('quantite') }} unités

        </div>
    </div>

</body>

</html>

