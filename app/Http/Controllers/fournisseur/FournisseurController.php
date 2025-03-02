<?php

namespace App\Http\Controllers\fournisseur;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function show(){
        //dd(Fournisseur::all());
        return view('pages.fournisseur.Liste' ,[
            'fournisseurs' => Fournisseur::all()
        ]);
    }
}
