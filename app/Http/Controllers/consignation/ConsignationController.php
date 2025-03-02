<?php

namespace App\Http\Controllers\consignation;

use App\Http\Controllers\Controller;
use App\Models\Consignation;
use Illuminate\Http\Request;

class ConsignationController extends Controller
{
    public function show(){
        //dd(Categorie::all());
        return view('pages.categorie.Liste' ,[
            'categorie' => Consignation::all()
        ]);
    }
}
