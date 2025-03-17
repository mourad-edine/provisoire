@extends('layouts.AdminLayout')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de Bord</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> exporter
        </a>
    </div>

    <!-- Statistiques principales -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Boissons Vendues (Aujourd'hui)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$ventejour}} cageot</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wine-bottle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Boissons Vendues (Mois)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$ventemois}} cageot</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wine-bottle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenu Total (Aujourd'hui)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$recettejour}} Ar</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenu Total (Ce mois ci)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$recettemois}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenu Total (Annuel)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$recetteannee}} Ar</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{route('vente.page')}}">
            <div class="card  shadow h-100 py-2" style="background : rgb(22 163 74 / var(--tw-bg-opacity, 1));">

                    <div class="card-body bg-blue-600">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">VENDRE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{route('achat.liste')}}">
                <div class="card shadow h-100 py-2" style="--tw-bg-opacity: 1;background: rgb(37 99 235 / var(--tw-bg-opacity, 1));">

                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">ACHETER</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>

        
    </div>

    <!-- Graphique des ventes -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Évolution des Ventes</h6>
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Meilleures Ventes</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-gray-300">
                            <tr>
                                <th>Produit</th>
                                <th>Ventes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meilleur as $meilleu)
                            <tr>
                                <td>{{$meilleu->nom}}</td>
                                <td>{{$meilleu->achats_count}}</td>
                            </tr>
                           @empty
                           <tr>
                                <td class="text-primary">pas encore de vente</td>
                                
                            </tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableaux de suivi -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stocks Faibles</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-gray-300">
                            <tr>
                                <th>produit</th>
                                <th>reste</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faible as $faib)
                            <tr>
                                <td>{{$faib->nom}}</td>
                                <td>{{$faib->quantite}}</td>
                            </tr>
                            @empty

                            <tr>
                                <td class="text-primary">pas encore de vente</td>
                            </tr>
                            @endforelse
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques journalières</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Type d'opération</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ventes</td>
                                <td>{{$ventejour}}</td>
                            </tr>
                            <tr>
                                <td>Achats</td>
                                <td>{{$achatjour}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Revenus</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenuChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Ventes -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Ventes</h6>
                </div>
                <div class="card-body">
                    <canvas id="venteChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Ventes par Catégorie -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Répartition des Ventes</h6>
                </div>
                <div class="card-body">
                    <canvas id="categorieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Profits -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Profits</h6>
                </div>
                <div class="card-body">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('revenuChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Journalier', 'Hebdomadaire', 'Mensuel', 'Annuel'],
            datasets: [{
                label: 'Revenus en $',
                data: [500, 3500, 15000, 75000],
                backgroundColor: ['blue', 'orange', 'green', 'red']
            }]
        }
    });

    const ctx2 = document.getElementById('venteChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'],
            datasets: [{
                label: 'Ventes',
                data: [120, 150, 180, 220],
                borderColor: 'blue',
                fill: false
            }]
        }
    });

    const ctx3 = document.getElementById('categorieChart').getContext('2d');
    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Sodas', 'Jus', 'Eaux', 'Alcools'],
            datasets: [{
                label: 'Répartition des ventes',
                data: [400, 300, 250, 250],
                backgroundColor: ['#947f82', '#495ec8', 'blue', 'green']
            }]
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],
            datasets: [{
                label: 'Ventes Mensuelles',
                data: [300, 400, 500, 700, 600, 800, 1000],
                borderColor: 'rgba(78, 115, 223, 1)',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderWidth: 2
            }]
        }
    });
</script>
@endsection