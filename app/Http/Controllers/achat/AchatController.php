<?php

namespace App\Http\Controllers\achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Fournisseur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchatController extends Controller
{
    public function show(){
        //dd(Auth::user()->id);
        $achats = Achat::with('articles')->orderby('id' , 'DESC')->get()->map(function ($achat) {
            return [
                'id' => $achat->id,
                'prix' => $achat->prix,
                'article' => $achat->articles ? $achat->articles->nom : null,
                'numero_commande' => $achat->commande_id,
                'quantite' => $achat->quantite,
                'created_at' => Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('pages.achat.Liste' ,[
            'achats' => $achats->take(6),
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all()
        ]);
    }

    public function store(Request $request){
        //dd($request->all());
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'required|array',
            'dateachat' => 'required|array',
            'prices' => 'required|array',
            'fournisseurs' => 'required|array',
        ]);

        $commande = Commande::create([
            'user_id'=> Auth::user()->id
        ]);
        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            Achat::create([
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
            $article->prix_unitaire = $data['prices'][$index];
            $article->save();
        }
    
        return redirect()->back()->with('success', 'Achats enregistrés avec succès.');
    }
}
