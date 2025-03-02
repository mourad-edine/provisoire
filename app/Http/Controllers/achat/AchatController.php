<?php

namespace App\Http\Controllers\achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Fournisseur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function show(){

        $achats = Achat::with('articles')->get()->map(function ($achat) {
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
            'achats' => $achats,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all()
        ]);
    }

    public function store(Request $request){
        dd($request->all());
    }
}
