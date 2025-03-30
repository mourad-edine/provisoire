<?php

namespace App\Http\Controllers\stock;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show(){
        return view('pages.stock.Stock' ,[
            'articles' => Article::paginate(6)
        ]);
    }

    public function faible(){
        return view('pages.stock.Faible', [
            'articles' => Article::where('quantite' , '<' , 100)->paginate(6)
        ]);
    }

    public function stockbyCategorie($id){
        return view('pages.stock.Article_categorie', [
            'articles' => Article::where('categorie_id' , $id)->paginate(6)]);
    }

    public function categorie(){
        return view('pages.stock.Categorie',[
            'categories' => Categorie::withCount('articles')->get()
        ]);
    }
}
