<?php

namespace App\Http\Controllers\consignation;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Conditionnement;
use App\Models\Consignation;
use App\Models\ConsignationAchat;
use App\Models\Param;
use App\Models\Payement;
use App\Models\User;
use App\Models\Vente;
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

    public function operation($operation, $commande_id, $mode_paye, $somme)
    {
        $mode_paye = "espèce";
        Payement::create([
            'commande_id' => $commande_id,
            'mode_paye' => $mode_paye,
            'somme' => $somme,
            'operation' => $operation
        ]);
    }

    public function payer(Request $request)
    {
        $article = Article::find($request->article_id);

        if ($request) {
            $consignation = Consignation::find($request->consignation_id);

            $casse = $request->casse != null ||  $request->input('casse') != 0 ? 1 : 0;
            $casse_cageot = $request->cageot_casse != null || isset($request->cageot_casse) ? 1 : 0;
            if ($casse == 1 || $casse_cageot == 1) {
                if ($casse == 1) {
                    $nouveauPrix = $consignation->prix - ($request->casse);
                    $etat = ($nouveauPrix == 0) ? 'rendu' : $consignation->etat;

                    $consignation->prix = $nouveauPrix;
                    $consignation->etat = $etat;
                    $consignation->casse += $request->casse;
                    $consignation->save();
                    $this->operation('casse', $request->commande_id, $request->mode_paye, ($request->casse * $article->prix_consignation));
                }

                if ($casse_cageot == 1) {
                    $nouveauPrixCgt = $consignation->prix_cgt - ($request->cageot_casse);
                    $etatCgt = ($nouveauPrixCgt == 0) ? 'rendu' : $consignation->etat_cgt;

                    $consignation->prix_cgt = $nouveauPrixCgt;
                    $consignation->etat_cgt = $etatCgt;
                    $consignation->casse_cgt += $request->cageot_casse;
                    $consignation->save();
                    $this->operation('casse_cageot', $request->commande_id, $request->mode_paye, ($request->cageot_casse * $article->prix_cgt));
                }

                $this->verification($request->commande_id);

                // return redirect()->back()
                //     ->with('success', 'Paiement enregistré avec succès.')
                //     ->with('highlighted_id', $request->vente_id);
            }

            //dd('sorti');
            //dd([$casse ,$casse_cageot]);
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            $vente_id = $request->vente_id;
            $vente = Vente::find($vente_id);
            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'article' => $article,
            // ]);
            // Mise à jour de la consignation si elle existe
            //dd($consignation->prix);
            // if ($consignation) {
            //     $consignation->etat = ($bouteille == 1) ? 'rendu' : $consignation->etat;
            //     $consignation->etat_cgt = ($cageot == 1) ? 'rendu' : $consignation->etat_cgt;
            //     $consignation->prix = ($bouteille == 1) ? 0 : ($consignation->prix - ((int)$request->quantite_bouteille * $article->prix_consignation));
            //     $consignation->prix_cgt = ($cageot == 1) ? 0 : ($consignation->prix_cgt - ((int)$request->quantite_cageot * $article->prix_cgt));
            //     $consignation->save();
            // }
            if ($bouteille == 1 && $cageot == 1) {
                $consignation->etat = 'rendu';
                $consignation->etat_cgt = 'rendu';
                $consignation->prix = 0;
                $consignation->prix_cgt = 0;
                $consignation->rendu_btl += $request->total_btl;
                $consignation->rendu_cgt += $request->total_cgt;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentrebtl = $request->total_btl * $article->prix_consignation;
                $totentrecgt = $request->total_cgt * $article->prix_cgt;
                $this->operation('Déconsignation BTL', $request->commande_id, $request->mode_paye, $totentrebtl);
                $this->operation('Déconsignation CGT', $request->commande_id, $request->mode_paye, $totentrecgt);
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 0 && $cageot == 1) {
                $consignation->etat_cgt = 'rendu';
                $consignation->prix_cgt = 0;
                $consignation->rendu_cgt += $request->total_cgt;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentre = $request->total_cgt * $article->prix_cgt;
                $this->operation('cageot', $request->commande_id, $request->mode_paye, $totentre);
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 1 && $cageot == 0) {
                //dd('eto');
                $consignation->etat = 'rendu';
                $consignation->prix = 0;
                $consignation->rendu_btl += $request->total_btl;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentre = $request->total_btl * $article->prix_consignation;
                $this->operation('bouteille', $request->commande_id, $request->mode_paye, $totentre);
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 0 && $cageot == 0) {
                $prix_bouteille = (int)$request->quantite_buteille;
                $prix_cageot = (int)$request->quantite_cageot;
                //dd($consignation->prix_cgt);

                $actions_effectuees = false;

                if ($consignation->prix > $prix_bouteille) {
                    $consignation->prix -= $prix_bouteille;
                    $consignation->rendu_btl += $request->quantite_buteille;
                    $actions_effectuees = true;
                } elseif ($consignation->prix == $prix_bouteille) {
                    $consignation->prix = 0;
                    $consignation->etat = 'rendu';
                    $consignation->rendu_btl += $request->quantite_buteille;
                    $actions_effectuees = true;
                }
                //dd($request->quantite_cageot);
                if ($consignation->prix_cgt > $prix_cageot) {
                    $consignation->prix_cgt -= $prix_cageot;
                    $consignation->rendu_cgt += $request->quantite_cageot;
                    $actions_effectuees = true;
                } elseif ($consignation->prix_cgt == $prix_cageot && $request->quantite_cageot != null) {
                    $consignation->prix_cgt = 0;
                    $consignation->rendu_cgt += $request->quantite_cageot;
                    $consignation->etat_cgt = $vente->type_achat == 'cageot' ? 'rendu' : 'conditionné';
                    $actions_effectuees = true;
                }

                if ($actions_effectuees) {
                    $consignation->save();
                    $this->operation('cageot', $request->commande_id, $request->mode_paye, ($prix_cageot * $article->prix_cgt));
                    $this->operation('bouteille', $request->commande_id, $request->mode_paye, ($prix_bouteille * $article->prix_consignation));

                    $this->verification($request->commande_id);
                    return redirect()->back()
                        ->with('success', 'Paiement enregistré avec succès.')
                        ->with('highlighted_id', $vente_id);
                }
                return redirect()->back()
                        ->with('success', 'Paiement enregistré avec succès.')
                        ->with('highlighted_id', $request->vente->id);

                // Si aucun cas ne s'est déclenché
                dd([
                    'prix attendu bouteille' => $prix_bouteille,
                    'prix consignation bouteille' => $consignation->prix,
                    'prix attendu cageot' => $prix_cageot,
                    'prix consignation cageot' => $consignation->prix_cgt,
                    'bouteille égalité ?' => $consignation->prix == $prix_bouteille,
                    'cageot égalité ?' => $consignation->prix_cgt == $prix_cageot,
                ]);
                
            }

            // Vérifier si toutes les ventes liées à la commande ont prix et prix_cgt égaux à 0

        }
    }
    public function verification($commande_id)
    {
        $commande = Commande::with(['ventes.consignation', 'conditionnement'])
            ->where('id', $commande_id)
            ->first();

        if ($commande) {
            $toutesConsignationsAZero = $commande->ventes->every(function ($vente) {
                return optional($vente->consignation)->prix == 0 && optional($vente->consignation)->prix_cgt == 0;
            });

            // Vérifie si le conditionnement existe avant de mettre etat_client à 0
            if ($toutesConsignationsAZero && !$commande->conditionnement) {
                $commande->etat_client = 0;
                $commande->save();
            }
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
        $hasPrixSuperieurAZero = Article::where('prix_cgt', '>', 0)
            ->where('prix_consignation', '>', 0)
            ->exists(); // Les deux doivent être > 0

        if (
            isset($validated['consignation_cageot']) &&
            is_numeric($validated['consignation_cageot']) &&
            floatval($validated['consignation_cageot']) > 0 &&
            $hasPrixSuperieurAZero
        ) {
            Article::where('prix_cgt', '>', 0)
                ->where('prix_consignation', '>', 0)
                ->update([
                    'prix_cgt' => floatval($validated['consignation_cageot'])
                ]);
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

    public function rendrecondi(Request $request)
    {
        if ($request->has('commande_id')) {
            $ventes = Vente::where('commande_id', $request->commande_id)->get();
            //dd($ventes[id);
            // Vérification et mise à jour des consignations associées
            foreach ($ventes as $vente) {
                if ($vente->consignation && $vente->consignation->etat_cgt === 'conditionné') {
                    $vente->consignation->update(['etat_cgt' => 'rendu']);
                }
            }

            // Suppression du conditionnement s'il existe
            $conditionnement = Conditionnement::where('commande_id', $request->commande_id)->first();
            $vente = Vente::where('commande_id', $request->commande_id)->first();
            if ($conditionnement) {
                $consignation = Consignation::where('vente_id', $vente->id)->first();
                if(!$consignation){
                    Consignation::create([
                        'vente_id' => $vente->id,
                        'prix' => 0,
                        'prix_cgt' => 0,
                        'etat' => 'rendu',
                        'etat_cgt' => 'rendu',
                        'rendu_btl' => 0,
                        'rendu_cgt' => $conditionnement->nombre_cageot,
                    ]);
                }else{
                    $consignation->rendu_cgt += $conditionnement->nombre_cageot;
                    $consignation->save();
                }
                $conditionnement->delete();
            }

            // Vérification si toutes les consignations ont prix = 0 et prix_cgt = 0
            $commande = Commande::with('ventes.consignation')->where('id', $request->commande_id)->first();

            if ($commande) {
                $toutesConsignationsAZero = $commande->ventes->every(function ($vente) {
                    return optional($vente->consignation)->prix == 0 && optional($vente->consignation)->prix_cgt == 0;
                });

                if ($toutesConsignationsAZero) {
                    $commande->etat_client = 0;
                    $commande->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Rendu avec succès.');
    }

    public function ajour($vente_id ,$quantite){
        $vente = Vente::find($vente_id);
        //dd($vente->quantite >= $vente->quantite - $quantite);

        if ($vente) {
            if($vente->quantite != 0 ){
                $vente->quantite = $vente->quantite - $quantite;
                $vente->save();
            }
        }
        
    }

    public function rendrerendu(Request $request)
    {
        //dd($request->all());
        $article = Article::find($request->article_id);

        if ($request) {
            $consignation = Consignation::find($request->consignation_id);
            //$venteid = $consignation->vente_id;
            $vente_id = $request->vente_id;
            $vente = Vente::find($vente_id);
            $casse = $request->casse != null ||  $request->input('casse') != 0 ? 1 : 0;
            $casse_cageot = $request->cageot_casse != null || isset($request->cageot_casse) ? 1 : 0;
            if ($casse == 1 || $casse_cageot == 1) {
                if ($casse == 1) {
                    $nouveauPrix = $consignation->prix - ($request->casse);
                    $etat = ($nouveauPrix == 0) ? 'rendu' : $consignation->etat;

                    $consignation->prix = $nouveauPrix;
                    $consignation->etat = $etat;
                    $consignation->casse += $request->casse;
                    $consignation->save();
                    $this->operation('casse', $request->commande_id, $request->mode_paye, ($request->casse * $article->prix_consignation));
                }

                if ($casse_cageot == 1) {
                    $nouveauPrixCgt = $consignation->prix_cgt - ($request->cageot_casse);
                    $etatCgt = ($nouveauPrixCgt == 0) ? 'rendu' : $consignation->etat_cgt;

                    $consignation->prix_cgt = $nouveauPrixCgt;
                    $consignation->etat_cgt = $etatCgt;
                    $consignation->casse_cgt += $request->cageot_casse;
                    $consignation->save();
                    $this->operation('casse_cageot', $request->commande_id, $request->mode_paye, ($request->cageot_casse * $article->prix_cgt));
                }
                if($vente->type_achat == 'cageot' || $vente->type_achat ==  'pack'){
                    $this->ajour($vente_id ,$request->cageot_casse);
                }else{
                    $this->ajour($vente_id ,$request->casse);
                }
                $this->verification($request->commande_id);
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $request->vente_id);
            }

            //dd('sorti');
            //dd([$casse ,$casse_cageot]);
            $bouteille = $request->has('check_bouteille') ? 1 : 0;
            $cageot = $request->has('check_cageot') ? 1 : 0;
            
            // dd([
            //     'bouteille' => $bouteille,
            //     'cageot' => $cageot,
            //     'article' => $article,
            // ]);
            // Mise à jour de la consignation si elle existe
            //dd($consignation->prix);
            // if ($consignation) {
            //     $consignation->etat = ($bouteille == 1) ? 'rendu' : $consignation->etat;
            //     $consignation->etat_cgt = ($cageot == 1) ? 'rendu' : $consignation->etat_cgt;
            //     $consignation->prix = ($bouteille == 1) ? 0 : ($consignation->prix - ((int)$request->quantite_bouteille * $article->prix_consignation));
            //     $consignation->prix_cgt = ($cageot == 1) ? 0 : ($consignation->prix_cgt - ((int)$request->quantite_cageot * $article->prix_cgt));
            //     $consignation->save();
            // }
            if ($bouteille == 1 && $cageot == 1) {
                $consignation->etat = 'rendu';
                $consignation->etat_cgt = 'rendu';
                $consignation->prix = 0;
                $consignation->prix_cgt = 0;
                $consignation->rendu_btl += $request->total_btl;
                $consignation->rendu_cgt += $request->total_cgt;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentrebtl = $request->total_btl * $article->prix_consignation;
                $totentrecgt = $request->total_cgt * $article->prix_cgt;
                $this->operation('Déconsignation BTL', $request->commande_id, $request->mode_paye, $totentrebtl);
                $this->operation('Déconsignation CGT', $request->commande_id, $request->mode_paye, $totentrecgt);
                if($vente->type_achat == 'cageot' || $vente->type_achat ==  'pack'){
                    $this->ajour($vente_id ,$request->total_cgt);
                }else{  
                    $this->ajour($vente_id ,$request->total_btl);
                }
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 0 && $cageot == 1) {
                $consignation->etat_cgt = 'rendu';
                $consignation->prix_cgt = 0;
                $consignation->rendu_cgt += $request->total_cgt;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentre = $request->total_cgt * $article->prix_cgt;
                $this->operation('cageot', $request->commande_id, $request->mode_paye, $totentre);
                $this->ajour($vente_id ,$request->total_cgt);
                
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 1 && $cageot == 0) {
                //dd('eto');
                $consignation->etat = 'rendu';
                $consignation->prix = 0;
                $consignation->rendu_btl += $request->total_btl;
                $consignation->save();
                $this->verification($request->commande_id);
                $totentre = $request->total_btl * $article->prix_consignation;
                $this->operation('bouteille', $request->commande_id, $request->mode_paye, $totentre);
                $this->ajour($vente_id ,$request->total_btl);
                return redirect()->back()
                    ->with('success', 'Paiement enregistré avec succès.')
                    ->with('highlighted_id', $vente_id);
            }
            if ($bouteille == 0 && $cageot == 0) {
                $prix_bouteille = (int)$request->quantite_buteille;
                $prix_cageot = (int)$request->quantite_cageot;
                //dd($consignation->prix_cgt);

                $actions_effectuees = false;

                if ($consignation->prix > $prix_bouteille) {
                    $consignation->prix -= $prix_bouteille;
                    $consignation->rendu_btl += $request->quantite_buteille;
                    $actions_effectuees = true;
                } elseif ($consignation->prix == $prix_bouteille) {
                    $consignation->prix = 0;
                    $consignation->etat = 'rendu';
                    $consignation->rendu_btl += $request->quantite_buteille;
                    $actions_effectuees = true;
                }
                //dd($request->quantite_cageot);
                if ($consignation->prix_cgt > $prix_cageot) {
                    $consignation->prix_cgt -= $prix_cageot;
                    $consignation->rendu_cgt += $request->quantite_cageot;
                    $actions_effectuees = true;
                } elseif ($consignation->prix_cgt == $prix_cageot && $request->quantite_cageot != null) {
                    $consignation->prix_cgt = 0;
                    $consignation->rendu_cgt += $request->quantite_cageot;
                    $consignation->etat_cgt = $vente->type_achat == 'cageot' ? 'rendu' : 'conditionné';
                    $actions_effectuees = true;
                }

                if ($actions_effectuees) {
                    $consignation->save();
                    $this->operation('cageot_bouteille', $request->commande_id, $request->mode_paye, (($prix_bouteille * $article->prix_consignation) + ($prix_cageot * $article->prix_cgt)));
                    $this->verification($request->commande_id);
                    if($vente->type_achat == 'cageot'){
                        $this->ajour($vente_id ,$request->quantite_cageot);
                    }else{
                        $this->ajour($vente_id ,$request->quantite_buteille);
                    }
                    return redirect()->back()
                        ->with('success', 'Paiement enregistré avec succès.')
                        ->with('highlighted_id', $vente_id);
                }

                // Si aucun cas ne s'est déclenché
                dd([
                    'prix attendu bouteille' => $prix_bouteille,
                    'prix consignation bouteille' => $consignation->prix,
                    'prix attendu cageot' => $prix_cageot,
                    'prix consignation cageot' => $consignation->prix_cgt,
                    'bouteille égalité ?' => $consignation->prix == $prix_bouteille,
                    'cageot égalité ?' => $consignation->prix_cgt == $prix_cageot,
                ]);
            }

            // Vérifier si toutes les ventes liées à la commande ont prix et prix_cgt égaux à 0

        }
    }
}
