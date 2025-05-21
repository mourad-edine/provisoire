<?php

namespace App\Http\Controllers\vente;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Conditionnement;
use App\Models\Consignation;
use App\Models\Payement;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VenteController extends Controller
{
    //public $nombre =  10;
    public function show()
    {
        $article = Article::first();
        $cgt = $article->prix_cgt;

        //dd($reste);
        $ventes = Vente::with(['article', 'consignation', 'commande'])
            ->orderBy('id', 'DESC')
            ->paginate(6); // La pagination doit être ici

        // Transformer chaque vente après la pagination
        $ventes->getCollection()->transform(function ($vente) {
            return [
                'id' => $vente->id,
                'etat_client_commande' => $vente->commande ? $vente->commande->etat_client : null,
                'article' => $vente->article ? $vente->article->nom : null,
                'article_id' => $vente->article ? $vente->article->id : null,
                'consi_cgt' => $vente->article ? $vente->article->prix_cgt : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation_id' => $vente->consignation ? $vente->consignation->id : null,
                'casse' => $vente->consignation ? $vente->consignation->casse : null,
                'rendu_btl' => $vente->consignation ? $vente->consignation->rendu_btl : null,
                'rendu_cgt' => $vente->consignation ? $vente->consignation->rendu_cgt : null,
                'casse_cgt' => $vente->consignation ? $vente->consignation->casse_cgt : null,
                'consignation' => $vente->consignation ? $vente->consignation->prix * $vente->article->prix_consignation : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'etat_cgt' => $vente->consignation ? $vente->consignation->etat_cgt : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'prix_cgt' => $vente->consignation ? $vente->consignation->prix_cgt * $vente->article->prix_cgt : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,
                'btl' => $vente->btl,
                'cgt' => $vente->cgt,
                'commande_id' => $vente->commande_id,
                'etat_payement' => $vente->etat,
                'etat_client' => $vente->client
            ];
        });
        //dd($reste);
        //dd($ventes->toArray());
        $conditionnement = Commande::with('conditionnement')->where('id', 7)->first();

        //dd($conditionnement->toArray());
        return view('pages.vente.Liste', [
            'ventes' => $ventes,
            'commande_id' => 7,
            'conditionnement' => $conditionnement,
            'cgt' => $cgt,

        ]);
    }

    public function updatearticle($id, int $types, int $quantite)
    {
        $article = Article::find($id);
        if ($types == 0) {
            if ($article->quantite < ($quantite * (int)$article->conditionnement)) {
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = (int)$article->quantite - ($quantite * (int)$article->conditionnement);
        } else if ($types == 1) {
            if ($article->quantite < $quantite) {
                return redirect()->back()->withErrors('Quantité insuffisante pour cette vente');
            }
            $article->quantite = $article->quantite - $quantite;
        }
        $article->save();
    }

    public function getArticle($id)
    {
        return Article::find($id);
    }

    public function consignation(int $type, int $idvente, int $article, int $quantite, int $cageot, int $bouteille, int $conditionnement)
    {
        $articleObj = $this->getArticle($article);

        if ($type === 0) {  // Type cageot
            // Calcul du prix de consignation
            $prix_consignation = ($bouteille === 0)
                ? $articleObj->prix_consignation * $quantite * ($articleObj->conditionnement ?? 1)
                : 0;

            $prix_consignation_cgt = ($cageot === 0)
                ? $articleObj->prix_cgt * $quantite
                : 0;

            // Détermination de l'état et de l'état_cgt
            if ($articleObj->prix_cgt == 0 && $articleObj->prix_consignation == 0) {
                $etat = 'avec BTL';
                $etat_cgt = 'avec pack';
            } else {
                $etat = ($bouteille == 0) ? 'non rendu' : 'avec BTL';
                $etat_cgt = ($cageot == 0) ? 'non rendu' : 'avec CGT';
            }

            // Création de la consignation
            Consignation::create([
                'vente_id' => $idvente,
                'etat' => $etat,
                'etat_cgt' => $etat_cgt,
                'prix' => $prix_consignation,
                'prix_cgt' => $prix_consignation_cgt,
                'date_consignation' => now(),
                'type_consignation' => false
            ]);
        } elseif ($type === 1) {
            // dd([
            //     $idvente,
            //     $articleObj->prix_consignation,
            //     $conditionnement,
            //     $bouteille
            // ]);
            if ($bouteille == 0) {
                Consignation::create([
                    'vente_id' => $idvente,
                    'etat' => ($articleObj->prix_consignation != 0) ? 'non rendu' : 'non consigné',
                    'etat_cgt' => ($conditionnement == 1 && $articleObj->prix_cgt == 0) ? 'non condit°' : (($conditionnement == 0 && $articleObj->prix_cgt != 0) ? 'Sans CGT' : ($conditionnement == 1 && $articleObj->prix_cgt != 0 ? 'conditionné' : 'BTL jetable')),
                    'prix' => ($articleObj->prix_consignation != 0) ?  $articleObj->prix_consignation * $quantite : 0,
                    'prix_cgt' => 0, // Prix fixe par bouteille
                    'date_consignation' => now(),
                    'type_consignation' => true
                ]);
            } else if ($bouteille == 1) {
                Consignation::create([
                    'vente_id' => $idvente,
                    'etat' => 'non consigné',
                    'etat_cgt' => ($conditionnement == 1 && $articleObj->prix_cgt == 0) ? 'non condit°' : (($conditionnement == 0 && $articleObj->prix_cgt != 0) ? 'non consigé' : ($conditionnement == 1 && $articleObj->prix_cgt != 0 ? 'conditionné' : 'BTL jetable')),
                    'prix' =>  0,
                    'prix_cgt' => 0, // Prix fixe par bouteille
                    'date_consignation' => now(),
                    'type_consignation' => true
                ]);
            }  // Type bouteille
        }
    }





    // public function store(Request $request)
    // {
    //     dd($request->all());



    //     //$test = floatToInt(18,5);
    //     $cgs = Article::first()->prix_cgt;
    //     //dd($request->all());
    //     $data = $request->validate([
    //         'articles' => 'required|array',
    //         'quantites' => 'required|array',
    //         'dateventes' => 'required|array',
    //         'prices' => 'required|array',
    //         'types' => 'required|array',
    //         'consignations' => 'required|array',
    //         'bouteilles' => 'required|array',
    //         'cageots' => 'required|array',
    //     ]);

    //     $commande = Commande::create([
    //         'user_id' => Auth::user()->id,
    //         'client_id' => $request->client_id,
    //         'etat_client' => $request->has('fidele') ? 1 : ($request->has('disposition') ? 2 : 0),
    //         'etat_commande' => $request->has('payer') ? 'payé' : 'non payé'
    //     ]);

    //     $conditionnement = $request->has('choix') ? 1 : 0;
    //     if ($conditionnement == 1) {
    //         Conditionnement::create([
    //             'commande_id' => $commande->id,
    //             'nombre_cageot' => $request->embale ? $request->embale : 0,
    //             'montant' => $request->embale ? $request->embale * $cgs : 0,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //     }

    //     // Boucle pour enregistrer chaque achat
    //     foreach ($data['articles'] as $index => $article) {
    //         $type = (int) $data['types'][$index]; // Convertir en entier pour éviter les erreurs de type
    //         $bouteilles = (int) $data['bouteilles'][$index]; // Convertir en entier pour éviter les erreurs de type
    //         $vente = Vente::create([
    //             'article_id' => $article,
    //             'commande_id' => $commande->id,
    //             'quantite' => $data['quantites'][$index],
    //             'date_sortie' => $data['dateventes'][$index],
    //             'prix' => $data['prices'][$index],
    //             'type_achat' => $type === 0 ? 'cageot' : 'bouteille',
    //             'btl' => $bouteilles,
    //             'cgt' => (int) $data['cageots'][$index],
    //             'etat' => $request->has('payer') ? 1 : 0,
    //             'client' => $request->has('fidele') ? 1 : 0

    //         ]);

    //         $this->updatearticle($article, $type, $data['quantites'][$index]);
    //         $cageot = $data['cageots'][$index];
    //         $bouteille = $data['bouteilles'][$index];
    //         // Correction : Passer $type au lieu de $data['consignations'][$index]
    //         if ($data['consignations'][$index] == '0') {
    //             $this->consignation($type, $vente->id, $article, $data['quantites'][$index], $cageot, $bouteille, $conditionnement);
    //         }
    //     }

    //     return redirect()->route('commande.liste.vente')->with('success', 'Ventes enregistrées avec succès.');
    // }


    public function showcommande(Request $request)
    {
        $search = $request->input('search');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $tri = $request->input('tri', 'desc');

        $article = Article::where('prix_cgt', '>', 0)->first();

        $commandesQuery = Commande::with(['ventes.consignation', 'ventes.article', 'client', 'conditionnement'])
            ->withCount('ventes')
            ->where('disposition', 0)
            ->having('ventes_count', '>', 0);

        if ($search) {
            $commandesQuery->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('client', function ($query) use ($search) {
                        $query->where('nom', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($dateDebut) {
            $commandesQuery->whereDate('created_at', '>=', $dateDebut);
        }

        if ($dateFin) {
            $commandesQuery->whereDate('created_at', '<=', $dateFin);
        }

        $commandesQuery->orderBy('created_at', $tri);

        $commandes = $commandesQuery->paginate(6);

        // Ajout des sommes personnalisées
        $total = 0;
        $commandes->each(function ($commande) {
            $commande->ventes_total = $commande->ventes->sum(function ($vente) {
                $multiplicateur = ($vente->type_achat === 'cageot' || $vente->type_achat == 'pack') ? ($vente->article->conditionnement ?? 1) : 1;
                return $vente->prix * $vente->quantite * $multiplicateur;
            });

            $commande->ventes_consignation_sum_prix = $commande->ventes->sum(fn($vente) => optional($vente->consignation)->prix * $vente->article->prix_consignation ?? 0);
            $commande->ventes_consignation_sum_prix_cgt = $commande->ventes->sum(fn($vente) => optional($vente->consignation)->prix_cgt * $vente->article->prix_cgt ?? 0);
        });
        // foreach($commandes as $commande){
        //     $total += $commande->ventes_total + $commande->ventes_consignation_sum_prix 
        //     + $commande->ventes_consignation_sum_prix_cgt 
        //     + optional($commande->conditionnement)->nombre_cageot * $article->prix_cgt; 
        // }
        // dd($total);
        return view('pages.vente.commande', [
            'commandes' => $commandes,
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first(),
            'cgt' => $article->prix_cgt ?? 0
        ]);
    }




    public function DetailCommande($id)

    {
        $article = Article::first();
        $cgt = $article->prix_cgt;
        $commande = Commande::with('payements')->find($id);
        $reste = $commande->payements()->where('operation', 'partiel')->sum('somme');
        //dd($reste);
        $ventes = Vente::with(['article', 'consignation', 'commande'])
            ->where('commande_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(10); // La pagination doit être ici

        // Transformer chaque vente après la pagination
        $ventes->getCollection()->transform(function ($vente) {
            return [
                'id' => $vente->id,
                'etat_client_commande' => $vente->commande ? $vente->commande->etat_client : null,
                'article' => $vente->article ? $vente->article->nom : null,
                'article_id' => $vente->article ? $vente->article->id : null,
                'consi_cgt' => $vente->article ? $vente->article->prix_cgt : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation_id' => $vente->consignation ? $vente->consignation->id : null,
                'casse' => $vente->consignation ? $vente->consignation->casse : null,
                'rendu_btl' => $vente->consignation ? $vente->consignation->rendu_btl : null,
                'rendu_cgt' => $vente->consignation ? $vente->consignation->rendu_cgt : null,
                'casse_cgt' => $vente->consignation ? $vente->consignation->casse_cgt : null,
                'consignation' => $vente->consignation ? $vente->consignation->prix * $vente->article->prix_consignation : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'etat_cgt' => $vente->consignation ? $vente->consignation->etat_cgt : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'prix_cgt' => $vente->consignation ? $vente->consignation->prix_cgt * $vente->article->prix_cgt : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,
                'btl' => $vente->btl,
                'cgt' => $vente->cgt,
                'commande_id' => $vente->commande_id,
                'etat_payement' => $vente->etat,
                'etat_client' => $vente->client
            ];
        });
        //dd($reste);
        //dd($ventes->toArray());
        $conditionnement = Commande::with('conditionnement')->where('id', $id)->first();

        $exist = Commande::where('commande_id', $id)->exists();
        return view('pages.vente.Detail', [
            'ventes' => $ventes,
            'commande_id' => $id,
            'conditionnement' => $conditionnement,
            'cgt' => $cgt,
            'commande' => $commande,
            'reste' => $reste,
            'exist' => $exist,
        ]);
    }

    public function Vente()
    {
        return view('pages.vente.Vente', [
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
        ]);
    }

    public function regler(Request $request)
    {

        // Validation des données d'entrée
        //dd($request->all());
        //dd($request->all());
        if ($request->has('all')) {
            Payement::create([
                'commande_id' => $request->commande_id,
                'mode_paye' => 'espèce',
                'somme' => $request->montant_tot,
                'operation' => 'partiel'
            ]);
            try {
                $commande = Commande::findOrFail($request->commande_id);
                DB::beginTransaction();
                $commande->update([
                    'etat_commande' => 'payé',
                ]);

                Vente::where('commande_id', $commande->id)
                    ->update(['etat' => 1]);
                DB::commit();
                return redirect()->back()->with('success', 'Le paiement a été enregistré avec succès.');
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'Commande introuvable.');
            } catch (\Exception $e) {
                // Annulation en cas d'erreur
                DB::rollBack();
                Log::error('Erreur lors du paiement : ' . $e->getMessage());
                return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement.');
            }
        }
        $verif = Payement::where('commande_id', $request->commande_id)
            ->where('operation', 'partiel')
            ->get();
        $sommepaye = $verif->sum('somme');
        //dd($request->montant_total > $sommepaye + $request->somme);
        if ($request->montant_total < $sommepaye + $request->somme) {
            return redirect()->back()->with('error', 'Le montant total ne peut pas être inférieur au montant déjà payé.');
        }
        if ($request->montant_total > $sommepaye + $request->somme) {
            Payement::create([
                'commande_id' => $request->commande_id,
                'mode_paye' => 'espèce',
                'somme' => $request->somme,
                'operation' => 'partiel',
            ]);
            return redirect()->back()->with('success', 'Le paiement a été enregistré avec succès.');
        }
        if (($request->montant_total == $sommepaye + $request->somme)) {
            Payement::create([
                'commande_id' => $request->commande_id,
                'mode_paye' => 'espèce',
                'somme' => $request->somme,
                'operation' => 'partiel'
            ]);
            if ($request->totalconsigne == 0) {
                try {
                    $commande = Commande::findOrFail($request->commande_id);
                    DB::beginTransaction();
                    $commande->update([
                        'etat_commande' => 'payé',
                    ]);

                    Vente::where('commande_id', $commande->id)
                        ->update(['etat' => 1]);
                    DB::commit();
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect()->back()->with('error', 'Commande introuvable.');
                } catch (\Exception $e) {
                    // Annulation en cas d'erreur
                    DB::rollBack();
                    Log::error('Erreur lors du paiement : ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement.');
                }
            }
            return redirect()->back()->with('success', 'Le paiement a été enregistré avec succès.');
        }

        // try {
        //     $commande = Commande::findOrFail($request->commande_id);
        //     DB::beginTransaction();
        //     $commande->update([
        //         'etat_commande' => 'payé',
        //     ]);

        //     Vente::where('commande_id', $commande->id)
        //         ->update(['etat' => 1]);
        //     DB::commit();

        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     return redirect()->back()->with('error', 'Commande introuvable.');
        // } catch (\Exception $e) {
        //     // Annulation en cas d'erreur
        //     DB::rollBack();
        //     Log::error('Erreur lors du paiement : ' . $e->getMessage());
        //     return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement.');
        // }

    }

    public function Rendre($id)
    {

        return view('pages.vente.Rendre', [
            'ventes' => Vente::with(['article', 'consignation'])
                ->where('commande_id', $id)
                ->orderBy('id', 'DESC')
                ->paginate(6), // La pagination doit être ici
            'commande_id' => $id,
            'client_id' => Commande::find($id)->client_id,
        ]);
    }
    // public function RendreStore(Request $request)

    // {
    //     dd($request->all());
    //     $commande = Commande::find($request->commande_id);

    //     foreach ($request->article_id as $index => $articleId) {
    //         $vente = Vente::find($index);
    //         $articleObj = Article::find($articleId);
    //         $test = $request->has('check')  ? (isset($request->check[$index]) ? 1 : 0) : 0;
    //         //dd($test);
    //         if ($test == 1) {
    //             if ($vente->quantite > $request->cageots[$index]) {
    //                 $reste = $vente->quantite - $request->cageots[$index];
    //                 $vente->quantite = ($request->cageots[$index] != null) ? $request->cageots[$index] : $request->unite[$index];
    //                 $vente->etat = 0;
    //                 $vente->client = 0;
    //                 $vente->btl = 1;
    //                 $consignation = Consignation::where('vente_id', $vente->id)->first();
    //                 $consignation->prix = 0;
    //                 $consignation->prix_cgt = 0;
    //                 $consignation->etat = 'non consigné';
    //                 $consignation->etat_cgt = 'non consigné';
    //                 $consignation->save();
    //                 $commande = Commande::find($vente->commande_id);
    //                 $commande->etat_client = 0;
    //                 $commande->save();
    //                 $vente->cgt = 1;
    //                 $articleObj->quantite = $vente->type_achat == 'cageot' ? ($articleObj->quantite + $reste) * $articleObj->conditionnement : $articleObj->quantite + $reste;
    //                 $vente->save();
    //                 $articleObj->save();
    //                 if ($request->cageots[$index] != null) {
    //                     if ($request->unite[$index] != null || $request->unite[$index] != 0) {
    //                         $this->nouveau($request->unite[$index], $vente->commande_id, $articleId, $articleObj->prix_unitaire);
    //                     }
    //                 }
    //             } elseif ($vente->quantite == $request->cageots[$index]) {
    //                 $consignation = Consignation::where('vente_id', $vente->id)->first();
    //                 $consignation->prix = 0;
    //                 $consignation->prix_cgt = 0;
    //                 $consignation->etat = 'non consigné';
    //                 $consignation->etat_cgt = 'non consigné';
    //                 $consignation->save();
    //                 $commande = Commande::find($vente->commande_id);
    //                 $commande->etat_client = 0;
    //                 $commande->save();
    //                 $vente->etat = 0;
    //                 $vente->client = 0;
    //                 $vente->btl = 1;
    //                 $vente->cgt = 1;
    //                 $articleObj->quantite = $vente->type_achat == 'cageot' ? ($articleObj->quantite + $vente->quantite) * $articleObj->conditionnement : $articleObj->quantite + $vente->quantite;
    //                 $vente->save();
    //                 $articleObj->save();
    //                 if ($request->cageots[$index] != null) {
    //                     if ($request->unite[$index] != null || $request->unite[$index] != 0) {
    //                         $this->nouveau($request->unite[$index], $vente->commande_id, $articleId, $articleObj->prix_unitaire);
    //                     }
    //                 }
    //             } elseif ($vente->quantite < $request->cageot[$index]) {
    //                 return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement.');
    //             }
    //         } else if ($test == 0) {
    //             $articleObj->quantite = $vente->type_achat == 'cageot' ? ($articleObj->quantite + $vente->quantite) * $articleObj->conditionnement : $articleObj->quantite + $vente->quantite;
    //             $articleObj->save();
    //             $vente->delete();
    //         }
    //     }
    //     return redirect()->route('commande.liste.vente.detail', $commande->id)->with('success', 'Le paiement a été enregistré avec succès.');
    // }


    public function Paiment($id)
    {
        //     dd(Commande::with(['payements', 'client'])
        //     ->where('id', $id)
        //     ->orderBy('id', 'DESC')
        //     ->first()
        // ->toArray());

        return view('pages.vente.Payement', [
            'commande' => Commande::with(['payements', 'client'])
                ->where('id', $id)
                ->orderBy('id', 'DESC')
                ->first(),
            'payements' => Commande::with(['payements', 'client'])
                ->where('id', $id)
                ->orderBy('id', 'DESC')
                ->first()
                ->payements()
                ->orderBy('id', 'DESC')
                ->paginate(6),
            // La pagination doit être ici
        ]);
    }
    public function PaimentAll()
    {
        //sdd(Payement::paginate(6)->toArray());

        return view('pages.vente.Payement', [
            'commande' => Commande::with(['payements', 'client'])
                ->orderBy('id', 'DESC')
                ->paginate(6),
            'payements' => Payement::paginate(6),
            // La pagination doit être ici
        ]);
    }

    public function store(Request $request)
    {
        //
        //dd($request->all());
        if ($request->nouveau) {
            $nouvclient = Client::create([
                'nom' => $request->nouveau,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'client_id' => ($request->client_id != null) ? $request->client_id : $nouvclient->id,
            'etat_client' => $request->has('fidele') ? 1 : ($request->has('disposition') ? 2 : 0),
            'etat_commande' => $request->has('payer') ? 'payé' : 'non payé'
        ]);

        $conditionnement = $request->has('choix') ? 1 : 0;
        $cgs = Article::first()->prix_cgt;

        if ($conditionnement == 1) {
            Conditionnement::create([
                'commande_id' => $commande->id,
                'nombre_cageot' => $request->embale ? $request->embale : 0,
                'montant' => $request->embale ? $request->embale * $cgs : 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        if ($request->articles) {
            foreach ($request->articles as $index) {
                $article = Article::find($index['id']);

                if (!$article) {
                    continue; // Article non trouvé
                }

                // Détection des options cageot/bouteille
                $avecBouteille = isset($index['avec_bouteille']);
                $avecCageot = isset($index['avec_cageot']);

                $bouteille = $avecBouteille ? 0 : 1;
                $cageot = $avecCageot ? 0 : 1;
                //dd(['bouteille' => $bouteille, 'cageot' => $cageot, 'prix_cgt' => $article->prix_cgt]);
                // Vente en cageot

                if (!empty($index['quantite_cageot'])) {
                    $quantiteCageot = (int)$index['quantite_cageot'];

                    $article->quantite -= $quantiteCageot * $article->conditionnement;
                    $article->save();

                    $venteCageot = Vente::create([
                        'article_id' => $index['id'],
                        'commande_id' => $commande->id,
                        'quantite' => $quantiteCageot,
                        'prix' => $index['prix_unitaire'],
                        'type_achat' => ($article->prix_consignation == 0 && $article->prix_cgt == 0) || ($article->prix_consignation > 0 && $article->prix_cgt == 0)? 'pack' : 'cageot',
                        'btl' => $bouteille,
                        'cgt' => $cageot,
                        'etat' => $request->has('payer') ? 1 : 0,
                        'client' => $request->has('fidele') ? 1 : 0,
                        'date_sortie' => now(),
                    ]);

                    // Créer une consignation si cageot non rendu
                    if ($cageot == 0 && $article->prix_cgt != 0) {
                        //dd('tsy mandalo eto');
                        Consignation::create([
                            'vente_id' => $venteCageot->id,
                            'etat' => $bouteille == 0 ? 'non rendu' : 'non consigné',
                            'etat_cgt' => 'non rendu',
                            'prix' => $bouteille == 0
                                ? $quantiteCageot * $article->conditionnement
                                : 0,
                            'prix_cgt' => $quantiteCageot,
                            'date_consignation' => now(),
                            'type_consignation' => false,
                        ]);
                    } else if ($cageot == 1 && $bouteille == 0 && $article->prix_cgt != 0) {
                        Consignation::create([
                            'vente_id' => $venteCageot->id,
                            'etat' => 'non rendu',
                            'etat_cgt' => 'non consigné',
                            'prix' => $quantiteCageot * $article->conditionnement,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => false,
                        ]);
                    }
                    if (($cageot == 1 || $cageot == 0) && $bouteille == 0 && $article->prix_cgt == 0) {
                        //dd((int)$index['quantite_cageot'] * $article->prix_consignation * $article->conditionnement);
                        Consignation::create([
                            'vente_id' => $venteCageot->id,
                            'etat' => ($article->prix_consignation != 0) ? 'non rendu' : 'non consigné',
                            'etat_cgt' => 'non consigné',
                            'prix' => ($article->prix_consignation != 0) ? (int)$index['quantite_cageot'] * $article->conditionnement : 0,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => false,
                        ]);
                    }
                }

                // Vente à l’unité
                if (!empty($index['quantite_unite'])) {
                    $quantiteUnite = (int)$index['quantite_unite'];
                    $article->quantite -= $quantiteUnite;
                    $article->save();

                    $venteUnite = Vente::create([
                        'article_id' => $index['id'],
                        'commande_id' => $commande->id,
                        'quantite' => $quantiteUnite,
                        'prix' => $index['prix_unitaire'],
                        'type_achat' => 'bouteille',
                        'btl' => $bouteille,
                        'cgt' => $cageot,
                        'etat' => $request->has('payer') ? 1 : 0,
                        'client' => $request->has('fidele') ? 1 : 0,
                        'date_sortie' => now(),
                    ]);

                    if ($bouteille == 0 && $article->prix_consignation != 0) {
                        Consignation::create([
                            'vente_id' => $venteUnite->id,
                            'etat' => 'non rendu',
                            'etat_cgt' => $conditionnement == 1 ? 'conditionné' : 'sans CGT',
                            'prix' => $quantiteUnite,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                    }
                }
            }
        }
        if ($request->has('payer')) {
            Payement::create([
                'commande_id' => $commande->id,
                'mode_paye' => 'espèce',
                'somme' => $request->tot_glob,
                'operation' => 'partiel',
            ]);
        }
        return redirect()->route('commande.liste.vente.detail' , $commande->id)->with('success', 'Ventes enregistrées avec succès.');
    }

    public function RendreStore(Request $request)
    {
        // Création d'une nouvelle commande
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id ?? null,
            'etat_client' => 0,
            'etat_commande' => 'non payé',
            'commande_id' => $request->commande_id,
            'disposition' => 1,
        ]);

        foreach ($request->article_id as $index => $articleId) {
            $vente = Vente::find($index);
            $article = Article::find($articleId);

            $isChecked = $request->has('check') && isset($request->check[$index]);
            $cageots = $request->cageots[$index] ?? 0;
            $unite = $request->unite[$index] ?? 0;

            $quantiteVenteBouteille = ($vente->type_achat == 'cageot' || $vente->type_achat == 'pack')
                ? $vente->quantite * $article->conditionnement
                : $vente->quantite;

            $totalRendu = ($cageots * $article->conditionnement) + $unite;

            if ($isChecked && $vente->consignation) {
                if ($totalRendu > 0 && $totalRendu <= $quantiteVenteBouteille) {

                    // Nouvelle vente pour les cageots rendus
                    if ($cageots > 0) {
                        $venteCageot = Vente::create([
                            'article_id' => $article->id,
                            'commande_id' => $vente->commande_id,
                            'quantite' => $cageots,
                            'prix' => $article->prix_unitaire,
                            'type_achat' => ($article->prix_consignation == 0 && $article->prix_cgt == 0 ) || ($article->prix_consignation > 0 && $article->prix_cgt == 0 )? 'pack' : 'cageot',
                            'btl' => $article->prix_consignation > 0 ? 0 : 1,
                            'cgt' => $article->prix_consignation > 0 ? 0 : 1,
                            'etat' => 0,
                            'client' => 0,
                            'date_sortie' => now(),
                        ]);

                        Consignation::create([
                            'vente_id' => $venteCageot->id,
                            'etat' => $article->prix_consignation > 0 ? 'non rendu' : 'non consigné',
                            'etat_cgt' => $article->prix_consignation > 0 ? 'non rendu' : 'non consigné',
                            'prix' => $cageots * $article->conditionnement,
                            'prix_cgt' => $article->prix_cgt > 0 ? $cageots : 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                    }

                    // Nouvelle vente pour les bouteilles rendues
                    if ($unite > 0) {
                        $venteUnite = Vente::create([
                            'article_id' => $article->id,
                            'commande_id' => $vente->commande_id,
                            'quantite' => $unite,
                            'prix' => $article->prix_unitaire,
                            'type_achat' => 'bouteille',
                            'btl' => 1,
                            'cgt' => 1,
                            'etat' => 0,
                            'client' => 0,
                            'date_sortie' => now(),
                        ]);

                        Consignation::create([
                            'vente_id' => $venteUnite->id,
                            'etat' => $article->prix_consignation > 0 ? 'non rendu' : 'rendu',
                            'etat_cgt' => 'non consigné',
                            'prix' => $unite,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                    }

                    // Calcul du reste
                    $resteBouteilles = $quantiteVenteBouteille - $totalRendu;
                    $resteCageots = intdiv($resteBouteilles, $article->conditionnement);
                    $resteUnites = $resteBouteilles % $article->conditionnement;

                    // Création d'une nouvelle vente pour les cageots restants
                    if ($resteCageots > 0) {
                        $venteCageotRestant = Vente::create([
                            'article_id' => $article->id,
                            'commande_id' => $commande->id,
                            'quantite' => $resteCageots,
                            'prix' => $article->prix_unitaire,
                            'type_achat' => ($article->prix_consignation == 0 && $article->prix_cgt == 0 ) || ($article->prix_consignation > 0 && $article->prix_cgt == 0 )? 'pack' : 'cageot',
                            'btl' => $article->prix_consignation > 0 ? 0 : 1,
                            'cgt' => $article->prix_consignation > 0 ? 0 : 1,
                            'etat' => 0,
                            'client' => 0,
                            'date_sortie' => now(),
                        ]);

                        Consignation::create([
                            'vente_id' => $venteCageotRestant->id,
                            'etat' => $article->prix_consignation > 0 ? 'non rendu' : 'non consigné',
                            'etat_cgt' => $article->prix_consignation > 0 ? 'non rendu' : 'non consigné',
                            'prix' => $resteCageots * $article->conditionnement,
                            'prix_cgt' => $article->prix_cgt > 0 ? $resteCageots : 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                    }

                    // Création d'une nouvelle vente pour les unités restantes
                    if ($resteUnites > 0) {
                        $venteUniteRestante = Vente::create([
                            'article_id' => $article->id,
                            'commande_id' => $commande->id,
                            'quantite' => $resteUnites,
                            'prix' => $article->prix_unitaire,
                            'type_achat' => 'bouteille',
                            'btl' => 1,
                            'cgt' => 1,
                            'etat' => 0,
                            'client' => 0,
                            'date_sortie' => now(),
                        ]);

                        Consignation::create([
                            'vente_id' => $venteUniteRestante->id,
                            'etat' => $article->prix_consignation > 0 ? 'non rendu' : 'rendu',
                            'etat_cgt' => 'non consigné',
                            'prix' => $resteUnites,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                    }

                    // Mise à jour du stock
                    $article->quantite += $resteBouteilles;
                    $article->save();

                    // Mise à jour de la consignation d'origine
                    $consignation = Consignation::where('vente_id', $vente->id)->first();
                    if ($consignation) {
                        $consignation->update([
                            'prix' => $resteBouteilles,
                            'prix_cgt' => $resteCageots,
                            'etat' => $article->prix_consignation > 0 ? 'non rendu' : 'rendu',
                            'etat_cgt' => $article->prix_consignation > 0 ? 'non rendu' : 'rendu',
                        ]);
                    }

                    // Suppression de l'ancienne vente
                    $vente->delete();
                }
            } elseif ($isChecked && !$vente->consignation) {
                // SANS CONSIGNATION
                $quantiteRendue = $cageots > 0 ? $cageots : $unite;
                $quantiteOriginale = $vente->quantite;
                $reste = $quantiteOriginale - $quantiteRendue;

                if ($quantiteRendue > 0) {
                    // Mise à jour de la vente existante avec la quantité rendue
                    $vente->update([
                        'quantite' => $quantiteRendue,
                        'etat' => 0,
                        'client' => 0,
                        'btl' => 1,
                        'cgt' => 1,
                    ]);
                    $cons = Consignation::where('vente_id', $vente->id)->first();
                    if ($cons) {
                        $cons->update([
                            'etat' => 'non consigné',
                            'etat_cgt' => 'non consigné',
                            'prix' => $quantiteRendue,
                            'prix_cgt' => 0,
                        ]);
                    } else
                        Consignation::create([
                            'vente_id' => $vente->id,
                            'etat' => 'non consigné',
                            'etat_cgt' => 'non consigné',
                            'prix' => 0,
                            'prix_cgt' => 0,
                            'date_consignation' => now(),
                            'type_consignation' => true,
                        ]);
                }

                // Création d'une nouvelle vente pour le reste non rendu
                if ($reste > 0 && $reste < $quantiteOriginale) {
                    $new = Vente::create([
                        'article_id' => $article->id,
                        'commande_id' => $commande->id,
                        'quantite' => $reste,
                        'prix' => $article->prix_unitaire,
                        'type_achat' => $vente->type_achat,
                        'btl' => $vente->btl,
                        'cgt' => $vente->cgt,
                        'etat' => 0,
                        'client' => 0,
                        'date_sortie' => now(),
                    ]);
                    Consignation::create([
                        'vente_id' => $new->id,
                        'etat' => 'non consigné',
                        'etat_cgt' => 'non consigné',
                        'prix' => 0,
                        'prix_cgt' => 0,
                        'date_consignation' => now(),
                        'type_consignation' => true,
                    ]);
                }

                // Remise dans le stock seulement la partie rendue
                $article->quantite += $quantiteRendue;
                $article->save();
            } else {
                // Si la case n’est pas cochée, rattacher la vente à la nouvelle commande
                $vente->commande_id = $commande->id;
                $vente->save();
            }
        }

        // Marquer l’ancienne commande comme traitée
        $oldCommande = Commande::find($request->commande_id);
        $oldCommande->etat_client = 0;
        $oldCommande->save();

        return redirect()->route('commande.liste.vente.detail', $oldCommande->id)
            ->with('success', 'Le paiement a été enregistré avec succès.');
    }





    public function rendu($id)
    {
        $article = Article::first();
        $cgt = $article->prix_cgt;
        $commande = Commande::where('commande_id', $id)->with('payements')->first();
        //sdd($commande);

        $reste = $commande->payements()->where('operation', 'partiel')->sum('somme');
        $ventes = Vente::with(['article', 'consignation', 'commande'])
            ->where('commande_id', $commande->id)
            ->orderBy('id', 'DESC')
            ->paginate(10); // La pagination doit être ici

        // Transformer chaque vente après la pagination
        $ventes->getCollection()->transform(function ($vente) {
            return [
                'id' => $vente->id,
                'etat_client_commande' => $vente->commande ? $vente->commande->etat_client : null,
                'article' => $vente->article ? $vente->article->nom : null,
                'article_id' => $vente->article ? $vente->article->id : null,
                'consi_cgt' => $vente->article ? $vente->article->prix_cgt : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation_id' => $vente->consignation ? $vente->consignation->id : null,
                'casse' => $vente->consignation ? $vente->consignation->casse : null,
                'rendu_btl' => $vente->consignation ? $vente->consignation->rendu_btl : null,
                'rendu_cgt' => $vente->consignation ? $vente->consignation->rendu_cgt : null,
                'casse_cgt' => $vente->consignation ? $vente->consignation->casse_cgt : null,
                'consignation' => $vente->consignation ? $vente->consignation->prix * $vente->article->prix_consignation : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'etat_cgt' => $vente->consignation ? $vente->consignation->etat_cgt : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'prix_cgt' => $vente->consignation ? $vente->consignation->prix_cgt * $vente->article->prix_cgt : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,
                'btl' => $vente->btl,
                'cgt' => $vente->cgt,
                'commande_id' => $vente->commande_id,
                'etat_payement' => $vente->etat,
                'etat_client' => $vente->client
            ];
        });
        //dd($reste);
        //dd($ventes->toArray());
        $conditionnement = Commande::with('conditionnement')->where('id', $id)->first();

        //dd($conditionnement->toArray());
        return view('pages.vente.Rendu', [
            'ventes' => $ventes,
            'commande_id' => $id,
            'conditionnement' => $conditionnement,
            'cgt' => $cgt,
            'commande' => $commande,
            'reste' => $reste,
        ]);
    }
}
