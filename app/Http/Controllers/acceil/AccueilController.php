<?php

namespace App\Http\Controllers\acceil;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {


        return view('pages.Accueil');
    }

    public function dash()
    {

        $ventejour = Vente::whereDate('created_at', Carbon::today())->count();
        $ventesMois = Vente::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $recettejour = Vente::whereDate('created_at', Carbon::today())
            ->selectRaw('SUM(prix * quantite) as total')
            ->value('total');

        $recettemois = Vente::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('SUM(prix * quantite) as total')
            ->value('total');

        $recetteAnnee = Vente::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('SUM(prix * quantite) as total')
            ->value('total');

        $bestseller = Article::withCount('achats')  // Charge le nombre d'achats associés à chaque article
            ->orderByDesc('achats_count')  // Trie les articles par le nombre d'achats, en ordre décroissant
            ->take(3)  // Limite à 3 articles
            ->get();
        $faible = Article::where('quantite', '<' , 20)->take(3)->get();
        
        $achatjour = Achat::whereDate('created_at', Carbon::today())->count();
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
            'ventejour' => $ventejour,
            'ventemois' => $ventesMois,
            'recettejour' => $recettejour,
            'recettemois' => $recettemois,
            'recetteannee' => $recetteAnnee,
            'meilleur' => $bestseller,
            'faible' => $faible,
            'achatjour' => $achatjour
        ]);
    }
}
