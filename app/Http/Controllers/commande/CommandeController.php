<?php

namespace App\Http\Controllers\commande;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function show(){
        dd(Commande::all()->toArray());
        return view('pages.categorie.Liste' ,[
            'categorie' => Commande::all()
        ]);
    }
}
