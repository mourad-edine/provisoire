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
            'fournisseurs' => Fournisseur::paginate(6)
        ]);
    }

    public function store(Request $request){
        if ($request) {
            $tab = [
                'nom' => $request->nom,
                'numero' => $request->numero,
                'reference' =>$request->reference ? $request->reference : null,
            ];

            $insert = Fournisseur::create($tab);
            if ($insert) {
                return redirect()->route('fournisseur.liste')->withSuccess('Success', 'success');
            }
        }
    }

    public function performance(){
        return view('pages.fournisseur.performance');
    }

    public function delete($id)
    {
        //dd($id);
        $fournisseur = Fournisseur::find($id);
        if ($fournisseur) {
            $fournisseur->delete();
            return redirect()->back()->withSuccess('Success', 'fournisseur supprimé avec success success');
        }

    }
}
