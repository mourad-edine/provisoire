<?php

namespace App\Http\Controllers\consignation;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Consignation;
use App\Models\ConsignationAchat;
use App\Models\Param;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConsignationController extends Controller
{
    public function show()
    {
        //dd(Categorie::all());
        return view('pages.categorie.Liste', [
            'categorie' => Consignation::all()
        ]);
    }

    public function payer(Request $request)
    {
        //dd($request->all());
        if ($request) {
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            $id = $request->vente_id;
            //dd($id);

            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'vente_id_bouteille' => $request->vente_id,
            //     'consignation_id' => $request->consignation_id,
            // ]);

            $consignation = Consignation::find($request->consignation_id);
            if ($consignation) {
                $consignation->etat = ($bouteille == 1) ? 'rendu' : $consignation->etat;
                $consignation->etat_cgt = ($cageot == 1) ? 'rendu' : $consignation->etat_cgt;
                $consignation->prix = ($bouteille == 1) ? 0 : $consignation->prix;
                $consignation->prix_cgt = ($cageot == 1) ? 0 : $consignation->prix_cgt;
                $consignation->save();
            }
            return redirect()->back()
                ->with('success', 'Paiement enregistré avec succès.')
                ->with('highlighted_id', $id);
        }
    }

    public function payerAchat(Request $request)
    {
        //dd($request->all());
        if ($request) {
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            $id = $request->vente_id;
            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'vente_id_bouteille' => $request->vente_id,
            //     'consignation_id' => $request->consignation_id,
            // ]);

            $consignation = ConsignationAchat::find($request->consignation_id);
            if ($consignation) {
                $consignation->etat = ($bouteille == 1) ? 'rendu' : $consignation->etat;
                $consignation->etat_cgt = ($cageot == 1) ? 'rendu' : $consignation->etat_cgt;
                $consignation->prix = ($bouteille == 1) ? 0 : $consignation->prix;
                $consignation->prix_cgt = ($cageot == 1) ? 0 : $consignation->prix_cgt;
                $consignation->save();
            }
            return redirect()->back()
                ->with('success', 'Paiement enregistré avec succès.')
                ->with('highlighted_id', $id);
        }
    }

    public function parametre()
    {
        $articles = Article::whereIn('type_btl', [33, 65, 100])
            ->get()
            ->keyBy('type_btl');
        //dd($articles);
        return view('pages.parametre.params', [
            'type33' => $articles->get(33),
            'type65' => $articles->get(65),
            'type100' => $articles->get(100),
            'users' => User::all(),
            'params' => Param::all()
        ]);
    }


    public function prix(Request $request)
    {
        $validated = $request->validate([
            'consignation_bouteille_33' => 'nullable|numeric|min:0',
            'consignation_bouteille_65' => 'nullable|numeric|min:0',
            'consignation_bouteille_100' => 'nullable|numeric|min:0',
            'consignation_cageot' => 'nullable|numeric|min:0',
        ]);

        // Mise à jour des articles uniquement si une valeur est fournie
        if (isset($validated['consignation_bouteille_33'])) {
            Article::whereIn('type_btl', ['30', '33'])->update(['prix_consignation' => $validated['consignation_bouteille_33']]);
        }

        if (isset($validated['consignation_bouteille_65'])) {
            Article::whereIn('type_btl', ['50', '65'])->update(['prix_consignation' => $validated['consignation_bouteille_65']]);
        }

        if (isset($validated['consignation_bouteille_100'])) {
            Article::where('type_btl', '100')->update(['prix_consignation' => $validated['consignation_bouteille_100']]);
        }
        if (isset($validated['consignation_cageot'])) {
            Article::query()->update(['prix_cgt' => $validated['consignation_cageot']]);
        }




        return redirect()->back()->with('success', 'Les prix des consignation ont été mis à jour avec succès.');
    }

    public function adduser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|', // 'password_confirmation' doit être envoyé
        ]);

        // Création de l'utilisateur
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()
            ->with('success', 'utilisateur enregistré avec succès.');
    }
}
