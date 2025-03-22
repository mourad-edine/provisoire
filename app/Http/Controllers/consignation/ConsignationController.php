<?php

namespace App\Http\Controllers\consignation;

use App\Http\Controllers\Controller;
use App\Models\Consignation;
use App\Models\ConsignationAchat;
use Illuminate\Http\Request;

class ConsignationController extends Controller
{
    public function show(){
        //dd(Categorie::all());
        return view('pages.categorie.Liste' ,[
            'categorie' => Consignation::all()
        ]);
    }

    public function payer(Request $request){
        //dd($request->all());
        if($request){
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'vente_id_bouteille' => $request->vente_id,
            //     'consignation_id' => $request->consignation_id,
            // ]);

            $consignation = Consignation::find($request->consignation_id);
            if($consignation){
                $consignation->etat = ($bouteille == 1) ? 'non consigné' : $consignation->etat;
                $consignation->etat_cgt = ($cageot == 1) ? 'non consigné' : $consignation->etat_cgt;
                $consignation->prix = ($bouteille == 1) ? 0 : $consignation->prix;
                $consignation->prix_cgt = ($cageot == 1) ? 0 : $consignation->prix_cgt;
                $consignation->save();
            }
            return redirect()->back()->with('success', 'payement enregistrés avec succès.');

        }
    }

    public function payerAchat(Request $request){
        //dd($request->all());
        if($request){
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'vente_id_bouteille' => $request->vente_id,
            //     'consignation_id' => $request->consignation_id,
            // ]);

            $consignation = ConsignationAchat::find($request->consignation_id);
            if($consignation){
                $consignation->etat = ($bouteille == 1) ? 'non consigné' : $consignation->etat;
                $consignation->etat_cgt = ($cageot == 1) ? 'non consigné' : $consignation->etat_cgt;
                $consignation->prix = ($bouteille == 1) ? 0 : $consignation->prix;
                $consignation->prix_cgt = ($cageot == 1) ? 0 : $consignation->prix_cgt;
                $consignation->save();
            }
            return redirect()->back()->with('success', 'payement enregistrés avec succès.');

        }
    }
}
