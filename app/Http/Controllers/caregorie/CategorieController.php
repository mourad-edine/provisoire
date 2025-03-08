<?php

namespace App\Http\Controllers\caregorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function show(){

        $Categories = Categorie::withCount('articles')->paginate(6);
        //dd($Categories);
        return view('pages.categorie.Liste' ,[
            'categories' => $Categories
        ]);
    }

    public function store(Request $request){
        //dd($request->all());

        if ($request) {
            $tab = [
                'nom' => $request->nom,
                'imagep' => $request->imagep ? $request->imagep : null,
                'reference' =>$request->reference ? $request->reference : null,
            ];

            $insert = Categorie::create($tab);
            if ($insert) {
                return redirect()->route('categorie.liste')->withSuccess('Success', 'success');
            }
        }
    }
}
