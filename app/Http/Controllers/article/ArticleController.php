<?php

namespace App\Http\Controllers\article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function search()
    {
        $search = $_GET['search'];
        dd("salut");

        $articlesQuery = Article::with('categorie')
            ->when($search, function ($query, $search) {
                return $query->where('nom', 'like', "%{$search}%")
                    ->orWhereHas('categorie', function ($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%");
                    });
            });

        $articles = $articlesQuery->orderBy('id', 'DESC')->paginate(10);
        $articles->appends(['search' => $search]); // pour conserver le search dans l'URL de pagination

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

    public function show(Request $request)
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
        //dd($articles->toArray());

        return view('pages.article.Liste', [
            'articles' => $articles,
            'categories' => Categorie::all(),
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $type_btl = 0;
        $consignation = 0;
        if ($request->conditionnement == 24) {
            $consignation = 400;
            $type_btl = 33;
        } else if ($request->conditionnement == 20) {
            $consignation = 500;
            $type_btl = 65;
        } else if ($request->conditionnement == 12) {
            $consignation = 700;
            $type_btl =100;
        }
        $pck = ($request->choix == 'pack') ? 1 : 0;
        $condjet =($request->choix == 'jet') ? 1 : 0;
        if($condjet == 1){
            //dd('eto');
            $tabs = [
                'categorie_id' => (int)$request->categorie_id,
                'nom' => $request->nom,
                'reference' => $request->reference ? $request->reference : null,
                'imagep' => $request->imagep ? $request->imagep : null,
                'prix_unitaire' => (int)$request->prix_unitaire,
                'conditionnement' => $request->conditionnement ? $request->conditionnement : null,
                'prix_consignation' => $request->diff ?? 0,
                'prix_conditionne' =>   $request->prix_conditionne ? $request->prix_conditionne : null,
                'prix_cgt' => 0,
                'type_btl' => 0,
                'quantite' => $request->quantite ?  (int)$request->quantite : 0,
                'prix_achat' => $request->prix_achat ?  (int)$request->prix_achat : 0,

            ];
            $insert = Article::create($tabs);
            if ($insert) {
                return redirect()->route('article.liste')->withSuccess('Success', 'success');
            }
        }
        if ($condjet == 0) {
            $t = ($pck == 0) ? $type_btl : 0;
            $tab = [
                'categorie_id' => (int)$request->categorie_id,
                'nom' => $request->nom,
                'reference' => $request->reference ? $request->reference : null,
                'imagep' => $request->imagep ? $request->imagep : null,
                'prix_unitaire' => (int)$request->prix_unitaire,
                'conditionnement' => $request->conditionnement ? $request->conditionnement : null,
                'prix_consignation' => ($pck == 0) ? ($request->diff != null ? $request->diff : $consignation) : 0,
                'prix_conditionne' =>   $request->prix_conditionne ? $request->prix_conditionne : null,
                'prix_cgt' => ($pck == 0) ? 8000 : 0,
                'type_btl' => ($pck == 0) ? ($request->diff != null ? 0 : $type_btl ): 0,
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

    // public function update(Request $request)
    // {
    //     $article = Article::find($request->id);
    //     //dd($request->all() ,$article);
    //     //dd($article);
    //     if ($article) {
    //         $article->categorie_id = (int)$request->categorie_id ? (int)$request->categorie_id : $article->categorie_id;
    //         $article->nom = $request->nom ? $request->nom : $article->nom;
    //         $article->prix_unitaire = (int)$request->prix_unitaire  ? (int)$request->prix_unitaire : $article->prix_unitaire;
    //         $article->conditionnement = $request->conditionnement ? $request->conditionnement : $article->conditionnement;
    //         $article->prix_achat = $request->prix_achat ?  (int)$request->prix_achat : $article->prix_vente;

    //         $article->save();
    //         return redirect()->back()->withSuccess('Success', 'success');
    //     }
    // }

    public function update(Request $request)
{
    $article = Article::find($request->id);

    if ($article) {
        $type_btl = 0;
        $consignation = 0;
        if ($request->conditionnement == 24) {
            $consignation = 400;
            $type_btl = 33;

        } else if ($request->conditionnement == 20) {
            $consignation = 500;
            $type_btl = 65;
        } else if ($request->conditionnement == 12) {
            $consignation = 700;
            $type_btl = 100;
        }

        $pck = ($request->input('choix_'.$article->id) == 'pack') ? 1 : 0;
        $condjet = ($request->input('choix_'.$article->id) == 'jet') ? 1 : 0;
        //dd($request->input('choix_'.$article->id));
        $article->categorie_id = (int) $request->categorie_id;
        $article->nom = $request->nom;
        $article->reference = $request->reference ?? null;
        $article->imagep = $request->imagep ?? null;
        $article->prix_unitaire = (int) $request->prix_unitaire;
        $article->conditionnement = $request->conditionnement ?? null;

        if ($condjet == 1) {
            // Bouteille jetable
            $article->prix_consignation =  $request->input('diff_'.$article->id) ? $request->input('diff_'.$article->id) : $request->prix_consignation;
            //dd($request->input('diff_'.$article->id));
            $article->prix_cgt = 0;
            $article->type_btl = 0;
        } else {
            // Pack ou Cageot
            $article->prix_consignation = ($pck == 1) ? 0 : ($request->input('diff_'.$article->id) != null ? $request->input('diff_'.$article->id) : (($article->type_btl == 0 || $article->type_btl == null) && ($article->prix_consignation > 0) ? $request->prix_consignation : $consignation));
            $article->prix_cgt = ($pck == 1) ? 0 : 8000;
            $article->type_btl = ($pck == 1) ? 0 : ($request->input('diff_'.$article->id)!= null ? 0 : $type_btl);
        }
        //dd($article->toArray());
        $article->prix_conditionne = $request->prix_conditionne ?? null;
        // $article->quantite = $request->quantite ? (int) $request->quantite : 0;
        $article->prix_achat = $request->prix_achat ? (int) $request->prix_achat : 0;
        //dd($article->toArray());
        $article->save();

        return redirect()->back()->withSuccess('Article mis à jour avec succès.');
    }

    return redirect()->back()->withErrors('Article introuvable ou mise à jour échouée.');
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
