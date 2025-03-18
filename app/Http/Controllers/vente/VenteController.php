<?php

namespace App\Http\Controllers\vente;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Conditionnement;
use App\Models\Consignation;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    //public $nombre =  10;
    public function show()
    {
        $ventes = Vente::with(['article', 'consignation'])
            ->orderBy('id', 'DESC')
            ->paginate(6); // La pagination doit être ici

        // Transformer chaque vente après la pagination
        $ventes->getCollection()->transform(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation_id' => $vente->consignation ? $vente->consignation->id : null,
                'consignation' => $vente->consignation ? $vente->consignation->prix : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'etat_cgt' => $vente->consignation ? $vente->consignation->etat_cgt : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'prix_cgt' => $vente->consignation ? $vente->consignation->prix_cgt : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,
                'btl' => $vente->btl,
                'cgt' => $vente->cgt,
                'commande_id' => $vente->commande_id
            ];
        });

        return view('pages.vente.Liste', [
            'ventes' => $ventes,
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
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
        //dd($prix_cons);
        if ($type === 0) {  // Type cageot
            //sans bouteille
            $prix_consignation = ($bouteille === 0)
                ? $articleObj->prix_consignation * $quantite * ($articleObj->conditionnement ?? 1)
                : 0;
            //sans cageot donc on consigne les 2 parceque cageot = 0 et bouteille = 0 mais on devrait mettre aussi une conditon si cageot = 0 et bouteille = 1 ou cageot = 1 et bouteille = 0    
            $prix_consignation_cgt = ($cageot === 0)
                ? $articleObj->prix_cgt * $quantite
                : 0;
            // dd([
            //     'prix_consignation_boutelle' => $prix_consignation,
            //     'prix_consignation_cgt' => $prix_consignation_cgt
            // ]);
            //eto 
            //dd($prix_consignation_cgt);    
            Consignation::create([
                'vente_id' => $idvente,
                'etat' => $bouteille == 0 ? 'non rendu' : 'avec BTL',
                'etat_cgt' => $cageot == 0 ? 'non rendu' : 'avec CGT',
                'prix' => $prix_consignation,
                'prix_cgt' => $prix_consignation_cgt,
                'date_consignation' => now(),
                'type_consignation' => false
            ]);
        } elseif ($type === 1) {
            //dd($articleObj->prix_consignation * $quantite);
            if ($bouteille == 0) {
                Consignation::create([
                    'vente_id' => $idvente,
                    'etat' => 'non rendu',
                    'etat_cgt' => $conditionnement == 1 ? 'conditionné' : 'non condit°',
                    'prix' => $articleObj->prix_consignation * $quantite,
                    'prix_cgt' => 0, // Prix fixe par bouteille
                    'date_consignation' => now(),
                    'type_consignation' => true
                ]);
            }  // Type bouteille
        }
    }
    




    public function store(Request $request)
    {



        //$test = floatToInt(18,5);

        //dd($request->all());
        $data = $request->validate([
            'articles' => 'required|array',
            'quantites' => 'required|array',
            'dateventes' => 'required|array',
            'prices' => 'required|array',
            'types' => 'required|array',
            'consignations' => 'required|array',
            'bouteilles' => 'required|array',
            'cageots' => 'required|array',
        ]);

        $commande = Commande::create([
            'user_id' => Auth::user()->id,
            'client_id' => $request->client_id
        ]);
        $conditionnement = $request->has('unites') ? 1 : 0;
        if ($conditionnement == 1) {
            Conditionnement::create([
                'commande_id' => $commande->id,
                'nombre_cageot' => $request->embale ?? $request->quantite_embale,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Boucle pour enregistrer chaque achat
        foreach ($data['articles'] as $index => $article) {
            $type = (int) $data['types'][$index]; // Convertir en entier pour éviter les erreurs de type
            $bouteilles = (int) $data['bouteilles'][$index]; // Convertir en entier pour éviter les erreurs de type
            $vente = Vente::create([
                'article_id' => $article,
                'commande_id' => $commande->id,
                'quantite' => $data['quantites'][$index],
                'date_sortie' => $data['dateventes'][$index],
                'prix' => $data['prices'][$index],
                'type_achat' => $type === 0 ? 'cageot' : 'bouteille',
                'btl' => $bouteilles,
                'cgt' => (int) $data['cageots'][$index],

            ]);

            $this->updatearticle($article, $type, $data['quantites'][$index]);
            $cageot = $data['cageots'][$index];
            $bouteille = $data['bouteilles'][$index];
            // Correction : Passer $type au lieu de $data['consignations'][$index]
            if ($data['consignations'][$index] == '0') {
                $this->consignation($type, $vente->id, $article, $data['quantites'][$index], $cageot, $bouteille, $conditionnement);
            }
        }

        return redirect()->route('vente.liste')->with('success', 'Ventes enregistrées avec succès.');
    }


    public function showcommande()
    {
        //dd(Commande::withcount('ventes')->get()->toArray());
        return view('pages.vente.commande', [
            'commandes' => Commande::withCount('ventes')
                ->having('ventes_count', '>', 0)
                ->orderBy('id', 'DESC')
                ->paginate(6),
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first()
        ]);
    }

    public function DetailCommande($id)
    
    {
        $ventes = Vente::with(['article', 'consignation'])
            ->where('commande_id',$id)
            ->orderBy('id', 'DESC')
            ->paginate(4); // La pagination doit être ici

        // Transformer chaque vente après la pagination
        $ventes->getCollection()->transform(function ($vente) {
            return [
                'id' => $vente->id,
                'article' => $vente->article ? $vente->article->nom : null,
                'prix_unitaire' => $vente->article ? $vente->article->prix_unitaire : null,
                'reference' => $vente->article ? $vente->article->reference : null,
                'numero_commande' => $vente->commande_id,
                'consignation_id' => $vente->consignation ? $vente->consignation->id : null,
                'consignation' => $vente->consignation ? $vente->consignation->prix : null,
                'etat' => $vente->consignation ? $vente->consignation->etat : null,
                'etat_cgt' => $vente->consignation ? $vente->consignation->etat_cgt : null,
                'quantite' => $vente->quantite,
                'type_achat' => $vente->type_achat,
                'created_at' => Carbon::parse($vente->created_at)->format('d/m/Y H:i:s'),
                'prix_consignation' => $vente->article ? $vente->article->prix_consignation : null,
                'prix_cgt' => $vente->consignation ? $vente->consignation->prix_cgt : null,
                'conditionnement' => $vente->article ? $vente->article->conditionnement : null,
                'btl' => $vente->btl,
                'cgt' => $vente->cgt,
                'commande_id' => $vente->commande_id
            ];
        });
        
        $conditionnement = Commande::with('conditionnement')->where('id', $id)->first();

        //dd($conditionnement->toArray());
        return view('pages.vente.Detail', [
            'ventes' => $ventes,
            'commande_id' => $id,
            'conditionnement' => $conditionnement
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
}
