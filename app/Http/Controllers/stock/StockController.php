<?php

namespace App\Http\Controllers\stock;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Emballage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Embed\Embed;

class StockController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');

        $query = Article::query()->where('status', 1);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhereHas('categorie', function ($query) use ($search) {
                    $query->where('nom', 'like', "%{$search}%");
                });
        }

        $articles = $query->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('pages.stock.Stock', [
            'articles' => $articles,
        ]);
    }

    public function faible(Request $request)
    {
        $search = $request->input('search');

        $query = Article::where('quantite', '<', 24)->where('status', 1);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhereHas('categorie', function ($query) use ($search) {
                    $query->where('nom', 'like', "%{$search}%");
                });
        }

        $articles = $query->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('pages.stock.Faible', [
            'articles' => $articles,
        ]);
    }

    public function stockbyCategorie(Request $request, $id)
    {
        $search = $request->input('search');

        $query = Article::where('categorie_id', $id)->where('status', 1);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhereHas('categorie', function ($query) use ($search) {
                    $query->where('nom', 'like', "%{$search}%");
                });
        }

        $articles = $query->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('pages.stock.Article_categorie', [
            'articles' => $articles,
            'categorie_id' => $id,
        ]);
    }

    public function categorie()
    {
        return view('pages.stock.Categorie', [
            'categories' => Categorie::withCount('articles')->get()
        ]);
    }
    public function emballage()
    {
        // Regrouper les types par famille
        $groupes = [
            '30,33'  => [30, 33],
            '50,65'  => [50, 65],
            '100' => [100],
        ];

        $resultats = [];
        $search = request()->input('search');
        $alcoolfort = Article::where('prix_consignation', '>=', 1000)
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhereHas('categorie', function ($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%");
                    });
            })
            ->get();

        //dd($alcoolfort->toArray());
        foreach ($groupes as $key => $types) {
            $articles = Article::whereIn('type_btl', $types)->get();

            $totalVide = $articles->sum('vides'); // somme de la colonne "vide"
            $valeurReelle = $articles->sum(function ($article) {
                return $article->vides * $article->prix_consignation;
            });

            $resultats[$key] = [
                'articles' => $articles,
                'total_vide' => $totalVide,
                'valeur_reelle' => $valeurReelle,
            ];
        }
        $emballage = Emballage::all();
        //dd($resultats);
        return view('pages.stock.Emballage', [
            'emballages' => $resultats,
            'cageots' => $emballage,
            'articles' => $alcoolfort
        ]);
    }

    public function emballage_achat()
    {
        $emballage = Emballage::all();
        $articles = Article::where('status', 1)->where('prix_consignation' , '>', 0)->get();
        return view('pages.stock.Buy', [
            'emballages' => $emballage,
            'articles' => $articles
        ]);
    }

    public function emballage_bouteille($type)
    {
        // Si $type contient une virgule → on crée un tableau
        $types = explode(',', $type);

        $alcoolfort = Article::where('prix_consignation', '<', 1000)
            ->whereIn('type_btl', $types)
            ->get();

        return view('pages.stock.Bouteille', [
            'articles' => $alcoolfort,
            'type' => $type
        ]);
    }


    public function editemballage(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'id'   => 'required',
            'quantite'    => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $emballage = Emballage::findOrFail($request->id);
                $emballage->quantite      = $request->quantite;
                $emballage->save();

                // 🛑 Debug : voir le contenu après modif
            });

            return redirect()->back()->with('success', 'Emballage mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function editbouteille(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'id' => 'required|exists:articles,id',
            'quantite'   => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $article = Article::findOrFail($request->id);
                $article->vides = $request->quantite;
                $article->save();

                // 🛑 Debug
            });

            return redirect()->back()->with('success', 'Quantité de bouteilles vides mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    // public function reinitiliserarticle($id)
    // {
    //     try {
    //         DB::transaction(function () use ($id) {
    //             $article = Article::findOrFail($id);
    //             $article->vides = 0;
    //             $article->save();

    //             // 🛑 Debug
    //             dd($article);
    //         });

    //         return redirect()->back()->with('success', 'Le nombre de bouteilles vides a été réinitialisé avec succès.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de la réinitialisation : ' . $e->getMessage());
    //     }
    // }

    // public function reinitialisercageot($id)
    // {
    //     try {
    //         DB::transaction(function () use ($id) {
    //             $emballage = Emballage::findOrFail($id);
    //             $emballage->quantite = 0;
    //             $emballage->save();

    //             // 🛑 Debug
    //             dd($emballage);
    //         });

    //         return redirect()->back()->with('success', 'Le nombre de cageots vides a été réinitialisé avec succès.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de la réinitialisation : ' . $e->getMessage());
    //     }
    // }
}
