<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function show(Request $request)
    {
        $article = Article::where('prix_cgt', '>', 0)->first();
        $search = $request->input('search');

        $query = Client::with([
            'commandes.ventes.consignation',
            'commandes.ventes.article',
            'commandes.conditionnement',
            'commandes.payements',
        ])->withCount('commandes');

        if ($search) {
            $query->where('nom', 'like', "%{$search}%");
        }

        $clients = $query->orderBy('id', 'DESC')->paginate(6);

        $clients->each(function ($client) {
            // Total des commandes (toutes)
            $client->commandes_total = $client->commandes->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    $multiplicateur = ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                        ? ($vente->article->conditionnement ?? 1)
                        : 1;
                    return $vente->prix * $vente->quantite * $multiplicateur;
                });
            });

            // Total des commandes NON PAYÉES
            $client->commandes_total_non_paye = $client->commandes->where('etat_commande', 'non payé')->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    $multiplicateur = ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                        ? ($vente->article->conditionnement ?? 1)
                        : 1;
                    return $vente->prix * $vente->quantite * $multiplicateur;
                });
            });
            $client->nombre_com_no_paye = $client->commandes->where('etat_commande', 'non payé')->where('disposition', 0)->count();


            // Total des paiements partiels effectués
            $payementFait = 0;

            foreach ($client->commandes->where('etat_commande', 'non payé') as $commande) {
                $payementFait += $commande->payements->where('operation', 'partiel')->sum('somme');
            }

            $client->payement_fait = $payementFait;

            // Calcul du reste à payer (commandes non payées - paiements effectués)
            $client->reste_a_payer = $client->commandes_total_non_paye - $client->payement_fait;

            // Consignation - prix
            $client->consignation_sum_prix = $client->commandes->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    return (optional($vente->consignation)->prix ?? 0) * ($vente->article->prix_consignation ?? 0);
                });
            });
            $client->sum_btl = $client->commandes->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    return (optional($vente->consignation)->prix ?? 0);
                });
            });
            $client->sum_cgt = $client->commandes->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    return (optional($vente->consignation)->prix_cgt ?? 0);
                });
            });

            // Consignation - prix_cgt
            $client->consignation_sum_prix_cgt = $client->commandes->sum(function ($commande) {
                return $commande->ventes->sum(function ($vente) {
                    return (optional($vente->consignation)->prix_cgt ?? 0) * ($vente->article->prix_cgt ?? 0);
                });
            });
        });

        // Transformer les données pour la vue
        $clients->getCollection()->transform(function ($client) {
            return [
                'id' => $client->id,
                'nom' => $client->nom,
                'sum_btl' => $client->sum_btl,
                'sum_cgt' => $client->sum_cgt,
                'numero' => $client->numero,
                'reference' => $client->reference,
                'cageot' => $client->nombre_cgt ?? 0,
                'nombre_com_no_paye' => $client->nombre_com_no_paye,
                'bouteille' => $client->nombre_bouteille ?? 0,
                'commandes_count' => $client->commandes_count,
                'commandes_total' => $client->commandes_total,
                'created_at' => $client->created_at ? $client->created_at->format('d/m/Y H:i:s') : null,
                'payement_fait' => $client->payement_fait,
                'commandes_total_non_paye' => $client->commandes_total_non_paye,
                'reste_a_payer' => $client->nombre_com_no_paye > 0 ?  $client->reste_a_payer + $client->consignation_sum_prix + $client->consignation_sum_prix_cgt + ($article->prix_cgt ?? 0) : 0,
                'consignation_sum_prix' => $client->consignation_sum_prix,
                'consignation_sum_prix_cgt' => $client->consignation_sum_prix_cgt,
                'conditionnement' => $client->commandes->sum(function ($commande) {
                    return $commande->conditionnement->nombre_cageot ?? 0;
                }),
            ];
        });

        //dd($clients); // à commenter une fois vérifié

        return view('pages.clients.Liste', [
            'clients' => $clients,
            'cgt' => $article->prix_cgt ?? 0,
        ]);
    }



    public function store(Request $request)
    {
        if ($request) {
            $tab = [
                'nom' => $request->nom,
                'numero' => $request->numero,
                'reference' => $request->reference ? $request->reference : null,
            ];

            $insert = Client::create($tab);
            if ($insert) {
                return redirect()->route('client.liste')->withSuccess('Success', 'success');
            }
        }
    }

    public function performance()
    {
        return view('pages.clients.Performance');
    }

    public function delete($id)
    {
        //dd($id);
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return redirect()->back()->withSuccess('Success', 'client supprimé avec success success');
        }
    }

    public function showCommande(Request $request, $id)
    {
        $article = Article::where('prix_cgt', '>', 0)->first();

        $query = Commande::with(['ventes.consignation', 'ventes.article', 'client', 'conditionnement'])
            ->where('client_id', $id)
            ->where('disposition', 0)
            ->withCount('ventes');

        // Recherche par nom ou numéro de commande
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('nom', 'like', "%$search%");
                    });
            })
                ->where('id', 'like', "%$search%");
        }

        // Filtrer par date
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->input('date_debut'));
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->input('date_fin'));
        }

        // Tri par date
        $tri = $request->input('tri', 'desc');
        $query->having('ventes_count', '>', 0)->orderBy('created_at', $tri);

        // Pagination
        $commandes = $query->paginate(6)->withQueryString();

        // Calcule les totaux
        $commandes->each(function ($commande) {
            $commande->ventes_total = $commande->ventes->sum(function ($vente) {
                $multiplicateur = ($vente->type_achat === 'cageot' || $vente->type_achat == 'pack') ? ($vente->article->conditionnement ?? 1) : 1;
                return $vente->prix * $vente->quantite * $multiplicateur;
            });

            $commande->ventes_consignation_sum_prix = $commande->ventes->sum(fn($vente) => optional($vente->consignation)->prix * $vente->article->prix_consignation ?? 0);
            $commande->ventes_consignation_sum_prix_cgt = $commande->ventes->sum(fn($vente) => optional($vente->consignation)->prix_cgt * $vente->article->prix_cgt ?? 0);
        });
        //dd($commandes);

        return view('pages.clients.Commande', [
            'commandes' => $commandes,
            'articles' => Article::all(),
            'clients' => Client::all(),
            'dernier' => Commande::latest()->first(),
            'client_id' => $id,
            'cgt' => $article->prix_cgt,
        ]);
    }


    public function profil($id)
    {
        $client = Client::with([
            'commandes.ventes.consignation',
            'commandes.ventes.article',
            'commandes.conditionnement',
            'commandes.payements',
        ])->withCount('commandes')->findOrFail($id);

        // Calcul des statistiques
        $client->commandes_total = $client->commandes->sum(function ($commande) {
            return $commande->ventes->sum('total');
        });

        $client->commandes_total_non_paye = $client->commandes->where('etat_commande', 'non payé')->sum(function ($commande) {
            return $commande->ventes->sum('total');
        });

        $client->nombre_com_no_paye = $client->commandes->where('etat_commande', 'non payé')->count();

        $client->payement_fait = $client->commandes->sum(function ($commande) {
            return $commande->payements->where('operation', 'partiel')->sum('somme');
        });

        $client->reste_a_payer = $client->commandes_total_non_paye - $client->payement_fait;

        $client->sum_btl = $client->commandes->sum(function ($commande) {
            return $commande->ventes->sum(function ($vente) {
                return optional($vente->consignation)->prix ?? 0;
            });
        });

        $client->sum_cgt = $client->commandes->sum(function ($commande) {
            return $commande->ventes->sum(function ($vente) {
                return optional($vente->consignation)->prix_cgt ?? 0;
            });
        });

        $derniereCommande = $client->commandes->sortByDesc('created_at')->first();
        $derniereVisite = $derniereCommande ? $derniereCommande->created_at : 'Jamais';

        return view('pages.clients.Profil', [
            'client' => $client,
            'commandes' => Commande::with(['ventes', 'client'])
                ->where('client_id', $id)
                ->orderByDesc('id')
                ->paginate(5),
            'derniereVisite' => $derniereVisite
        ]);
    }
    public function historique($id)
    {
        $client = Client::with(['commandes.payements'])
            ->where('id', $id)
            ->firstOrFail(); // pour éviter les erreurs si le client n'existe pas
        //dd($client->toArray());
        return view('pages.clients.Historique', [
            'clients' => $client,
            'client_id' => $id,
        ]);
    }
}
