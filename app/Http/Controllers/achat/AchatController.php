<?php

namespace App\Http\Controllers\achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Consignation;
use App\Models\ConsignationAchat;
use App\Models\Fournisseur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchatController extends Controller
{
    public function show()
    {
        //dd(Auth::user()->id);
        $achats = Achat::with('articles','consignation_achat')
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $achats->getCollection()->transform(function ($achat) {
            return [
                'id' => $achat->id,
                'prix_achat' => $achat->articles ? $achat->articles->prix_achat : null,
                'prix' => $achat->prix,
                'conditionnement' => $achat->articles ? $achat->articles->conditionnement : null,
                'consignation_id' => $achat->consignation_achat ? $achat->consignation_achat->id : null,
                'article' => $achat->articles ? $achat->articles->nom : null,
                'numero_commande' => $achat->commande_id,
                'etat' => $achat->consignation_achat ? $achat->consignation_achat->etat : null,
                'etat_cgt' => $achat->consignation_achat ? $achat->consignation_achat->etat_cgt : null,
                'prix_cgt' => $achat->consignation_achat ? $achat->consignation_achat->prix_cgt : null,
                'prix' => $achat->consignation_achat ? $achat->consignation_achat->prix : null,
                'quantite' => $achat->quantite,
                'created_at' => Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        return view('pages.achat.Liste', [
            'achats' => $achats,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }

    public function store(Request $request)
    {
    //dd($request->all());
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'required|array',
            'dateachat' => 'required|array',
            'prices' => 'required|array',
            'fournisseurs' => 'required|array',
            'cageots' => 'required|array',
            'bouteilles' => 'required|array',
            'consignations' => 'required|array',
        ]);

        $commande = Commande::create([
            'user_id' => Auth::user()->id
        ]);
        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            $achat = Achat::create([
                'article_id' => $article,
                'commande_id' => $commande->id,
                'quantite' => $data['quantites'][$index],
                'date_entre' => $data['dateachat'][$index],
                'prix' => $data['prices'][$index],
                'fournisseur_id' => $data['fournisseurs'][$index],
            ]);
            // Mise à jour de la quantité d'article
            $article = Article::find($article);
            $article->quantite = $article->quantite + ($data['quantites'][$index] * (int)$article->conditionnement);
            $article->prix_achat = $data['prices'][$index];
            $article->prix_unitaire = $data['prices'][$index] + 100;
            $article->save();
            if($data['consignations'][$index] == 1){
                $this->consignation($achat->id , $data['quantites'][$index] , $article->id , $data['bouteilles'][$index] , $data['cageots'][$index]);
            }
        }

        return redirect()->back()->with('success', 'Achats enregistrés avec succès.');
    }


    public function consignation(int $achat_id , int $quantite , int $article_id ,int $bouteille ,int $cageot)
    {

        $article = Article::find($article_id);
      
        if($article){//cageot
            $totalcageot  = ($cageot == 0) ? $quantite * $article->prix_cgt : 0;
            $totalbouteille = ($bouteille == 0) ?  $quantite * $article->prix_consignation * $article->conditionnement  : 0;
            // dd([
            //     'bouteille' => $totalbouteille,
            //     'cageots'=> $totalcageot
            // ]);
            ConsignationAchat::create([
                'achat_id' => $achat_id,
                'prix' => $totalbouteille,
                'prix_cgt' => $totalcageot,
                'etat' => ($bouteille == 0) ? 'non rendu' : 'non consigné',
                'etat_cgt' => ($totalcageot == 0) ? 'non consigné' : 'non rendu',
                'date_consignation' => Carbon::now(),
            ]);
        }
    }

    public function commande(){
        
        return view('pages.achat.commande', [
                'commandes' => Commande::withcount('achats')
                ->having('achats_count', '>', 0)
                ->orderBy('id', 'DESC')
                ->paginate(6),
                'articles' => Article::all(),
                'fournisseurs' => Fournisseur::all(),
        ]);
    }

    public function detailcommande($id){
        $achats = Achat::with('articles','consignation_achat')
            ->where('commande_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $achats->getCollection()->transform(function ($achat) {
            return [
                'id' => $achat->id,
                'prix_achat' => $achat->articles ? $achat->articles->prix_achat : null,
                'prix' => $achat->prix,
                'article' => $achat->articles ? $achat->articles->nom : null,
                'conditionnement' => $achat->articles ? $achat->articles->conditionnement : null,
                'numero_commande' => $achat->commande_id,
                'consignation_id' => $achat->consignation_achat ? $achat->consignation_achat->id : null,
                'etat' => $achat->consignation_achat ? $achat->consignation_achat->etat : null,
                'etat_cgt' => $achat->consignation_achat ? $achat->consignation_achat->etat_cgt : null,
                'prix_cgt' => $achat->consignation_achat ? $achat->consignation_achat->prix_cgt : null,
                'prix' => $achat->consignation_achat ? $achat->consignation_achat->prix : null,
                'quantite' => $achat->quantite,
                'created_at' => Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        return view('pages.achat.Detail', [
            'achats' => $achats,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }
}
