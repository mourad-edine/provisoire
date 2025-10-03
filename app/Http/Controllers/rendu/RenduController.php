<?php

namespace App\Http\Controllers\rendu;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleRendu;
use App\Models\Commande;
use App\Models\HistoriqueVente;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenduController extends Controller
{

    public function articlerendu(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->rendu < 0 || $request->casse < 0) {
                return redirect()->back()->with('error', "Les quantités de rendu et de casse doivent être des nombres positifs ou nuls.");
            }
            if ($request->vente_id) {
                $vente = Vente::findOrFail($request->vente_id);

                // ⚠️ correction du test (== au lieu de =)
                if ($vente->type_achat == 'cageot' || $vente->type_achat == 'pack') {
                    $quantite = $vente->article->conditionnement * $vente->quantite;
                    $vente->quantite = $quantite - (($request->rendu ?? 0) + ($request->casse ?? 0));
                    $vente->type_achat = 'bouteille';
                } else {
                    $vente->quantite = $vente->quantite - (($request->rendu ?? 0) + ($request->casse ?? 0));
                }
                if ($vente->quantite <= 0) {
                    $vente->etat = 1;
                }
                $vente->save();
                $article = Article::find($vente->article_id);

                HistoriqueVente::create([
                    'id_article' => $article->id,
                    'id_vente' => null,
                    'quantite_initiale' => $article->quantite,
                    'quantite_enleve' => ($request->rendu ?? 0),
                    'quantite_finale' => $article->quantite + ($request->rendu ?? 0),
                    'type_historique' => 1,
                    'prix' => $article->prix_unitaire ?? 0,
                    'total' => $article->prix_unitaire * ($request->rendu ?? 0),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $article->quantite += ($request->rendu ?? 0);
                $article->save();

                ArticleRendu::create([
                    'id_vente' => $vente->id,
                    'commande_id' => $vente->commande_id,
                    'quantite' => $request->rendu ?? 0,
                    'quantite_casse' => $request->casse ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Rendu enregistré avec succès');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Erreur lors de l'enregistrement : " . $e->getMessage());
        }
    }


    public function articlerenduall(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->has('ventes') && is_array($request->ventes)) {
                foreach ($request->ventes as $venteId => $data) {
                    $vente = Vente::findOrFail($venteId);

                    // Valeurs sécurisées
                    $rendu = (int)($data['rendu'] ?? 0);
                    $casse = (int)($data['casse'] ?? 0);
                    $total_rendu = $rendu + $casse;

                    if ($vente->type_achat == 'cageot' || $vente->type_achat == 'pack') {
                        $quantite = $vente->article->conditionnement * $vente->quantite;
                        $vente->quantite = $quantite - $total_rendu;
                        $vente->type_achat = 'bouteille';
                    } else {
                        $vente->quantite = $vente->quantite - $total_rendu;
                    }

                    if ($vente->quantite <= 0) {
                        $vente->quantite = 0;
                        $vente->etat = 1; // clôturer la vente si plus de quantité
                    }

                    $vente->save();

                    ArticleRendu::create([
                        'id_vente' => $vente->id,
                        'commande_id' => $vente->commande_id,
                        'quantite' => $rendu,
                        'quantite_casse' => $casse,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Rendus enregistrés avec succès');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Erreur lors de l'enregistrement : " . $e->getMessage());
        }
    }

    public function articlerenduhistorique($id)
    {
        $commande = Commande::where('commande_id' , $id)->first($id);
        dd($commande);
        $articlerendus = ArticleRendu::with(['vente'])
            ->where('commande_id', $commande->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('pages.vente.HistoriqueRetour', [
            'commande_id' => $id,
            'commande' => $commande,
            'articlerendus' => $articlerendus,
        ]);
    }
}
