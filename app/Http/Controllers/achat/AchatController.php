<?php

namespace App\Http\Controllers\achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Consignation;
use App\Models\ConsignationAchat;
use App\Models\Depense;
use App\Models\Fournisseur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchatController extends Controller
{
    public function show()
    {
        //dd(Auth::user()->id);
        $achats = Achat::with('articles', 'consignation_achat')
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $achats->getCollection()->transform(function ($achat) {
            return [
                'id' => $achat->id,
                'type_achat' => $achat->type_achat,
                'prix_unite'=> $achat->prix_unite,
                'prix_achat' => $achat->articles ? $achat->articles->prix_achat : null,
                'prix' => $achat->prix,
                'conditionnement' => $achat->articles ? $achat->articles->conditionnement : null,
                'consignation_id' => $achat->consignation_achat ? $achat->consignation_achat->id : null,
                'article' => $achat->articles ? $achat->articles->nom : null,
                'numero_commande' => $achat->commande_id,
                'etat' => $achat->consignation_achat ? $achat->consignation_achat->etat : null,
                'etat_cgt' => $achat->consignation_achat ? $achat->consignation_achat->etat_cgt : null,
                'prix_cgt' => $achat->consignation_achat ? $achat->consignation_achat->prix_cgt : null,
                'quantite' => $achat->quantite,
                'created_at' => Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
                'etat_payement' => $achat->etat,
            ];
        });

        return view('pages.achat.Liste', [
            'achats' => $achats,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'nullable|array',
            'quantitesunite' => 'nullable|array',
            'prices' => 'required|array',
            'totals' => 'required|array',
        ]);
    
        $commande = Commande::create([
            'user_id' => Auth::id(),
            'fournisseur_id' => $request->fournisseur_id,
            'numero' => $request->numero,
        ]);
    
        foreach ($data['articles'] as $index => $articleId) {
            $article = Article::find($articleId);
    
            // Achat par cageot
            $quantiteCageot = $data['quantites'][$index] ?? 0;
            if ($quantiteCageot > 0) {
                Achat::create([
                    'article_id' => $articleId,
                    'commande_id' => $commande->id,
                    'quantite' => $quantiteCageot,
                    'date_entre' => $request->dateachat,
                    'prix_unite' => $data['prices'][$index],
                    'prix' => $data['totals'][$index],
                    'type_achat' => ($article->prix_consignation == 0 && $article->prix_cgt == 0) ||  ($article->prix_consignation > 0 && $article->prix_cgt == 0) ? 'pack' : 'cageot',
                    'fournisseur_id' => $request->fournisseur_id,
                ]);
                $article->prix_achat = $data['prices'][$index];
                $article->quantite += $quantiteCageot * (int) $article->conditionnement;
                $article->prix_conditionne = $data['prices'][$index] * $article->conditionnement;
                $article->save();
            }
    
            // Achat par unité
            $quantiteUnite = $data['quantitesunite'][$index] ?? 0;
            if ($quantiteUnite > 0) {
                Achat::create([
                    'article_id' => $articleId,
                    'commande_id' => $commande->id,
                    'quantite' => $quantiteUnite,
                    'date_entre' => $request->dateachat,
                    'prix' => $data['totals'][$index],
                    'prix_unite' =>  $data['totals'][$index] / $quantiteUnite,
                    'type_achat' => 'bouteilles',
                    'fournisseur_id' => $request->fournisseur_id,
                ]);
    
                $article->quantite += $quantiteUnite;
                $article->prix_achat = $data['totals'][$index] / $quantiteUnite;
                $article->prix_conditionne = $article->conditionnement * ($data['totals'][$index] / $quantiteUnite);
                $article->save();
            }
    
            // Gestion de la consignation si besoin (à réactiver plus tard)
            // if ($data['consignations'][$index] ?? false) {
            //     $this->consignation($achat->id, $quantiteCageot, $articleId, $data['bouteilles'][$index], $data['cageots'][$index]);
            // }
        }
    
        return redirect()->route('achat.commande')->with('success', 'Achats enregistrés avec succès.');
    }
    


    public function consignation(int $achat_id, int $quantite, int $article_id, int $bouteille, int $cageot)
    {

        $article = Article::find($article_id);

        if ($article) { //cageot
            $totalcageot  = ($cageot == 0) ? $quantite * $article->prix_cgt : 0;
            $totalbouteille = ($bouteille == 0) ?  $quantite * $article->prix_consignation * $article->conditionnement  : 0;
            // dd([
            //     'bouteille' => $totalbouteille,
            //     'cageots'=> $totalcageot
            // ]);
            ConsignationAchat::create([
                'achat_id' => $achat_id,
                'prix' => $totalbouteille,
                'prix_cgt' => $totalcageot,
                'etat' => ($bouteille == 0) ? 'non rendu' : 'non consigné',
                'etat_cgt' => ($totalcageot == 0) ? 'non consigné' : 'non rendu',
                'date_consignation' => Carbon::now(),
            ]);
        }
    }

    public function commande(Request $request)
    {
        $search = $request->input('search');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $tri = $request->input('tri', 'desc');

        $commandeQuery = Commande::withCount('achats')
            ->withSum('achats', 'prix')
            ->having('achats_count', '>', 0);

        if ($search) {
            $commandeQuery
                ->where(function ($q) use ($search) {
                    $q->where('id', $search)
                        ->orWhereHas('fournisseur', function ($query) use ($search) {
                            $query->where('nom', 'like', '%' . $search . '%');
                        });
                });
        }

        if ($dateDebut) {
            $commandeQuery->whereDate('created_at', '>=', $dateDebut);
        }

        if ($dateFin) {
            $commandeQuery->whereDate('created_at', '<=', $dateFin);
        }

        $commandeQuery->orderBy('created_at', $tri);

        $commande = $commandeQuery->paginate(6);

        return view('pages.achat.commande', [
            'commandes' => $commande,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }


    public function detailcommande($id)
    {
        $achats = Achat::with('articles', 'consignation_achat')
            ->where('commande_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $total = Achat::where('commande_id', $id)->sum('prix');

        $achats->getCollection()->transform(function ($achat) {
            return [
                'id' => $achat->id,
                'type_achat' => $achat->type_achat,
                'prix_unite'=> $achat->prix_unite,
                'prix_achat' => $achat->articles ? $achat->articles->prix_achat : null,
                'prix' => $achat->prix,
                'article' => $achat->articles ? $achat->articles->nom : null,
                'conditionnement' => $achat->articles ? $achat->articles->conditionnement : null,
                'numero_commande' => $achat->commande_id,
                'consignation_id' => $achat->consignation_achat ? $achat->consignation_achat->id : null,
                'etat' => $achat->consignation_achat ? $achat->consignation_achat->etat : null,
                'etat_cgt' => $achat->consignation_achat ? $achat->consignation_achat->etat_cgt : null,
                'prix_cgt' => $achat->consignation_achat ? $achat->consignation_achat->prix_cgt : null,
                'quantite' => $achat->quantite,
                'created_at' => Carbon::parse($achat->created_at)->format('d/m/Y H:i:s'),
            ];
        });

        return view('pages.achat.Detail', [
            'achats' => $achats,
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
            'id' => $id,
            'total' => $total,
            'commande' => Commande::with('fournisseur')->find($id)
        ]);
    }

    public function showachat()
    {
        return view('pages.achat.Achat', [
            'articles' => Article::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }

    public function depense(){

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
        return view('pages.achat.Depense' , [
            'depense' => Depense::orderBy('id', 'desc')->get(),
            'totalmois' => $depensesDuMois->sum('montant'),
            'totalJour' => $depensesAujourdhui->sum('montant'),
            'bouteillejour' => $bouteillejour,
            'cageotjour' => $cageotjour,
            'bouteillemois' => $bouteillemois,
            'cageotmois' => $cageotmois,
        ]);
    }
}
