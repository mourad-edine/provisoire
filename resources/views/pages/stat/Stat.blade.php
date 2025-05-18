@extends('layouts.AdminLayout')

@section('title', 'statistique')


@section('content')
<div class="container-fluid" style="font-size: 0.8rem;">
    <!-- Ajoutez cette section après le sélecteur d'année et avant les 3 tableaux -->

    <div class="row">
        <!-- Carte 1: Dépenses du mois -->
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-red mr-2">
                            <i class="fas fa-money-bill-wave text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Achat de ce mois</p>
                            <h6 class="mb-0">
                                {{$achatMois . ' Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-blue mr-2">
                            <i class="fas fa-shopping-cart text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Achats auj.</p>
                            <h6 class="mb-0">
                                {{$achatJour .' Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 2: Dépenses du jour -->
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-orange mr-2">
                            <i class="fas fa-coins text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Dép. aujourd'hui</p>
                            <h6 class="mb-0">
                                {{$depensejour . ' Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-orange mr-2">
                            <i class="fas fa-coins text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Dép. de ce mois</p>
                            <h6 class="mb-0">
                                {{$depensemois . ' Ar'}}

                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 3: Ventes du jour -->
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-green mr-2">
                            <i class="fas fa-cash-register text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Ventes auj.</p>
                            <h6 class="mb-0">
                                {{$venteJour . 'Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-green mr-2">
                            <i class="fas fa-cash-register text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Ventes mois</p>
                            <h6 class="mb-0">
                                {{$venteMois .' Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 4: Achats du jour -->


        <!-- Carte 5: Bénéfice du mois -->
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-purple mr-2">
                            <i class="fas fa-chart-line text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Bénéfice mois</p>
                            <h6 class="mb-0">
                                {{$beneficeMois . ' Ar'}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 6: Taux de rentabilité -->

    </div>

    <style>
        .minimal-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .minimal-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .icon-square {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .bg-soft-red {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-soft-orange {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-soft-green {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-soft-blue {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-soft-purple {
            background-color: rgba(111, 66, 193, 0.1);
        }

        .bg-soft-gray {
            background-color: rgba(108, 117, 125, 0.1);
        }

        h6 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .small {
            font-size: 1rem;
        }

        .text-success {
            color: #198754 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
    <!-- Sélecteur d'année -->
    <div class="card shadow mb-2">
        <!-- En-tête de recherche amélioré -->
        <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center bg-dark">
            <h6 class="m-0 font-weight-bold text-white mb-3 mb-md-0">Analyse financière par année</h6>

            <div class="d-flex align-items-center">
                <!-- Formulaire pour envoyer l'année en GET -->
                <form method="GET" action="{{ route('stat') }}" class="form-inline">
                    <!-- Sélecteur d'année -->
                    <div class="form-group mb-0 mr-3">
                        <label for="yearSelect" class="sr-only">Sélectionner une année</label>
                        <select id="yearSelect" name="annee" class="form-control">
                            @for($i = 2020; $i <= 2025; $i++)
                                <option value="{{ $i }}" {{ $i == ($selectedYear ?? 2024) ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                        </select>
                    </div>

                    <!-- Bouton de recherche -->
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Ligne des 3 tableaux -->
    <div class="row">
        @php
        $moisNom = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        $caParMois = $ventesParMois->pluck('total', 'mois')->toArray();
        $depensesParMois = $depense->pluck('total', 'mois')->toArray();
        $totalCA = 0;
        $totalDepense = 0;
        $totalBenefice = 0;
        @endphp

        <!-- CA Mensuel -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-light text-dark">
                    <h6 class="m-0 font-weight-bold">Chiffre d'Affaires Mensuel</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50%">Mois</th>
                                    <th width="50%">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                @php
                                $montant = $caParMois[$num] ?? 0;
                                $totalCA += $montant;
                                @endphp
                                <tr>
                                    <td><strong>{{ $mois }}</strong></td>
                                    <td class="text-right">{{ number_format($montant, 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                                <tr>
                                    <td>TOTAL</td>
                                    <td class="text-right">{{ number_format($totalCA, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépenses Mensuelles -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-light text-dark">
                    <h6 class="m-0 font-weight-bold">Dépenses Mensuelles</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50%">Mois</th>
                                    <th width="50%">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                @php
                                $montant = $depensesParMois[$num] ?? 0;
                                $totalDepense += $montant;
                                @endphp
                                <tr>
                                    <td><strong>{{ $mois }}</strong></td>
                                    <td class="text-right">{{ number_format($montant, 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                                <tr>
                                    <td>TOTAL</td>
                                    <td class="text-right">{{ number_format($totalDepense, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bénéfice Mensuel -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-light text-dark">
                    <h6 class="m-0 font-weight-bold">Bénéfice / Pertes Mensuel</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50%">Mois</th>
                                    <th width="50%">Montant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moisNom as $num => $mois)
                                @php
                                $ca = $caParMois[$num] ?? 0;
                                $dep = $depensesParMois[$num] ?? 0;
                                $benefice = $ca - $dep;
                                $totalBenefice += $benefice;
                                @endphp
                                <tr>
                                    <td><strong>{{ $mois }}</strong></td>
                                    <td class="text-right">@if($benefice < 0 ) <span class="text-danger">{{ number_format($benefice, 0, ',', ' ') }}</span> @else <span class="text-success">{{ number_format($benefice, 0, ',', ' ') }} @endif</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                                <tr>
                                    <td>TOTAL</td>
                                    <td class="text-right">{{ number_format($totalBenefice, 0, ',', ' ') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recherche par date -->
    <div class="card shadow mt-4">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="m-0 font-weight-bold">Recherche vente par date</h6>
        </div>
        <div class="card-body">
            <form action="{{route('stat')}}" id="dateSearchForm" class="mb-4">
                <div class="form-row align-items-center">
                    <div class="col-md-4">
                        <label class="sr-only" for="searchDate">Date</label>
                        <input name="date_vente" type="date" class="form-control" id="searchDate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light w-100">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </form>

            <!-- Résultats de recherche -->
            <div id="searchResults" class="row">
                <div class="col-md-8">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 bg-light">
                            <h6 class="m-0 font-weight-bold text-dark">Articles vendus</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Article</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="soldItemsTable">
                                        @if(count($ventes) > 0)
                                        @foreach($ventes as $vente)
                                        <tr>
                                            <td>{{ $vente->article->nom ?? 'Article inconnu' }}</td>
                                            <td>{{ number_format($vente->prix, 0, ',', ' ') }} Ar</td>
                                            <td>{{ $vente->quantite }} - {{ ucfirst($vente->type_achat) }}</td>
                                            <td>
                                                @if(in_array($vente->type_achat, ['cageot', 'pack']))
                                                {{ number_format($vente->quantite * $vente->prix * ($vente->article->conditionnement ?? 1), 0, ',', ' ') }}
                                                @else
                                                {{ number_format($vente->quantite * $vente->prix, 0, ',', ' ') }}
                                                @endif
                                                Ar
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Aucune vente enregistrée</h5>
                                                    <p class="text-muted small">Aucun article n'a été vendu pour cette période</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card  shadow h-100">
                        <div class="card-header py-3 bg-light">
                            <h6 class="m-0 font-weight-bold text-success">Résumé des ventes</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Nombre de ventes</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" id="salesCount">
                                    {{ $ventes->count() }}
                                </div>
                            </div>
                            <hr>
                            <div class="text-center mb-4">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total du jour</div>
                                <div class="h2 mb-0 font-weight-bold text-success" id="dailyTotal">
                                    {{
                        number_format($ventes->sum(function($vente) {
                            return ($vente->type_achat === 'cageot' || $vente->type_achat === 'pack')
                                ? $vente->quantite * $vente->prix * $vente->article->conditionnement
                                : $vente->quantite * $vente->prix;
                        }), 0, ',', ' ')
                    }} Ar
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Changement d'année
        $('#yearSelect').change(function() {
            // À implémenter: Chargement des données via AJAX
            console.log('Chargement des données pour ' + $(this).val());
        });

        // Recherche par date
        $('#dateSearchForm').submit(function(e) {
            e.preventDefault();
            const date = $('#searchDate').val();

            // Simulation de données (à remplacer par un appel AJAX)
            console.log('Recherche des ventes pour le ' + date);

            // Exemple de mise à jour des données (en production, utiliser la réponse AJAX)
            const sampleData = {
                salesCount: Math.floor(Math.random() * 15) + 5,
                dailyTotal: Math.floor(Math.random() * 10000) + 1000,
                items: [{
                        name: 'Produit A',
                        price: 120,
                        quantity: 3
                    },
                    {
                        name: 'Produit B',
                        price: 45,
                        quantity: 7
                    },
                    {
                        name: 'Produit C',
                        price: 89,
                        quantity: 2
                    }
                ]
            };

            // Mise à jour du résumé
            $('#salesCount').text(sampleData.salesCount);
            $('#dailyTotal').text(sampleData.dailyTotal.toLocaleString('fr-FR') + ' Ar');
            $('#averageSale').text((sampleData.dailyTotal / sampleData.salesCount).toLocaleString('fr-FR', {
                maximumFractionDigits: 2
            }) + ' Ar');

            // Mise à jour du tableau des articles
            let itemsHtml = '';
            sampleData.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.price.toLocaleString('fr-FR')} Ar</td>
                        <td>${item.quantity}</td>
                        <td>${(item.price * item.quantity).toLocaleString('fr-FR')} Ar</td>
                    </tr>
                `;
            });
            $('#soldItemsTable').html(itemsHtml);

            // Animation de feedback
            $('#searchResults').hide().fadeIn(300);
        });
    });
</script>
@endsection