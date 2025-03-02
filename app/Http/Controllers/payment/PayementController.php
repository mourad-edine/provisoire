<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\Payement;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    public function show(){
        //dd(Categorie::all());
        return view('pages.categorie.Liste' ,[
            'categorie' => Payement::all()
        ]);
    }
}
