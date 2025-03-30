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

        .total {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            padding-top: 10px;
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

        .left {
            text-align: left;
        }

        .center {
            text-align: start;
        }

        .right {
            text-align: start;
        }

        .final {
            margin-left: 40px;;
        }

        .summary-section {
            margin-top: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }



    </style>
</head>

<body>

    <div class="header">Facture DO-09D32001/15714/25</div>

    <div class="contain">
        <div class="left">
            <strong>Distributeur :</strong><br>
            Nom : Entreprise ABC<br>
            Adresse : 123 Rue Marché, Antananarivo<br>
            Contact : +261 34 12 345 67
        </div>

        <div class="right">
            <strong>Client :</strong><br>
            Nom : Jean Dupont<br>
            Adresse : 456 Rue Client, Antananarivo<br>
            Contact : +261 32 45 678 90
        </div>
    </div>
    <div class="contain">
        <div class="center">
            <strong>Date de commande :</strong><br>
            {{ \Carbon\Carbon::parse($achats->first()->created_at)->format('d/m/Y') }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>commande</th>
                <th>Prix / cageot</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($achats as $achat)
            <tr>
                <td>{{ $achat->articles ? $achat->articles->nom : '-' }}</td>
                <td>{{ number_format($achat->prix / $achat->quantite, 2) }} Ar</td>
                <td>{{ $achat->quantite }}</td>
                <td>{{ number_format($achat->prix, 2) }} Ar</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="summary-section">
        <div class="summary-row">
            <span class=""><strong>Montant liquide</strong> : </span>______________________________________________
            <span class="">{{ number_format($total, 2, ',', ' ') }} Ar</span>
        </div>
    </div>
    <div class="fin">
        <div class="">
            <span class="">Total TTC</span>
            <span class="">186 413 512 Ar</span>
        </div>

        <div class="">
            <span class="">Total quantité commande</span>
            <span class="">32 cgt</span>
        </div>
    </div>


</body>

</html>