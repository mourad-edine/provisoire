<?php

namespace App\Http\Controllers\article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(){
        $articles = Article::with('categorie')->get()->map(function ($article) {
            return [
                'id' => $article->id,
                'nom' => $article->nom,
                'categorie' => $article->categorie ? $article->categorie->nom : null,
                'prix_unitaire' => $article->prix_unitaire,
                'prix_conditionne' => $article->prix_conditionne,
                'quantite' => $article->quantite,
                'created_at' => Carbon::parse($article->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        //dd($articles);
        return view('pages.article.Liste' ,[
            'articles' => $articles
        ]);
    }
}
