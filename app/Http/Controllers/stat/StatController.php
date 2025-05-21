<?php

namespace App\Http\Controllers\stat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Depense;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function show(Request $request)
    {
        $moisActuel = now()->month;
        $anneeActuelle = now()->year;
        $now = now();
        $depensesDuMois = Depense::whereMonth('created_at', $moisActuel)
            ->whereYear('created_at', $anneeActuelle)
            ->get();
        $depensesAujourdhui = Depense::whereDate('created_at', $now->toDateString())->get();

        $annee = $request->annee ?? now()->year;
        $today = now()->toDateString();

        // Ventes par mois
        $ventesParMois = Vente::select(
            DB::raw('MONTH(date_sortie) as mois'),
            DB::raw('SUM(CASE 
        WHEN ventes.type_achat IN ("cageot", "pack") 
        THEN ventes.quantite * ventes.prix * articles.conditionnement
        ELSE ventes.quantite * ventes.prix 
        END) as total')
        )
            ->join('articles', 'ventes.article_id', '=', 'articles.id')
            ->whereYear('date_sortie', $annee)
            ->groupBy(DB::raw('MONTH(date_sortie)'))
            ->orderBy('mois')
            ->get();

        // Dépenses diverses par mois
        $depensesDivers = Depense::select(
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('SUM(montant) as total')
        )
            ->whereYear('created_at', $annee)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('mois')
            ->get();

        // Dépenses (achats) par mois
        $depenseParMois = Achat::select(
            DB::raw('MONTH(date_entre) as mois'),
            DB::raw('SUM(CASE 
        WHEN achats.type_achat IN ("cageot", "pack") 
        THEN achats.quantite * achats.prix_unite * articles.conditionnement
        ELSE achats.quantite * achats.prix_unite 
        END) as total')
        )
            ->join('articles', 'achats.article_id', '=', 'articles.id')
            ->whereYear('date_entre', $annee)
            ->groupBy(DB::raw('MONTH(date_entre)'))
            ->orderBy('mois')
            ->get();

        // Ventes du jour
        $ventesJour = Vente::join('articles', 'ventes.article_id', '=', 'articles.id')
            ->whereDate('date_sortie', $today)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix * articles.conditionnement
                ELSE ventes.quantite * ventes.prix 
            END
        ) as total'))
            ->value('total');

        // Ventes du mois
        $ventesMois = Vente::join('articles', 'ventes.article_id', '=', 'articles.id')
            ->whereYear('date_sortie', $anneeActuelle)
            ->whereMonth('date_sortie', $moisActuel)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix * articles.conditionnement
                ELSE ventes.quantite * ventes.prix 
            END
        ) as total'))
            ->value('total');

        // Achats du jour
        $achatsJour = Achat::join('articles', 'achats.article_id', '=', 'articles.id')
            ->whereDate('date_entre', $today)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN achats.type_achat IN ("cageot", "pack") 
                THEN achats.quantite * achats.prix_unite * articles.conditionnement
                ELSE achats.quantite * achats.prix_unite 
            END
        ) as total'))
            ->value('total');

        // Achats du mois
        $achatsMois = Achat::join('articles', 'achats.article_id', '=', 'articles.id')
            ->whereYear('date_entre', $anneeActuelle)
            ->whereMonth('date_entre', $moisActuel)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN achats.type_achat IN ("cageot", "pack") 
                THEN achats.quantite * achats.prix_unite * articles.conditionnement
                ELSE achats.quantite * achats.prix_unite 
            END
        ) as total'))
            ->value('total');

        // Calcul du bénéfice
        $beneficeMois = ($ventesMois ?? 0) - ($achatsMois ?? 0);

        // Ventes du jour (pour affichage détaillé)
        $ventes = Vente::with('article')
            ->when($request->date_vente, function ($query) use ($request) {
                return $query->whereDate('date_sortie', $request->date_vente);
            }, function ($query) use ($today) {
                return $query->whereDate('date_sortie', $today);
            })
            ->get();

        return view('pages.stat.Stat', [
            'ventes' => $ventes,
            'depense' => $depenseParMois,
            'ventesParMois' => $ventesParMois,
            'depensesDivers' => $depensesDivers,
            'venteJour' => $ventesJour ?? 0,
            'venteMois' => $ventesMois ?? 0,
            'achatJour' => $achatsJour ?? 0,
            'achatMois' => $achatsMois ?? 0,
            'beneficeMois' => $beneficeMois,
            'depensemois' => $depensesDuMois->sum('montant'),
            'depensejour' => $depensesAujourdhui->sum('montant')
        ]);
    }
}
