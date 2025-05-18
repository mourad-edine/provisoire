@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">
    <!-- En-tête de page -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <button class="btn btn-dark shadow-sm" data-toggle="modal" data-target="#addExpenseModal">
            <i class="fas fa-plus-circle fa-sm text-white-50"></i> Nouvelle Dépense
        </button>
    </div>

    <!-- Cartes de synthèse -->
    <div class="row">
        <!-- Dépenses ce mois - Style minimaliste -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-blue mr-3">
                            <i class="fas fa-calendar-alt text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Dépenses ce mois</p>
                            <h5 class="mb-0">{{$totalmois . ' Ar'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépenses du jour - Style compact -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card minimal-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-soft-green mr-3">
                            <i class="fas fa-coins text-warning"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Aujourd'hui</p>
                            <h5 class="mb-0">{{$totalJour . ' Ar'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catégorie principale - Style simple -->


        <!-- Dépense moyenne - Style sobre -->
      
    </div>

    <style>
        .minimal-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }



        .icon-square {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .bg-soft-blue {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-soft-green {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-soft-purple {
            background-color: rgba(111, 66, 193, 0.1);
        }

        .bg-soft-orange {
            background-color: rgba(255, 193, 7, 0.1);
        }

        h5 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .small {
            font-size: 0.75rem;
        }
    </style>
    <!-- Tableau des dépenses -->
    <div class="card shadow mb-1">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
            <h6 class="m-0 font-weight-bold text-dark">Historique des Dépenses</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Options :</div>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-export mr-2"></i>Exporter</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-filter mr-2"></i>Filtrer</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fas fa-sync-alt mr-2"></i>Actualiser</a>
                </div>
            </div>
        </div>
        <div class="card-body" style="font-size: 0.9rem;">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="expensesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Moyen de paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($depense as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="font-weight-bold">{{ number_format($item->montant, 2, ',', ' ') }} Ar</td>
                            <td>{{ $item->mode_paye }}</td>
                            <td>
                                <!-- Bouton pour supprimer (à adapter selon route) -->
                                <form action="{{ route('depense.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn" onclick="return confirm('Supprimer cette dépense ?')">
                                        <i class="fas fa-trash text-warning"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de dépense -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="expenseForm" method="POST" action="{{ route('depense.store') }}">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addExpenseModalLabel">Nouvelle Dépense</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <select class="form-control" name="categorie" id="categorie" required>
                            <option value="Fournitures de bureau">Fournitures de bureau</option>
                            <option value="Frais de déplacement">Frais de déplacement</option>
                            <option value="Repas et restauration">Repas et restauration</option>
                            <option value="Équipement informatique">Équipement informatique</option>
                            <option value="Autres dépenses">Autres dépenses</option>
                        </select>
                    </div> -->

                    

                    <div class="form-group">
                        <label for="montant">Montant (Ar)</label>
                        <input type="number" class="form-control" name="montant" id="montant" required>
                    </div>

                    <div class="form-group">
                        <label for="mode_paye">Moyen de paiement</label>
                        <select class="form-control" name="mode_paye" id="mode_paye" required>
                            <option value="Espèces">Espèces</option>
                            <option value="Mobile Money">Mobile Money</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description (optionel <span class="text-danger">*</span>)</label>
                        <textarea class="form-control" name="description" id="description" rows="2" maxlength="100"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialisation du DataTable
        $('#expensesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
            "order": [
                [0, "desc"]
            ]
        });

        // Gestion de l'ajout de dépense
        $('#addExpenseBtn').click(function() {
            // Ici, vous pouvez ajouter la logique pour enregistrer la dépense
            alert('Fonctionnalité à implémenter: Enregistrement de la dépense');
        });
    });
</script>
@endsection