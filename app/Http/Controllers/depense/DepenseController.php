<?php

namespace App\Http\Controllers\depense;

use App\Http\Controllers\Controller;
use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'categorie' => 'nullable|string|max:30',
            'description' => 'nullable|string|max:100',
            'montant' => 'required|integer',
            'mode_paye' => 'nullable|string|max:15',
        ]);

        $depense = Depense::create($request->all());
        if($depense){
            return redirect()->back()->with('success', 'Dépense enregistrée avec succès.');
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
