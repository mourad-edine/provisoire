@extends('layouts.AdminLayout')

@section('title', 'Détails Achat')

@section('content')
<style>
    .nav-tab {
        transition: all 0.3s ease;
        border-radius: 8px 8px 0 0;
    }

    .nav-tab.active {
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .nav-tab:not(.active):hover {
        color: #3b82f6;
    }

    .info-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .table-container {
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-header {
        color: white;
        padding: 1.25rem;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        padding: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    .data-table tr:hover td {
        background-color: #f8fafc;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-paid {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .amount-cell {
        font-weight: 600;
        color: #059669;
    }

    .total-display {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #bbf7d0;
        padding: 1.5rem;
    }

    .action-btn {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 py-8">
    <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec navigation -->
        <!-- <div class="glass-effect shadow-lg mb-8 border border-white/50">
            <div class="px-6 py-4">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
                            <i class="fas fa-shopping-cart text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">GESTION DES ACHATS</h1>
                            <p class="text-gray-600 text-sm">Détails de la commande d'achat #{{ $id }}</p>
                        </div>
                    </div>

                    <nav class="flex items-center space-x-1 text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">DASHBOARD</a>
                        <span class="text-gray-400">/</span>
                        <a href="{{ route('achat.commande') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">ACHATS</a>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-500">DÉTAILS</span>
                    </nav>
                </div>
            </div>
        </div> -->

        <!-- Navigation par onglets -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
            <div class="w-full">
                <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                    <!-- En-tête avec titre -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-cog mr-3 text-blue-600"></i>
                            Gestion de la commande #{{ $id }}
                        </h3>
                    </div>

                    <!-- Grille des actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        <!-- Carte Détails commande -->
                        <a href="{{ route('achat.commande') }}"
                            class="group bg-white border-2 border-gray-200 hover:border-blue-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-300">
                                    <i class="fas fa-file-alt text-blue-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Listes par commandes</h4>
                                    <p class="text-xs text-gray-500">Voir les informations détaillées</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Historique paiements -->
                        <a href="{{ route('achat.liste') }}"
                            class="group bg-white border-2 border-gray-200 hover:border-green-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors duration-300">
                                    <i class="fas fa-history text-green-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Listes achats</h4>
                                    <p class="text-xs text-gray-500">Consulter l'historique</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Articles à rendre -->
                        <a href="{{ route('achat.page') }}"
                            class="group bg-white border-2 border-gray-200 hover:border-amber-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                    <i class="fas fa-undo text-amber-600 group-hover:text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors"> Nouvel achat
                                    </h4>
                                    <p class="text-xs text-gray-500">Acheter</p>
                                </div>
                            </div>
                        </a>

                        <!-- Carte Compte rendu -->

                    </div>

                    <!-- Barre de statut en bas -->

                </div>
            </div>
        </div>




        <!-- Carte Informations Fournisseur -->
        <div class="info-card mb-8 animate-fade-in">
            <div class="bg-white text-dark rounded-t-2xl">

            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100  flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nom du fournisseur</p>
                                <p class="font-semibold text-gray-900">{{ $commande->fournisseur->nom ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100  flex items-center justify-center">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Téléphone</p>
                                <p class="font-semibold text-gray-900">{{ $commande->client->telephone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100  flex items-center justify-center">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-semibold text-gray-900">{{ $commande->fournisseur->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100  flex items-center justify-center">
                                <i class="fas fa-calendar text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date de commande</p>
                                <p class="font-semibold text-gray-900">{{ $commande->created_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des achats -->
        <div class="table-container animate-fade-in" style="animation-delay: 0.1s">
            <div class="bg-white text-dark flex flex-col sm:flex-row justify-end items-start sm:items-center gap-4 p-2">


                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('pdf.achat', ['id' => $id]) }}"
                        class="action-btn bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-2 flex items-center gap-2">
                        <i class="fas fa-print"></i>
                        Télécharger la facture
                    </a>

                    <a href="{{ url()->previous() }}"
                        class="action-btn bg-gradient-to-r from-gray-600 to-gray-700 text-white px-4 py-2 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Retour
                    </a>
                </div>
            </div>

            <div class="p-6">
                <!-- Message de succès -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Tableau -->
                <div class="overflow-x-auto  border border-gray-200">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="text-left">ID</th>
                                <th class="text-left">Article</th>
                                <th class="text-right">Prix Unité</th>
                                <th class="text-right">Prix/Cageot</th>
                                <th class="text-center">Commande</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">État</th>
                                <th class="text-right">Total</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($achats as $achat)
                            <tr class="animate-fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td class="font-mono text-sm text-gray-600">#{{ $achat['id'] }}</td>
                                <td class="font-medium text-gray-900">{{ $achat['article'] }}</td>
                                <td class="text-right text-gray-700">{{ number_format($achat['prix_unite'], 0, ',', ' ') }} Ar</td>
                                <td class="text-right text-gray-700">{{ number_format($achat['prix_unite'] * $achat['conditionnement'], 0, ',', ' ') }} Ar</td>
                                <td class="text-center">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                        C-{{ $achat['numero_commande'] }}
                                    </span>
                                </td>
                                <td class="text-center text-gray-700">
                                    <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium">
                                        {{ $achat['quantite'] }} - {{ ucfirst($achat['type_achat']) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge status-paid">
                                        <i class="fas fa-check-circle"></i>
                                        Payé
                                    </span>
                                </td>
                                <td class="text-right amount-cell">{{ number_format($achat['prix'], 0, ',', ' ') }} Ar</td>
                                <td class="text-center text-sm text-gray-500">{{ $achat['created_at'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <i class="fas fa-box-open text-4xl mb-3"></i>
                                        <h5 class="font-semibold mb-1">Aucun achat trouvé</h5>
                                        <p class="text-sm">Aucun enregistrement d'achat pour cette commande</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Total et Pagination -->
                <div class="mt-6 space-y-4">
                    <!-- Total -->
                    <div class="total-display flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-receipt text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Montant total de la commande</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($total, 0, ',', ' ') }} Ar</h3>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $achats->count() }} article(s)</p>
                            <p class="text-sm text-green-600 font-medium">Statut: Complet</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($achats->hasPages())
                    <div class="bg-gray-50 p-4 ">
                        {{ $achats->links('vendor.pagination.tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Résumé rapide -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white p-6  shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-boxes text-blue-600 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $achats->count() }}</h4>
                <p class="text-sm text-gray-600">Articles achetés</p>
            </div>

            <div class="bg-white p-6  shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-receipt text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ number_format($total, 0, ',', ' ') }} Ar</h4>
                <p class="text-sm text-gray-600">Montant total</p>
            </div>

            <div class="bg-white p-6  shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-check text-purple-600 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $commande->created_at }}</h4>
                <p class="text-sm text-gray-600">Date de commande</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        // Observer les éléments animés
        document.querySelectorAll('.animate-fade-in').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection