<?php

namespace App\Http\Controllers\article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show()
    {
        $articles = Article::with('categorie')
            ->orderBy('id', 'DESC') // Facultatif : Tri par ID descendant
            ->paginate(6);

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
                'created_at' => Carbon::parse($article->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        return view('pages.article.Liste', [
            'articles' => $articles,
            'categories' => Categorie::all(),
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        if ($request) {
            $tab = [
                'categorie_id' => (int)$request->categorie_id,
                'nom' => $request->nom,
                'reference' => $request->reference ? $request->reference : null,
                'imagep' => $request->imagep ? $request->imagep : null,
                'prix_unitaire' => (int)$request->prix_unitaire,
                'conditionnement' => $request->conditionnement ? $request->conditionnement : null,
                'prix_consignation' => $request->prix_consignationn ? $request->prix_consignation : null,
                'prix_conditionne' =>   $request->prix_conditionne ? $request->prix_conditionne : null,
                'quantite' => $request->quantite ?  (int)$request->quantite : 0,
                'prix_achat' => $request->prix_achat ?  (int)$request->prix_achat : 0,

            ];

            $insert = Article::create($tab);
            if ($insert) {
                return redirect()->route('article.liste')->withSuccess('Success', 'success');
            }
        }

        //return redirect()->route('categorie.liste')->withErrors('Error', 'veuillez réessayer !!');
    }

    public function consignation() {}

    public function update(Request $request)
    {
        $article = Article::find($request->id);
        //dd($request->all() ,$article);
        //dd($article);
        if ($article) {
            $article->categorie_id = (int)$request->categorie_id ? (int)$request->categorie_id : $article->categorie_id;
            $article->nom = $request->nom ? $request->nom : $article->nom;
            $article->prix_unitaire = (int)$request->prix_unitaire  ? (int)$request->prix_unitaire : $article->prix_unitaire;
            $article->conditionnement = $request->conditionnement ? $request->conditionnement : $article->conditionnement;
            $article->prix_achat = $request->prix_achat ?  (int)$request->prix_achat : $article->prix_vente;

            $article->save();
            return redirect()->route('article.liste')->withSuccess('Success', 'success');
        }
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->delete();
            return redirect()->back()->withSuccess('Success', 'article supprimé avec success success');
        }

    }
}
