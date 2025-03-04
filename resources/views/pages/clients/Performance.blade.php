@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <h2>Performance des clients</h2>
    <hr>
    
    <!-- Résumé des performances -->
    <div class="row">
        <div class="col-md-4">
            <h3>Vue d'ensemble</h3>
            <ul>
                <li><strong>Commandes totales :</strong> 18</li>
            </ul>
        </div>
        
        <!-- Graphiques de performance -->
        
    </div>

    <!-- Détails des performances par produit -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Détails des Performances par achats de produit</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité acheté</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>THB</td>
                            <td>300</td>
    
                        </tr>
                        <tr>
                            <td>THB</td>
                            <td>300</td>
>
                        </tr>
                        <tr>
                            <td>THB</td>
                            <td>300</td>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Comparaison avec les objectifs -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Comparaison plus grands acheteurs</h3>
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
            <h3>remarque</h3>
            <ul>
                <li>client A : achète beaucoup de THB</li>
                <li>Fournisseur B : achète beaucoup de xxl</li>
                <li>Fournisseur C : achète beaucoup de GOLD</li>
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
