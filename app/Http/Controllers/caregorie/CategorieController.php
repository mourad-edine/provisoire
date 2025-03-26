<?php

namespace App\Http\Controllers\caregorie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function show(){

        $Categories = Categorie::withCount('articles')->orderby('id','DESC')->paginate(10);
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

    public function update(Request $request){
        //dd($request->all());
        $categories = Categorie::find($request->id);
        if ($categories) {
            $categories->nom = $request->nom ? $request->nom : $categories->nom;
            $categories->imagep = $request->imagep ? $request->imagep : null;
            $categories->reference = $request->reference ? $request->reference : null;
            $categories->save();
            return redirect()->back()->withSuccess('Success', 'success');
        }
    }

    public function delete($id)
    {
        //dd($id);
        $article = Categorie::find($id);
        if ($article) {
            $article->delete();
            return redirect()->back()->withSuccess('Success', 'categorie supprimé avec success success');
        }

    }
}
