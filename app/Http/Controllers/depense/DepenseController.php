<?php

namespace App\Http\Controllers\depense;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Depense;
use App\Models\Emballage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    public function depenseEmb(){

        $moisActuel = now()->month;
        $anneeActuelle = now()->year;
        $now = now();
        $depensesDuMois = Depense::whereMonth('created_at', $moisActuel)
            ->whereYear('created_at', $anneeActuelle)
            ->get();
        $depensesAujourdhui = Depense::whereDate('created_at', $now->toDateString())->get();
        $bouteillejour = Depense::whereDate('created_at', $now->toDateString())->where('description', 'Bouteille')->sum('quantite');
        $cageotjour = Depense::whereDate('created_at', $now->toDateString())->where('description', 'cageot')->sum('quantite');
        $bouteillemois = Depense::whereMonth('created_at', $moisActuel)->whereYear('created_at', $anneeActuelle)->where('description', 'Bouteille')->sum('quantite');
        $cageotmois = Depense::whereMonth('created_at', $moisActuel)->whereYear('created_at', $anneeActuelle)->where('description', 'cageot')->sum('quantite');
        return view('pages.stock.HistoriqueEmballage' , [
            'depenses' => Depense::where('type_achat' , 1)->orderBy('id', 'desc')->get(),
            'totalmois' => $depensesDuMois->sum('montant'),
            'totalJour' => $depensesAujourdhui->sum('montant'),
            'bouteillejour' => $bouteillejour,
            'cageotjour' => $cageotjour,
            'bouteillemois' => $bouteillemois,
            'cageotmois' => $cageotmois,
        ]);
    }
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'description' => 'nullable|string|max:100',
            'quantite' => 'nullable|integer',
            'montant' => 'required|integer',
            'mode_paye' => 'nullable|string|max:15',
        ]);
        $tableau = [
            'description' => $request->description,
            'quantite' => $request->quantite ?? 1,
            'montant' => $request->montant,
            'mode_paye' => $request->mode_paye ?? 'espèces',
            'type_achat' => 0
        ];

        $depense = Depense::create($tableau);
        if ($depense) {
            return redirect()->back()->with('success', 'Dépense enregistrée avec succès.');
        }
    }


    public function depenseemballage(Request $request)
    {
        $request->validate([
            'items' => 'required|string', // JSON
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Décoder les items envoyés
        $items = json_decode($request->items, true);

        if (!$items || !is_array($items)) {
            return redirect()->back()->with('error', 'Format des articles invalide.');
        }

        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                // ✅ Validation interne de chaque item
                if (!isset($item['type'], $item['id'], $item['quantity'], $item['subtotal'])) {
                    throw new \Exception("Un des éléments est invalide.");
                }

                // ✅ Préparer tableau pour la dépense
                $tableau = [
                    'description' => 'Achat emballage',
                    'quantite'    => $item['quantity'],
                    'montant'     => $item['subtotal'],
                    'mode_paye'   => 'espèces',
                    'type_achat'  => 1// ou $request->mode_paye si dispo
                ];

                // ✅ Mise à jour selon le type
                if ($item['type'] === 'article') {
                    $article = Article::findOrFail($item['id']);
                    $article->vides += $item['quantity'];
                    $article->save();
                }

                if ($item['type'] === 'packaging') {
                    $emballage = Emballage::findOrFail($item['id']);
                    $emballage->quantite += $item['quantity'];
                    $emballage->save();
                }

                Depense::create($tableau);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Dépense(s) emballage enregistrée(s) avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l’enregistrement : ' . $e->getMessage());
        }
    }


    // ✅ Détails d’une dépense
    public function show($id)
    {
        $depense = Depense::findOrFail($id);
        return response()->json($depense);
    }

    // ✅ Supprimer une dépense
    public function destroy($id)
    {
        $depense = Depense::findOrFail($id);
        $depense->delete();

        return redirect()->back()->with('success', 'Dépense supprimé avec succès.');
    }
}
