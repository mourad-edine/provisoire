<?php

namespace App\Http\Controllers\vente;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Consignation;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    public function show()
    {
        $ventes = Vente::with('article')->orderby('id', 'DESC')->get()->map(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        //dd($ventes);
        return view('pages.vente.Liste', [
            'ventes' => $ventes->take(6),
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
        ]);
    }

    
    public function updatearticle($id, int $types, int $quantite)
    {
        $article = Article::find($id);
        if ($types == 0) {
            if($article->quantite < ($quantite * (int)$article->conditionnement)){
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = (int)$article->quantite - ($quantite * (int)$article->conditionnement);
        } else if ($types == 1) {
            if($article->quantite < $quantite){
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = $article->quantite - $quantite;
        }
        $article->save();
    }

    public function getArticle($id){
        return Article::find($id);
    }
    
    public function consignation(int $type , int $idvente , int $article){
        if($type == '0'){
            Consignation::create([
                'vente_id' => $idvente,
                'etat' => 'non rendu',
                'prix' => $this->getArticle($article)->prix_consignation ? $this->getArticle($article)->prix_consignation : 500,
                'date_consignation' => now(),
                'type_consignation' => false
            ]);
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'required|array',
            'dateventes' => 'required|array',
            'prices' => 'required|array',
            'types' => "required|array",
            'consignations' => 'required|array',
            
        ]);

        $commande = Commande::create([
            'user_id' => Auth::user()->id,
            'client_id' => $request->client_id
        ]);
        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            if ($data['types'][$index] == '0') {
                $tab = Vente::create([
                    'article_id' => $article,
                    'commande_id' => $commande->id,
                    'quantite' => $data['quantites'][$index],
                    'date_sortie' => $data['dateventes'][$index],
                    'prix' => $data['prices'][$index],
                    'type_achat' => 'cageot'
                ]);
                $this->updatearticle($article, 0, $data['quantites'][$index]);
                $this->consignation($data['consignations'][$index] , $tab->id , $article);
            } else if ($data['types'][$index] == '1') {
                $tab = Vente::create([
                    'article_id' => $article,
                    'commande_id' => $commande->id,
                    'quantite' => $data['quantites'][$index],
                    'date_sortie' => $data['dateventes'][$index],
                    'prix' => $data['prices'][$index],
                    'type_achat' => 'bouteille'
                ]);
                $this->updatearticle($article, 1, $data['quantites'][$index]);
                $this->consignation($data['consignations'][$index] , $tab->id , $article);
            }
        }

        return redirect()->back()->with('success', 'ventes enregistrés avec succès.');
    }

  
}
