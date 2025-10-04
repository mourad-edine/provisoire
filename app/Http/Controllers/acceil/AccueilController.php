<?php

namespace App\Http\Controllers\acceil;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Vente;
use App\Models\Categorie;
use App\Models\Depense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccueilController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $query = Article::with('categorie')->where('status', 1);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhereHas('categorie', function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%");
                });
        }

        $articles = $query->orderBy('id', 'DESC')->paginate(6);

        // Transformez les données si nécessaire
        $articles->getCollection()->transform(function ($article) {
            return [
                'id' => $article->id,
                'nom' => $article->nom,
                'categorie' => $article->categorie ? $article->categorie->nom : null,
                'categorie_id' => $article->categorie ? $article->categorie->id : null,
                'reference' => $article->reference,
                'imagep' => $article->imagep,
                'conditionnement' => $article->conditionnement,
                'prix_consignation' => $article->prix_consignation,
                'prix_achat' => $article->prix_achat,
                'prix_cgt' => $article->prix_cgt,
                'prix_unitaire' => $article->prix_unitaire,
                'prix_conditionne' => $article->prix_conditionne,
                'quantite' => $article->quantite,
                'created_at' => $article->created_at ? $article->created_at->format('d/m/Y H:i:s') : null,
                'prix_gros' => $article->prix_gros,
            ];
        });
        $bestseller = Article::withCount('achats')
            ->where('status' , 1)  // Charge le nombre d'achats associés à chaque article
            ->orderByDesc('achats_count')  // Trie les articles par le nombre d'achats, en ordre décroissant
            ->take(3)  // Limite à 3 articles
            ->get();
        $faible = Article::where('quantite', '<', 20)->where('status' , 1)->take(3)->get();

        //dd($faible);

        // $ventesParMois = Vente::selectRaw('MONTH(created_at) as mois, SUM(prix * quantite) as total')
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->groupBy('mois')
        //     ->orderBy('mois')
        //     ->pluck('total', 'mois')
        //     ->toArray();
        // //dd($ventesParMois);
        // $ventesParMois = array_replace(array_fill(1, 12, 0), $ventesParMois);

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
            THEN ventes.quantite * ventes.prix_cage
            ELSE ventes.quantite * ventes.prix 
        END) as total')
        )
            ->join('articles', 'ventes.article_id', '=', 'articles.id')
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
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
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
            ->whereDate('date_sortie', $today)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix_cage
                ELSE ventes.quantite * ventes.prix 
            END
        ) as total'))
            ->value('total');


        // Ventes du mois
        $ventesMois = Vente::join('articles', 'ventes.article_id', '=', 'articles.id')
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
            ->whereYear('date_sortie', $anneeActuelle)
            ->whereMonth('date_sortie', $moisActuel)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix_cage
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
            ->whereHas('commande', function ($q) {
                $q->where('disposition', 0);
            })
            ->when($request->date_vente, function ($query) use ($request) {
                return $query->whereDate('date_sortie', $request->date_vente);
            }, function ($query) use ($today) {
                return $query->whereDate('date_sortie', $today);
            })
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        return view('pages.dashboard', [
            'categories' => Categorie::All(),
            'articles' => $articles,
            'meilleur' => $bestseller,
            'faible' => $faible,
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

    public function dash(Request $request)
    {

        $search = $request->input('search');

        $query = Article::with('categorie')->where('status', 1);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhereHas('categorie', function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%");
                });
        }

        $articles = $query->orderBy('id', 'DESC')->paginate(6);

        // Transformez les données si nécessaire
        $articles->getCollection()->transform(function ($article) {
            return [
                'id' => $article->id,
                'nom' => $article->nom,
                'categorie' => $article->categorie ? $article->categorie->nom : null,
                'categorie_id' => $article->categorie ? $article->categorie->id : null,
                'reference' => $article->reference,
                'imagep' => $article->imagep,
                'conditionnement' => $article->conditionnement,
                'prix_consignation' => $article->prix_consignation,
                'prix_achat' => $article->prix_achat,
                'prix_cgt' => $article->prix_cgt,
                'prix_unitaire' => $article->prix_unitaire,
                'prix_conditionne' => $article->prix_conditionne,
                'quantite' => $article->quantite,
                'created_at' => $article->created_at ? $article->created_at->format('d/m/Y H:i:s') : null,
                'prix_gros' => $article->prix_gros,
            ];
        });

        $bestseller = Article::select('articles.*')
            ->where('articles.status', 1)
            ->join('ventes', 'articles.id', '=', 'ventes.article_id')
            ->selectRaw('COUNT(ventes.article_id) as ventes_count')
            ->groupBy('articles.id')
            ->orderByDesc('ventes_count')
            ->take(3)
            ->get();
        $faible = Article::where('quantite', '<', 20)->where('status' , 1)->take(3)->get();

        //dd($faible);

        // $ventesParMois = Vente::selectRaw('MONTH(created_at) as mois, SUM(prix * quantite) as total')
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->groupBy('mois')
        //     ->orderBy('mois')
        //     ->pluck('total', 'mois')
        //     ->toArray();
        // //dd($ventesParMois);
        // $ventesParMois = array_replace(array_fill(1, 12, 0), $ventesParMois);
       
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
            THEN ventes.quantite * ventes.prix_cage
            ELSE ventes.quantite * ventes.prix 
        END) as total')
        )
            ->join('articles', 'ventes.article_id', '=', 'articles.id')
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
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
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
            ->whereDate('date_sortie', $today)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix_cage
                ELSE ventes.quantite * ventes.prix 
            END
        ) as total'))
            ->value('total');


        // Ventes du mois
        $ventesMois = Vente::join('articles', 'ventes.article_id', '=', 'articles.id')
            ->join('commandes', 'ventes.commande_id', '=', 'commandes.id')
            ->where('commandes.disposition', 0)
            ->whereYear('date_sortie', $anneeActuelle)
            ->whereMonth('date_sortie', $moisActuel)
            ->select(DB::raw('
        SUM(
            CASE 
                WHEN ventes.type_achat IN ("cageot", "pack") 
                THEN ventes.quantite * ventes.prix_cage
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
            ->whereHas('commande', function ($q) {
                $q->where('disposition', 0);
            })
            ->when($request->date_vente, function ($query) use ($request) {
                return $query->whereDate('date_sortie', $request->date_vente);
            }, function ($query) use ($today) {
                return $query->whereDate('date_sortie', $today);
            })
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        return view('pages.Accueil', [
            'categories' => Categorie::All(),
            'articles' => $articles,
            'meilleur' => $bestseller,
            'faible' => $faible,
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
