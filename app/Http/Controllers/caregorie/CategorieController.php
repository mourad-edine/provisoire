<?php

namespace App\Http\Controllers\caregorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function show(){

        $Categories = Categorie::withCount('articles')->get();
        //dd($Categories);
        return view('pages.categorie.Liste' ,[
            'categories' => $Categories
        ]);
    }
}
