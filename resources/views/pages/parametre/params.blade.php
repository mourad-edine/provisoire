@extends('layouts.AdminLayout')

@section('title', 'Paramètres système')

@section('content')
<div class="container-fluid px-0 bg-light" style="font-size : 0.85rem;">
    <!-- En-tête -->
    <div class="bg-dark px-4 py-3 border-bottom border-dark">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">
                <i class="fas fa-cog me-2 text-warning"></i>Paramètres système
            </h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-warning">Dashboard</a></li>
                    <li class="breadcrumb-item active text-muted ">Paramètres</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Contenu principal -->
    <div class="px-4 py-3">
        <!-- Onglets -->
        <ul class="nav nav-tabs border-dark mb-3" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active text-dark fw-bold" id="consignation-tab" data-bs-toggle="tab" data-bs-target="#consignation" role="tab">
                    <i class="fas fa-wine-bottle me-2"></i>Consignation
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-dark fw-bold" id="utilisateur-tab" data-bs-toggle="tab" data-bs-target="#utilisateur" role="tab">
                    <i class="fas fa-users me-2"></i>Utilisateurs
                </button>
            </li>
        </ul>

        <div class="tab-content bg-white border border-top-0 rounded-bottom shadow-sm p-4 border-dark">
            <!-- Tab: Consignation -->
            <div class="tab-pane fade show active" id="consignation" role="tabpanel">
                <div class="row">
                    <!-- Tarifs actuels -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-dark fw-bold mb-3"><i class="fas fa-list me-2 text-dark"></i>Tarifs actuels</h6>
                        <div class="list-group">
                            @php
                                $tarifs = [
                                    'Bouteille 30-33 cl' => $type33->prix_consignation ?? 0,
                                    'Bouteille 50-65 cl' => $type65->prix_consignation ?? 0,
                                    'Bouteille 100 cl' => $type100->prix_consignation ?? 0,
                                    'Cageot' => $type33->prix_cgt ?? 0,
                                ];
                            @endphp

                            @foreach($tarifs as $label => $prix)
                                <div class="list-group-item d-flex justify-content-between border-dark">
                                    <span class="text-dark">{{ $label }}</span>
                                    <span class="fw-bold text-dark">{{ number_format($prix, 0, ',', ' ') }} Ar</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <div class="col-md-6">
                        <h6 class="text-dark fw-bold mb-3"><i class="fas fa-edit me-2 text-dark"></i>Modifier les tarifs</h6>
                        <form action="{{ route('parametre.store') }}" method="POST" class="p-3 bg-white rounded border border-dark">
                            @csrf
                            @foreach([
                                'Bouteille 30-33 cl' => 'consignation_bouteille_33',
                                'Bouteille 50-65 cl' => 'consignation_bouteille_65',
                                'Bouteille 100 cl' => 'consignation_bouteille_100',
                                'Cageot' => 'consignation_cageot'
                            ] as $label => $name)
                                <div class="mb-3">
                                    <label class="form-label text-dark">{{ $label }}</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="{{ $name }}" class="form-control border-dark">
                                        <span class="input-group-text bg-white text-dark border-dark">Ar</span>
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-dark w-100 mt-2">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab: Utilisateurs -->
            <div class="tab-pane fade" id="utilisateur" role="tabpanel">
                <div class="row">
                    <!-- Ajouter utilisateur -->
                    <div class="col-md-5 mb-4">
                        <h6 class="text-dark fw-bold mb-3"><i class="fas fa-user-plus me-2 text-dark"></i>Ajouter un utilisateur</h6>
                        <form action="{{ route('add.user') }}" method="POST" class="p-3 bg-white border border-dark rounded">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-dark">Nom complet</label>
                                <input type="text" name="name" class="form-control border-dark" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-dark">Email</label>
                                <input type="email" name="email" class="form-control border-dark" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-dark">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control border-dark" required>
                                    <button type="button" class="btn btn-outline-dark toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input border-dark" type="checkbox" name="is_admin" id="is_admin">
                                <label class="form-check-label text-dark" for="is_admin">Administrateur</label>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="fas fa-plus me-2"></i>Créer
                            </button>
                        </form>
                    </div>

                    <!-- Liste utilisateurs -->
                    <div class="col-md-7">
                        <h6 class="text-dark fw-bold mb-3"><i class="fas fa-users me-2 text-dark"></i>Liste des utilisateurs ({{ count($users) }})</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark text-white">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-dark">
                                                {{ $user->name }}
                                                @if($user->is_admin)
                                                    <span class="badge bg-dark text-white ms-2">Admin</span>
                                                @endif
                                            </td>
                                            <td class="text-dark">{{ $user->email }}</td>
                                            <td class="text-end">
                                                <button class="btn  me-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn">
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
            </div> <!-- Fin Utilisateurs -->
        </div>
    </div> <!-- Fin Contenu principal -->
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>
@endsection
