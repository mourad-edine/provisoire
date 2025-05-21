<?php

namespace App\Http\Controllers\stock;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');

        $query = Article::query();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
            ->orWhereHas('categorie', function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('id', 'DESC')
                          ->paginate(6)
                          ->withQueryString();

        return view('pages.stock.Stock', [
            'articles' => $articles,
        ]);
    }

    public function faible(Request $request)
    {
        $search = $request->input('search');

        $query = Article::where('quantite', '<', 24);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
            ->orWhereHas('categorie', function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('id', 'DESC')
                          ->paginate(6)
                          ->withQueryString();

        return view('pages.stock.Faible', [
            'articles' => $articles,
        ]);
    }

    public function stockbyCategorie(Request $request, $id)
    {
        $search = $request->input('search');

        $query = Article::where('categorie_id', $id);

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
            ->orWhereHas('categorie', function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('id', 'DESC')
                          ->paginate(6)
                          ->withQueryString();

        return view('pages.stock.Article_categorie', [
            'articles' => $articles,
            'categorie_id' => $id,
        ]);
    }

    public function categorie(){
        return view('pages.stock.Categorie',[
            'categories' => Categorie::withCount('articles')->get()
        ]);
    }
}
