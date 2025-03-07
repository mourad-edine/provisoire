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
    //public $nombre =  10;
    public function show()
    {
        //dd(Vente::with('consignation')->get()->toArray());
        $ventes = Vente::with('article', 'consignation')->orderby('id', 'DESC')->get()->map(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation' => $vente->consignation ? $vente->consignation->prix : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,

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
            if ($article->quantite < ($quantite * (int)$article->conditionnement)) {
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = (int)$article->quantite - ($quantite * (int)$article->conditionnement);
        } else if ($types == 1) {
            if ($article->quantite < $quantite) {
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = $article->quantite - $quantite;
        }
        $article->save();
    }

    public function getArticle($id)
    {
        return Article::find($id);
    }

    public function consignation(int $type, int $idvente, int $article, int $quantite)
    {
        $articleObj = $this->getArticle($article);

        if ($type === 0) {  // Type cageot
            $prix_consignation = $articleObj->prix_consignation
                ? $articleObj->prix_consignation * $quantite * ($articleObj->conditionnement ?? 1)
                : 500;

            Consignation::create([
                'vente_id' => $idvente,
                'etat' => 'non rendu',
                'prix' => $prix_consignation,
                'date_consignation' => now(),
                'type_consignation' => false
            ]);
        } elseif ($type === 1) {  // Type bouteille
            Consignation::create([
                'vente_id' => $idvente,
                'etat' => 'non rendu',
                'prix' => 700 * $quantite, // Prix fixe par bouteille
                'date_consignation' => now(),
                'type_consignation' => true
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
            'types' => 'required|array',
            'consignations' => 'required|array',
        ]);

        $commande = Commande::create([
            'user_id' => Auth::user()->id,
            'client_id' => $request->client_id
        ]);

        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            $type = (int) $data['types'][$index]; // Convertir en entier pour éviter les erreurs de type

            $vente = Vente::create([
                'article_id' => $article,
                'commande_id' => $commande->id,
                'quantite' => $data['quantites'][$index],
                'date_sortie' => $data['dateventes'][$index],
                'prix' => $data['prices'][$index],
                'type_achat' => $type === 0 ? 'cageot' : 'bouteille'
            ]);

            $this->updatearticle($article, $type, $data['quantites'][$index]);

            // Correction : Passer $type au lieu de $data['consignations'][$index]
            if($data['consignations'][$index] == '0'){
                $this->consignation($type, $vente->id, $article, $data['quantites'][$index]);
            }
        }

        return redirect()->back()->with('success', 'Ventes enregistrées avec succès.');
    }


    public function showcommande()
    {
        //dd(Commande::withcount('ventes')->get()->toArray());
        return view('pages.vente.commande', [
            'commandes' => Commande::withCount('ventes')
                ->having('ventes_count', '>', 0)
                ->orderBy('id', 'DESC')
                ->take(6)
                ->get(),
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
        ]);
    }

    public function DetailCommande($id)
    {
        $ventes = Vente::with('article', 'consignation')->where('commande_id',$id)->orderby('id', 'DESC')->get()->map(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation' => $vente->consignation ? $vente->consignation->prix : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,

            ];
        });
        //dd($ventes);
        return view('pages.vente.Detail', [
            'ventes' => $ventes,
        ]);
    }
}
