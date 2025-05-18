<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{



    public function generatePDF($id)
    {
        // Données de base
        $article = Article::first();
        $cgt = $article->prix_cgt;
        $commande = Commande::with(['payements', 'client', 'conditionnement'])->findOrFail($id);
        $reste = $commande->payements()->where('operation', 'partiel')->sum('somme');
    
        // Récupération des ventes
        $ventes = Vente::with(['article', 'consignation', 'commande'])
            ->where('commande_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
    
        // Initialisation des totaux
        $totals = [
            'global' => 0,
            'deconsigne' => 0,
            'consigne' => 0,
            'btl' => 0,
            'cgt' => 0,
            'rendu_btl' => 0,
            'rendu_cgt' => 0,
            'casse' => 0,
            'casse_cgt' => 0
        ];
    
        // Transformation des données
        $ventesData = $ventes->map(function ($vente) use (&$totals, $commande) {
            $data = [
                'id' => $vente->id,
                'article' => optional($vente->article)->nom,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'prix_unitaire' => optional($vente->article)->prix_unitaire,
                'conditionnement' => optional($vente->article)->conditionnement,
                'prix_consignation' => optional($vente->article)->prix_consignation,
                'consi_cgt' => optional($vente->article)->prix_cgt,
                'consignation' => optional($vente->consignation)->prix * optional($vente->article)->prix_consignation ?? 0,
                'prix_cgt' => optional($vente->consignation)->prix_cgt * optional($vente->article)->prix_cgt ?? 0,
                'etat' => optional($vente->consignation)->etat,
                'etat_cgt' => optional($vente->consignation)->etat_cgt,
                'etat_client' => $vente->client,
                'etat_client_commande' => optional($vente->commande)->etat_client,
                'casse' => optional($vente->consignation)->casse ?? 0,
                'rendu_btl' => optional($vente->consignation)->rendu_btl ?? 0,
                'rendu_cgt' => optional($vente->consignation)->rendu_cgt ?? 0,
                'casse_cgt' => optional($vente->consignation)->casse_cgt ?? 0,
            ];
    
            // Calcul des totaux (identique à la vue)
            $prix_total = ($data['type_achat'] === 'cageot' || $data['type_achat'] === 'pack')
                ? ($data['prix_unitaire'] * $data['quantite'] * $data['conditionnement']) + $data['consignation'] + $data['prix_cgt']
                : ($data['prix_unitaire'] * $data['quantite']) + $data['consignation'] + $data['prix_cgt'];
    
            if ($commande->etat_client == 1) {
                $prix_total -= $data['consignation'] + $data['prix_cgt'];
            }
    
            $prix_total_deconsigne = ($data['type_achat'] === 'cageot' || $data['type_achat'] === 'pack')
                ? ($data['prix_unitaire'] * $data['quantite'] * $data['conditionnement'])
                : ($data['prix_unitaire'] * $data['quantite']);
    
            $prix_total_consigne = $data['consignation'] + $data['prix_cgt'];
    
            // Mise à jour des totaux globaux
            $totals['global'] += $prix_total;
            $totals['deconsigne'] += $prix_total_deconsigne;
            $totals['consigne'] += $prix_total_consigne;
            $totals['btl'] += $data['prix_consignation'] == 0 ? 0 : $data['consignation'] / $data['prix_consignation'];
            $totals['cgt'] += $data['consi_cgt'] == 0 ? 0 : $data['prix_cgt'] / $data['consi_cgt'];
            $totals['rendu_btl'] += $data['rendu_btl'];
            $totals['rendu_cgt'] += $data['rendu_cgt'];
            $totals['casse'] += $data['casse'];
            $totals['casse_cgt'] += $data['casse_cgt'];
    
            return $data;
        });
    
        // Gestion des cageots
        $nombreCageots = optional($commande->conditionnement)->nombre_cageot ?? 0;
        $valeurCageots = $nombreCageots * $cgt;
        $totals['global'] += $valeurCageots;
    
        // Calcul final identique à la vue
        $montantTotal = max($totals['deconsigne'] - $reste, 0) + $totals['consigne'] + $valeurCageots;
    
        // Génération du PDF
        $pdf = PDF::loadView('facture', [
            'ventes' => $ventesData,
            'commande' => $commande,
            'conditionnement' => $commande->conditionnement,
            'cgt' => $cgt,
            'reste' => $reste,
            'totals' => $totals,
            'nombreCageots' => $nombreCageots,
            'valeurCageots' => $valeurCageots,
            'montantTotal' => $montantTotal,
            'date' => now()->format('d/m/Y'),
            'company' => [
                'name' => config('app.name'),
                'phone' => '034 00 000 00'
            ]
        ]);
    
        return $pdf->stream('facture-' . $commande->id . '.pdf');
    }



    public function achatpdf($id)
{
    $achats = Achat::with('articles', 'consignation_achat')
        ->where('commande_id', $id)
        ->orderBy('id', 'DESC')
        ->get();

    // On transforme comme dans detailcommande()
    $achats = $achats->map(function ($achat) {
        return [
            'id' => $achat->id,
            'type_achat' => $achat->type_achat,
            'prix_unite' => $achat->prix_unite,
            'prix_achat' => $achat->articles ? $achat->articles->prix_achat : null,
            'prix' => $achat->prix,
            'article' => $achat->articles ? $achat->articles->nom : null,
            'conditionnement' => $achat->articles ? $achat->articles->conditionnement : null,
            'numero_commande' => $achat->commande_id,
            'consignation_id' => $achat->consignation_achat->id ?? null,
            'etat' => $achat->consignation_achat->etat ?? null,
            'etat_cgt' => $achat->consignation_achat->etat_cgt ?? null,
            'prix_cgt' => $achat->consignation_achat->prix_cgt ?? null,
            'quantite' => $achat->quantite,
            'created_at' => \Carbon\Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
        ];
    });

    $total = $achats->sum('prix');
    $commande = Commande::with('fournisseur', 'client')->find($id);

    $pdf = PDF::loadView('pages.pdf.facture', compact('achats', 'total', 'commande'));

    return $pdf->stream("facture_commande_{$id}.pdf");
}

    
}
