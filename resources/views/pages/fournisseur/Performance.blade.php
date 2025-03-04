@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <h2>Performance des Fournisseurs</h2>
    <hr>
    
    <!-- Résumé des performances -->
    <div class="row">
        <div class="col-md-4">
            <h3>Vue d'ensemble</h3>
            <ul>
                <li><strong>Commandes totales :</strong> 18</li>
                <li><strong>Livraisons à temps :</strong> 100%</li>
                <li><strong>Qualité des produits :</strong> 6/5</li>
                <li><strong>Satisfaction client :</strong> 3/5</li>
            </ul>
        </div>
        
        <!-- Graphiques de performance -->
        <div class="col-md-8">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Détails des performances par produit -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Détails des Performances par Produit</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité Vendue</th>
                        <th>Taux de Retour</th>
                        <th>Note de Qualité</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>THB</td>
                            <td>300</td>
                            <td>30%</td>
                            <td>4/5</td>
                        </tr>
                        <tr>
                            <td>THB</td>
                            <td>300</td>
                            <td>30%</td>
                            <td>4/5</td>
                        </tr>
                        <tr>
                            <td>THB</td>
                            <td>300</td>
                            <td>30%</td>
                            <td>4/5</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Comparaison avec les objectifs -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Comparaison des prix par fournisseur</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fournisseur</th>
                        <th>produit</th>
                        <th>prix</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recommandations -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Recommandations</h3>
            <ul>
                <li>Fournisseur A : Améliorer la qualité des produits en augmentant les contrôles internes.</li>
                <li>Fournisseur B : Optimiser les délais de livraison pour atteindre 98% de livraisons à temps.</li>
                <li>Fournisseur C : Maintenir la qualité des produits et les livraisons à temps.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Script pour le graphique -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],  // À adapter selon vos données
            datasets: [{
                label: 'Ventes Mensuelles',
                data: [100 ,200,600 ,500 ,400 ,700, 100],  // Utilisez les données passées depuis le contrôleur
                borderColor: 'rgba(78, 115, 223, 1)',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderWidth: 2
            }]
        }
    });
</script>

@endsection
