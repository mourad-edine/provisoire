@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">
    <!-- Onglets de navigation -->
    <div class="mt-4">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <ul class="nav nav-tabs" id="parametresTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" type="button" role="tab" aria-controls="consignation" aria-selected="true">
                    <i class="fas fa-wine-bottle me-2"></i>Consignation
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" type="button" role="tab" aria-controls="utilisateur" aria-selected="false">
                    <i class="fas fa-user me-2"></i>Utilisateur
                </button>
            </li>
        </ul>

        <div class="tab-content" id="parametresTabsContent">
            <!-- Onglet Consignation -->
            <div class="tab-pane fade show active" id="consignation" role="tabpanel" aria-labelledby="consignation-tab">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="text-white">Paramètres de Consignation</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('parametre.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="consignation_bouteille_33" class="form-label">Consignation Bouteille 30 - 33 cl</label>
                                        <input type="number" step="0.01" class="form-control" id="consignation_bouteille_33" name="consignation_bouteille_33">
                                    </div>

                                    <div class="mb-3">
                                        <label for="consignation_bouteille_65" class="form-label">Consignation Bouteille 50 - 65 cl</label>
                                        <input type="number" step="0.01" class="form-control" id="consignation_bouteille_65" name="consignation_bouteille_65">
                                    </div>

                                    <div class="mb-3">
                                        <label for="consignation_bouteille_100" class="form-label">Consignation Bouteille 100 cl</label>
                                        <input type="number" step="0.01" class="form-control" id="consignation_bouteille_100" name="consignation_bouteille_100">
                                    </div>

                                    <div class="mb-3">
                                        <label for="consignation_cageot" class="form-label">Consignation Cageot</label>
                                        <input type="number" step="0.01" class="form-control" id="consignation_cageot" name="consignation_cageot">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-secondary">Enregistrer les modification</button>
                                        <a style="text-decoration: none;" href="#"><button type="submit" class="btn btn-danger">retour</button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0 text-white">Valeurs actuelles</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Type</th>
                                                    <th class="text-end">Valeur</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        @if($type33)
                                                        bouteille de 30 - {{ $type33->type_btl }} cl
                                                        @else
                                                        Non disponible
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($type33)
                                                        {{ number_format($type33->prix_consignation, 0, ',', ' ') }} Ar
                                                        @else
                                                        -
                                                        @endif
                                                    </td>

                                                </tr>

                                                <!-- Ligne pour le type 65 -->
                                                <tr>
                                                    <td>
                                                        @if($type65)
                                                        bouteille de 50 - {{ $type65->type_btl }} cl
                                                        @else
                                                        Non disponible
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($type65)
                                                        {{ number_format($type65->prix_consignation, 0, ',', ' ') }} Ar
                                                        @else
                                                        -
                                                        @endif
                                                    </td>

                                                </tr>

                                                <!-- Ligne pour le type 100 -->
                                                <tr>
                                                    <td>
                                                        @if($type100)
                                                        Bouteille de {{ $type100->type_btl }} cl
                                                        @else
                                                        Non disponible
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($type100)
                                                        {{ number_format($type100->prix_consignation, 0, ',', ' ') }} Ar
                                                        @else
                                                        -
                                                        @endif
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>
                                                        Cageot
                                                    </td>
                                                    <td>
                                                        @if($type33)
                                                       {{ $type100->prix_cgt }} Ar
                                                        @else
                                                        Non disponible
                                                        @endif
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Utilisateur -->
            <div class="tab-pane fade" id="utilisateur" role="tabpanel" aria-labelledby="utilisateur-tab">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="text-white">Paramètres Utilisateur</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('add.user')}}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nom_utilisateur" class="form-label">Nom d'utilisateur</label>
                                        <input type="text" class="form-control" id="nom_utilisateur" name="name" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email_utilisateur" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email_utilisateur" name="email" required autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="mot_de_passe" name="password" autocomplete="off">
                                    </div>

                                    <button type="submit" class="btn btn-secondary"><i class="fas fa-plus text-white"></i> Ajouter un utilisateur
                                    </button>
                                    <a style="text-decoration: none;" href="#"><button type="submit" class="btn btn-danger">retour</button>
                                    </a>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0 text-white">Utilisateurs existants</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>id</th>
                                                    <th>Nom</th>
                                                    <th>Email</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        {{$user->id}}
                                                    </td>
                                                    <td>{{$user->name}}</td>
                                                    <td>
                                                        {{$user->email}}
                                                    </td>
                                                    <td class="text-end">
                                                        <button class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour gérer les onglets -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activer les onglets Bootstrap
        const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabElms.forEach(tabEl => {
            tabEl.addEventListener('click', function(event) {
                const target = event.target.getAttribute('data-bs-target');
                const tabContent = document.querySelector('.tab-content');

                // Masquer tous les contenus d'onglet
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // Afficher le contenu de l'onglet sélectionné
                document.querySelector(target).classList.add('show', 'active');

                // Mettre à jour les onglets actifs
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                event.target.classList.add('active');
            });
        });

        // Gestion de l'URL pour permettre le retour à un onglet spécifique
        if (location.hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${location.hash}"]`);
            if (tabTrigger) {
                new bootstrap.Tab(tabTrigger).show();
            }
        }

        // Mettre à jour l'URL quand un onglet est cliqué
        const navTabs = document.querySelectorAll('.nav-tabs .nav-link');
        navTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.getAttribute('data-bs-target');
                if (target) {
                    history.pushState(null, null, target);
                }
            });
        });
    });
</script>

<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->



<!-- Content Row -->


</div>

@endsection