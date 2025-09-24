@extends('layouts.AdminLayout')

@section('title', 'Paramètres système')

@section('content')
<style>
    .active-tab {
        color: #2563eb;
        border-bottom: 3px solid #2563eb;
        font-weight: 600;
    }

    .inactive-tab {
        color: #6b7280;
        border-bottom: 3px solid transparent;
        font-weight: 500;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .price-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 4px solid #3b82f6;
        transition: all 0.3s ease;
    }

    .price-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        border: 1px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .user-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .user-table th {
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
    }

    .user-table td {
        border-bottom: 1px solid #e5e7eb;
        background: white;
        transition: background 0.2s ease;
    }

    .user-table tr:hover td {
        background: #f9fafb;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="glass-effect shadow-lg mb-8 border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-500 shadow-lg">
                            <i class="fas fa-cog text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">PARAMÈTRES SYSTÈME</h1>
                            <p class="text-gray-600 text-sm">Gestion de la configuration de l'application</p>
                        </div>
                    </div>
                    
                    <nav class="flex items-center space-x-1 text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">DASHBOARD</a>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-500">PARAMÈTRES</span>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Message de succès -->
        <div id="successMessage" class="hidden mb-6">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                Modifications enregistrées avec succès
                            </p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('successMessage').classList.add('hidden')" 
                            class="text-green-400 hover:text-green-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="glass-effect shadow-lg border border-gray-200">
            <!-- Onglets -->
            <div class="border-b border-gray-200 bg-white">
                <div class="px-6">
                    <nav class="flex space-x-8" id="settingsTabs" role="tablist">
                        <button class="py-4 px-1 text-sm font-medium transition-all duration-200 inactive-tab active-tab" 
                                data-tab="consignation">
                            <i class="fas fa-wine-bottle mr-2"></i>
                            CONSIGNATION
                        </button>
                        <button class="py-4 px-1 text-sm font-medium transition-all duration-200 inactive-tab" 
                                data-tab="utilisateur">
                            <i class="fas fa-users mr-2"></i>
                            UTILISATEURS
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div class="p-6">
                <!-- Tab: Consignation -->
                <div class="tab-content active" id="consignation">
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Tarifs actuels -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-list mr-2 text-blue-500"></i>
                                    Tarifs actuels
                                </h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="price-card p-4 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-700 font-medium">Bouteille 30-33 cl</span>
                                            <p class="text-gray-500 text-sm">Consignation standard</p>
                                        </div>
                                        <span class="text-2xl font-bold text-blue-600">200 Ar</span>
                                    </div>
                                </div>
                                
                                <div class="price-card p-4 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-700 font-medium">Bouteille 50-65 cl</span>
                                            <p class="text-gray-500 text-sm">Format moyen</p>
                                        </div>
                                        <span class="text-2xl font-bold text-blue-600">300 Ar</span>
                                    </div>
                                </div>
                                
                                <div class="price-card p-4 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-700 font-medium">Bouteille 100 cl</span>
                                            <p class="text-gray-500 text-sm">Grand format</p>
                                        </div>
                                        <span class="text-2xl font-bold text-blue-600">500 Ar</span>
                                    </div>
                                </div>
                                
                                <div class="price-card p-4 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-700 font-medium">Cageot</span>
                                            <p class="text-gray-500 text-sm">Conditionnement</p>
                                        </div>
                                        <span class="text-2xl font-bold text-blue-600">1 000 Ar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire de modification -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-green-500"></div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-edit mr-2 text-green-500"></i>
                                    Modifier les tarifs
                                </h3>
                            </div>
                            
                            <form class="space-y-4 p-6 bg-white shadow-sm border border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bouteille 30-33 cl</label>
                                    <div class="input-group flex">
                                        <input type="number" step="0.01" value="200" 
                                               class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <span class="bg-gray-50 px-4 py-3 text-gray-700 text-sm font-medium border-l border-gray-200">Ar</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bouteille 50-65 cl</label>
                                    <div class="input-group flex">
                                        <input type="number" step="0.01" value="300" 
                                               class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <span class="bg-gray-50 px-4 py-3 text-gray-700 text-sm font-medium border-l border-gray-200">Ar</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bouteille 100 cl</label>
                                    <div class="input-group flex">
                                        <input type="number" step="0.01" value="500" 
                                               class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <span class="bg-gray-50 px-4 py-3 text-gray-700 text-sm font-medium border-l border-gray-200">Ar</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cageot</label>
                                    <div class="input-group flex">
                                        <input type="number" step="0.01" value="1000" 
                                               class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <span class="bg-gray-50 px-4 py-3 text-gray-700 text-sm font-medium border-l border-gray-200">Ar</span>
                                    </div>
                                </div>
                                
                                <button type="button" onclick="showSuccess()" 
                                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab: Utilisateurs -->
                <div class="tab-content" id="utilisateur">
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Ajouter utilisateur -->
                        <div class="bg-white shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-purple-500"></div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-user-plus mr-2 text-purple-500"></i>
                                    Ajouter un utilisateur
                                </h3>
                            </div>

                            <form class="space-y-5" autocomplete="off">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                    <input type="text" autocomplete="off" 
                                           class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" autocomplete="off" 
                                           class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                                    <div class="input-group flex">
                                        <input type="password" autocomplete="new-password" 
                                               class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <button type="button" class="toggle-password bg-gray-50 px-4 py-3 text-gray-600 hover:text-gray-800 transition-colors border-l border-gray-200">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 border border-gray-200">
                                    <input class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" 
                                           type="checkbox" id="is_admin">
                                    <label class="text-sm text-gray-700 font-medium" for="is_admin">
                                        Accès administrateur
                                    </label>
                                </div>
                                
                                <button type="button" 
                                        class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-plus mr-2"></i>Créer l'utilisateur
                                </button>
                            </form>
                        </div>

                        <!-- Liste utilisateurs -->
                        <div class="bg-white shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-green-500"></div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-users mr-2 text-green-500"></i>
                                    Liste des utilisateurs
                                    <span class="text-blue-600 ml-2">(3)</span>
                                </h3>
                            </div>

                            <div class="overflow-hidden border border-gray-200">
                                <table class="user-table w-full">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">Admin Principal</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">admin@example.com</td>
                                            <td class="px-6 py-4 text-right text-sm">
                                                <button class="text-blue-600 hover:text-blue-800 transition-colors mr-3">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-800 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
</div>

<script>
    function showSuccess() {
        const message = document.getElementById('successMessage');
        message.classList.remove('hidden');
        setTimeout(() => {
            message.classList.add('hidden');
        }, 5000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des tabs
        const tabs = document.querySelectorAll('[data-tab]');
        const contents = document.querySelectorAll('.tab-content');

        function changeTab(tabName) {
            contents.forEach(content => content.classList.remove('active'));
            tabs.forEach(tab => {
                tab.classList.remove('active-tab');
                tab.classList.add('inactive-tab');
            });

            const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
            activeTab.classList.remove('inactive-tab');
            activeTab.classList.add('active-tab');
            document.getElementById(tabName).classList.add('active');
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                changeTab(this.dataset.tab);
            });
        });

        // Toggle password
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>
@endsection