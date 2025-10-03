<?php

namespace App\Http\Controllers\entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntrepriseController extends Controller
{
    public function magasinUpdate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'nif' => 'nullable|string|max:255',   // corrigé : nif/stat ne sont pas des URL
            'stat' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // sécurité upload
        ]);

        try {
            DB::transaction(function () use ($request) {
                $entreprise = Entreprise::find(1);

                // Cas création si aucune entreprise n'existe
                if (!$entreprise) {
                    $entreprise = new Entreprise();
                }

                // Upload du logo si présent

                // Mise à jour des champs
                $entreprise->nom = $request->nom;
                $entreprise->adresse = $request->adresse;
                $entreprise->numero = $request->numero;
                $entreprise->email = $request->email;
                $entreprise->nif = $request->nif;
                $entreprise->stat = $request->stat;

                $entreprise->save();
            });

            return redirect()->back()->with('success', 'Les informations du magasin ont été mises à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function uploadlogo(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Vérifier si une entreprise existe déjà
                $entreprise = Entreprise::find(1);
                //dd($entreprise);
                if (!$entreprise) {
                    // Création si elle n’existe pas
                    $entreprise = new Entreprise();
                    $entreprise->id = 1; // si tu veux forcer l'id à 1
                }

                // Upload du logo
                $imageName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('images'), $imageName);

                // Mise à jour du champ logo
                $entreprise->logo = $imageName;
                $entreprise->save();
            });

            return redirect()->back()->with('success', 'Logo mis à jour avec succès ✅');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du logo : ' . $e->getMessage());
        }
    }
}
