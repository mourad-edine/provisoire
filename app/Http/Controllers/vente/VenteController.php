<?php

namespace App\Http\Controllers\vente;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    public function show(){
        $ventes = Vente::with('article')->orderby('id' , 'DESC')->get()->map(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'quantite' => $vente->quantite,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        //dd($ventes);
        return view('pages.vente.Liste' ,[
            'ventes' => $ventes->take(6),
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
        ]);
    }


    public function store(Request $request){
        //dd($request->all());
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'required|array',
            'dateventes' => 'required|array',
            'prices' => 'required|array',
        ]);

        $commande = Commande::create([
            'user_id'=> Auth::user()->id,
            'client_id' => $request->client_id
        ]);
        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            Vente::create([
                'article_id' => $article,
                'commande_id' => $commande->id,
                'quantite' => $data['quantites'][$index],
                'date_sortie' => $data['dateventes'][$index],
                'prix' => $data['prices'][$index],
            ]);
        }
    
        return redirect()->back()->with('success', 'ventes enregistrés avec succès.');
    
    }
}
