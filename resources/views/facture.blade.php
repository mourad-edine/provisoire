<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #007BFF;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info div {
            width: 48%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #007BFF;
            color: white;
        }

        .total {
            text-align: right;
            font-size: 16px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>FACTURE</h1>
            <p><strong>N°:</strong> {{ $invoice_number }} | <strong>Date:</strong> {{ $date }}</p>
        </div>

        <div class="info">
            <div>
                <h3>société</h3>
                <p><strong>{{ $company_name }}</strong><br>
                    {{ $company_address }}<br>
                    {{ $company_phone }}<br>
                    {{ $company_email }}
                </p>
            </div>
            <div>
                <h3>Client</h3>
                <p><strong>{{ $client_name }}</strong><br>
                    {{ $client_address }}<br>
                    {{ $client_phone }}<br>
                    {{ $client_email }}
                </p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item['quantity'].'-'.  $item['type_achat'] }}</td>
                    <td>{{ number_format($item['unit_price'], 2, ',', ' ') }} Ar</td>
                    <td>{{ number_format($item['total'], 2, ',', ' ') }} Ar</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total"><strong>Total: {{ number_format($total, 2, ',', ' ') }} Ar</strong></p>

        <div class="footer">
            <p>Merci pour votre confiance. Cette facture a été générée automatiquement.</p>
        </div>
    </div>
</body>

</html>
<!-- 
<div class="modal fade" id="venteModal2" tabindex="-1" role="dialog" aria-labelledby="venteModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="venteModalLabel">Nouvelle vente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="venteForm" method="POST" action="{{ route('vente.store') }}">
                    @csrf
                    <div class="row">

                        <div id="quantiteCageotContainer">
                            <div class="form-group">
                                <label for="quantiteCageot">Quantité en cageot</label>
                                <input type="number" class="form-control" id="quantiteCageot" min="1" value="1">
                            </div>
                        </div>


                        <div class="modal-footer">
                            <p id="final" class="ml-5">0</p><span>Ar</span><button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div> -->