<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{



    public function generatePDF()
    {
        $data = [
            'invoice_number' => 'FACT-20240307',
            'date' => date('d/m/Y'),
            'company_name' => 'Boisson Express',
            'company_address' => '123 Rue des Rafraîchissements, Antananarivo',
            'company_phone' => '+261 34 12 345 67',
            'company_email' => 'contact@boissonexpress.mg',
            'client_name' => 'Rakoto Andrianina',
            'client_address' => 'Lot II B 67, Antsirabe',
            'client_phone' => '+261 33 45 678 90',
            'client_email' => 'rakoto.andrianina@email.com',
            'items' => [
                ['description' => 'Coca-Cola 1L', 'quantity' => 2, 'unit_price' => 5000],
                ['description' => 'Eau Vive 1.5L', 'quantity' => 3, 'unit_price' => 2000],
                ['description' => 'Jus de Mangue 500ml', 'quantity' => 1, 'unit_price' => 7000],
                ['description' => 'Boisson Energétique XXL 250ml', 'quantity' => 5, 'unit_price' => 4500],
                ['description' => 'Café en bouteille 330ml', 'quantity' => 2, 'unit_price' => 8000],
            ]
        ];

        // Calcul du total en Ariary (MGA)
        $data['total'] = array_reduce($data['items'], function ($sum, $item) {
            return $sum + ($item['quantity'] * $item['unit_price']);
        }, 0);

        $pdf = Pdf::loadView('facture', $data);

        return $pdf->stream('facture.pdf'); // Affiche la facture dans le navigateur
    }
}
