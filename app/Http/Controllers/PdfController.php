<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{



    public function generatePDF($id)
    {
        $ventes = Vente::with('article', 'consignation')->where('commande_id', $id)->orderby('id', 'DESC')->get()->map(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation' => $vente->consignation ? $vente->consignation->prix : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : 0,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : 1,
            ];
        });
        
        // Création des items pour la facture
        $items = $ventes->map(function ($vente) {
            $total = ($vente['prix_unitaire'] + $vente['prix_consignation']) * $vente['quantite'];
            if ($vente['type_achat'] === 'cageot') {
                $total *= $vente['conditionnement'];
            }
        
            return [
                'description' => $vente['article'],
                'quantity' => $vente['quantite'],
                'type_achat' => $vente['type_achat'],
                'unit_price' => $vente['prix_unitaire'] + $vente['prix_consignation'],
                'total' => $total
            ];
        })->toArray();
        
        // Création des données de la facture
        $numero_facture = 'FAC-' . date('Ymd') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $vente = [
            'invoice_number' => $numero_facture,
            'date' => date('d/m/Y'),
            'company_name' => 'Reflet Boisson',
            'company_address' => 'Mangarano || parcelle 11/47',
            'company_phone' => '0349219223',
            'company_email' => 'chamsedinemaulice@reflet.mg',
            'client_name' => 'client passager',
            'client_address' => "----pas d 'adresse----",
            'client_phone' => "---pas de téléphone---",
            'client_email' => "---pas d'email---",
            'items' => $items,
            'total' => array_sum(array_column($items, 'total')),
        ];
        
        $pdf = Pdf::loadView('facture', $vente);
        return $pdf->stream('facture.pdf');
         // Affiche la facture dans le navigateur
    }
}
