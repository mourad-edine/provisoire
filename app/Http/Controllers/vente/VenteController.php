<?php

namespace App\Http\Controllers\vente;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function show(){
        $ventes = Vente::with('article')->get()->map(function ($vente) {
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
            'ventes' => $ventes,
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Vente::latest()->first()
        ]);
    }
}
