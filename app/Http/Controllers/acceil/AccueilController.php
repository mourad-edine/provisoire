<?php

namespace App\Http\Controllers\acceil;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Vente;
use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        
$search = $request->input('search');

        $query = Article::with('categorie');

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
            ];
        });
        $bestseller = Article::withCount('achats')  // Charge le nombre d'achats associés à chaque article
            ->orderByDesc('achats_count')  // Trie les articles par le nombre d'achats, en ordre décroissant
            ->take(3)  // Limite à 3 articles
            ->get();
        $faible = Article::where('quantite', '<' , 20)->take(3)->get();
        
        //dd($faible);

        // $ventesParMois = Vente::selectRaw('MONTH(created_at) as mois, SUM(prix * quantite) as total')
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->groupBy('mois')
        //     ->orderBy('mois')
        //     ->pluck('total', 'mois')
        //     ->toArray();
        // //dd($ventesParMois);
        // $ventesParMois = array_replace(array_fill(1, 12, 0), $ventesParMois);
        return view('pages.dashboard',[
            'categories' => Categorie::All(),
            'articles' => $articles,
            'meilleur' => $bestseller,
            'faible' => $faible,
        ]);

    }

    public function dash(Request $request)
    {

        $search = $request->input('search');

        $query = Article::with('categorie');

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
            ];
        });

        $bestseller = Article::withCount('achats')  // Charge le nombre d'achats associés à chaque article
            ->orderByDesc('achats_count')  // Trie les articles par le nombre d'achats, en ordre décroissant
            ->take(3)  // Limite à 3 articles
            ->get();
        $faible = Article::where('quantite', '<' , 20)->take(3)->get();
        
        //dd($faible);

        // $ventesParMois = Vente::selectRaw('MONTH(created_at) as mois, SUM(prix * quantite) as total')
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->groupBy('mois')
        //     ->orderBy('mois')
        //     ->pluck('total', 'mois')
        //     ->toArray();
        // //dd($ventesParMois);
        // $ventesParMois = array_replace(array_fill(1, 12, 0), $ventesParMois);
        return view('pages.Accueil',[
            'categories' => Categorie::all(),
            'articles' => $articles,
            'meilleur' => $bestseller,
            'faible' => $faible,
        ]);
    }
}
