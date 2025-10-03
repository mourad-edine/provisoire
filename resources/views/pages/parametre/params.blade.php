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
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    .logo-preview {
        width: 120px;
        height: 120px;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .logo-preview:hover {
        border-color: #3b82f6;
    }

    .logo-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .upload-area.dragover {
        border-color: #3b82f6;
        background-color: #f0f9ff;
    }

    .info-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 4px solid #10b981;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- En-tête -->
        <div class="glass-effect shadow-md mb-8 border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-500 shadow-md">
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
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif



        <!-- Contenu principal -->
        <div class="glass-effect shadow-md border border-gray-200">
            <!-- Onglets -->
            <div class="border-b border-gray-200 bg-white">
                <div class="px-6">
                    <nav class="flex space-x-8" id="settingsTabs" role="tablist">
                        <button class="py-4 px-1 text-sm font-medium transition-all duration-200 inactive-tab active-tab"
                            data-tab="entreprise">
                            <i class="fas fa-building mr-2"></i>
                            ENTREPRISE
                        </button>
                        <button class="py-4 px-1 text-sm font-medium transition-all duration-200 inactive-tab"
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
                <!-- Tab: Entreprise -->
                <div class="tab-content active" id="entreprise">
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Informations générales -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-md font-semibold text-gray-900">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    Informations de l'entreprise
                                </h3>
                            </div>

                            <form action="{{ route('edit.magasin') }}" method="POST" class="space-y-6 p-6 bg-white shadow-sm border border-gray-100">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise *</label>
                                        <input type="text" value="{{$entreprise->nom}}"
                                            name="nom"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Slogan</label>
                                        <input disabled type="text" value="Votre partenaire de confiance"
                                            class="w-full px-4 py-3 border border-gray-200 bg-gray-400 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                                    <textarea rows="3"
                                        name="adresse"
                                        class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                        placeholder="Adresse complète de l'entreprise">{{$entreprise->adresse}}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                                        <input type="tel" value="{{$entreprise->numero}}"
                                            name="numero"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" value="{{$entreprise->email}}"
                                            name="email"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 bg-gray-400">Site web</label>
                                        <input disabled type="url" value="----------"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">NIF *</label>
                                        <input type="text" value="{{$entreprise->nif}}"
                                            name="nif"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">STAT *</label>
                                        <input type="text" value="{{$entreprise->stat}}"
                                            name="stat"
                                            class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea rows="4"
                                        class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                        placeholder="Description de l'activité de l'entreprise">Spécialisée dans la distribution de boissons depuis 2010, nous sommes votre partenaire de confiance pour tous vos besoins.</textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200 shadow-md hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les informations
                                </button>
                            </form>
                        </div>

                        <!-- Logo et apparence -->
                        <div class="space-y-8">
                            <!-- Logo -->
                            <form action="{{ route('edit.logo') }}" method="POST"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="bg-white shadow-sm border border-gray-100 p-6">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-1 h-8 bg-blue-500"></div>
                                        <h3 class="text-md font-semibold text-gray-900">
                                            <i class="fas fa-image mr-2 text-blue-500"></i>
                                            Logo de l'entreprise
                                        </h3>
                                    </div>

                                    <div class="text-center space-y-4">
                                        <div class="logo-preview mx-auto cursor-pointer" onclick="document.getElementById('logoUpload').click()">
                                            <img id="logoPreview" src="{{ asset('images/' . $entreprise->logo) }}" alt="Logo" class="">
                                        </div>

                                        <input name="logo" type="file" id="logoUpload" accept="image/*" class="hidden" onchange="previewLogo(event)">

                                        <div class="upload-area p-6 cursor-pointer" onclick="document.getElementById('logoUpload').click()">
                                            <div class="text-center">
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                                <p class="text-sm text-gray-600">Cliquez pour télécharger ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 mt-1">PNG, JPG max. 2MB</p>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200">
                                            <i class="fas fa-sync-alt mr-2"></i>Mettre à jour le logo
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Informations légales -->


                            <!-- Paramètres d'impression -->
                            <div class="bg-white shadow-sm border border-gray-100 p-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-1 h-8 bg-orange-500"></div>
                                    <h3 class="text-md font-semibold text-gray-900">
                                        <i class="fas fa-print mr-2 text-orange-500"></i>
                                        Paramètres d'impression
                                    </h3>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200">
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">En-tête des factures</span>
                                            <p class="text-xs text-gray-500">Afficher le logo sur les documents</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200">
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Pied de page</span>
                                            <p class="text-xs text-gray-500">Afficher les informations légales</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200">
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Signature numérique</span>
                                            <p class="text-xs text-gray-500">Ajouter une signature aux PDF</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Consignation -->
                <div class="tab-content" id="consignation">
                    <!-- Contenu existant de la consignation -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Tarifs actuels -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-md font-semibold text-gray-900">
                                    <i class="fas fa-list mr-2 text-blue-500"></i>
                                    Tarifs actuels
                                </h3>
                            </div>

                            <div class="space-y-3">
                                @php
                                $tarifs = [
                                'Bouteille 30-33 cl' => $type33->prix_consignation ?? 0,
                                'Bouteille 50-65 cl' => $type65->prix_consignation ?? 0,
                                'Bouteille 100 cl' => $type100->prix_consignation ?? 0,
                                'Cageot' => $type33->prix_cgt ?? 0,
                                ];
                                @endphp
                                @foreach($tarifs as $label => $prix)

                                <div class="price-card p-4 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-700 font-medium">{{ $label }}</span>
                                            <p class="text-gray-500 text-sm">Consignation standard</p>
                                        </div>
                                        <span class="text-md font-bold text-gray-600">{{ number_format($prix, 0, ',', ' ') }} Ar</span>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>

                        <!-- Formulaire de modification -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-md font-semibold text-gray-900">
                                    <i class="fas fa-edit mr-2 text-blue-500"></i>
                                    Modifier les tarifs
                                </h3>
                            </div>

                            <form action="{{ route('parametre.store') }}" method="POST" class="space-y-4 p-6 bg-white shadow-sm border border-gray-100">
                                @csrf
                                @foreach([
                                'Bouteille 30-33 cl' => 'consignation_bouteille_33',
                                'Bouteille 50-65 cl' => 'consignation_bouteille_65',
                                'Bouteille 100 cl' => 'consignation_bouteille_100',
                                'Cageot' => 'consignation_cageot'
                                ] as $label => $name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                                    <div class="input-group flex">
                                        <input type="number" step="0.01" name="{{ $name }}"
                                            class="flex-1 px-4 py-3 text-gray-900 text-sm focus:outline-none">
                                        <span class="bg-gray-50 px-4 py-3 text-gray-700 text-sm font-medium border-l border-gray-200">Ar</span>
                                    </div>
                                </div>
                                @endforeach


                                <button type="submit" onclick="showSuccess()"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200 shadow-md hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab: Utilisateurs -->
                <div class="tab-content" id="utilisateur">
                    <!-- Contenu existant des utilisateurs -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Ajouter utilisateur -->
                        <div class="bg-white shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-md font-semibold text-gray-900">
                                    <i class="fas fa-user-plus mr-2 text-blue-500"></i>
                                    Ajouter un utilisateur
                                </h3>
                            </div>

                            <form action="{{ route('add.user') }}" method="POST" class="space-y-5" autocomplete="off">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                    <input type="text" autocomplete="off" name="name"
                                        class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" autocomplete="off"
                                        name="email"
                                        class="w-full px-4 py-3 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-blue-500 transition-colors"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                                    <div class="input-group flex">
                                        <input type="password" autocomplete="new-password" name="password"
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

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 text-sm font-medium transition-all duration-200 shadow-md hover:shadow-xl">
                                    <i class="fas fa-plus mr-2"></i>Créer l'utilisateur
                                </button>
                            </form>
                        </div>

                        <!-- Liste utilisateurs -->
                        <div class="bg-white shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-8 bg-blue-500"></div>
                                <h3 class="text-md font-semibold text-gray-900">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>
                                    Liste des utilisateurs
                                    <span class="text-blue-600 ml-2">(3)</span>
                                </h3>
                            </div>

                            <div class=" border border-gray-200">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider border-b border-gray-200">Nom</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider border-b border-gray-200">Email</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wider border-b border-gray-200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border-b border-gray-200">
                                                <div class="flex items-center">
                                                    <span class="text-gray-900">{{ $user->name }}</span>
                                                    @if($user->is_admin)
                                                    <span class="ml-2 bg-gray-800 text-white px-2 py-1 text-xs">Admin</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 border-b border-gray-200 text-gray-900">{{ $user->email }}</td>
                                            <td class="px-4 py-2 border-b border-gray-200 text-center">
                                                <div class="relative inline-block">
                                                    <button onclick="toggleUserMenu({{ $user->id }})" class="text-gray-500 hover:text-gray-700 p-1">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div id="user-menu-{{ $user->id }}" class="hidden absolute right-0 mt-1 w-40 bg-white border border-gray-200 shadow-lg z-10">
                                                        <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                                            <i class="fas fa-edit mr-2 text-blue-500"></i>Modifier
                                                        </a>

                                                        <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            <i class="fas fa-trash mr-2 text-red-500"></i>Supprimer
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <script>
                                function toggleUserMenu(userId) {
                                    const menu = document.getElementById('user-menu-' + userId);
                                    // Fermer tous les autres menus utilisateur ouverts
                                    document.querySelectorAll('[id^="user-menu-"]').forEach(otherMenu => {
                                        if (otherMenu.id !== 'user-menu-' + userId) {
                                            otherMenu.classList.add('hidden');
                                        }
                                    });
                                    menu.classList.toggle('hidden');
                                }

                                // Fermer le menu quand on clique ailleurs
                                document.addEventListener('click', function(event) {
                                    if (!event.target.closest('.relative')) {
                                        document.querySelectorAll('[id^="user-menu-"]').forEach(menu => {
                                            menu.classList.add('hidden');
                                        });
                                    }
                                });
                            </script>
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

    function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logoPreview');
        const placeholder = preview.previousElementSibling;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function setupDragAndDrop() {
        const uploadArea = document.querySelector('.upload-area');
        const logoUpload = document.getElementById('logoUpload');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadArea.classList.add('dragover');
        }

        function unhighlight() {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            logoUpload.files = files;

            // Déclencher l'événement change pour afficher l'aperçu
            const event = new Event('change');
            logoUpload.dispatchEvent(event);
        }
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

        // Setup drag and drop pour le logo
        setupDragAndDrop();
    });
</script>
@endsection