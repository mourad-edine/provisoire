@extends('layouts.AdminLayout')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-6 text-sm">
    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @php
        $cards = [
            [
                'title' => 'Nouvelle vente',
                'value' => 'Commencer',
                'icon' => 'fa-cash-register',
                'color' => 'bg-green-500',
                'text' => 'text-white',
                'link' => route('vente.page'),
                'action' => true
            ],
            [
                'title' => 'Approvisionnement',
                'value' => 'Acheter',
                'icon' => 'fa-pallet',
                'color' => 'bg-blue-500',
                'text' => 'text-white',
                'link' => route('achat.page'),
                'action' => true
            ],
            [
    'title' => 'Statistiques',
    'value' => 'statistique',
    'icon' => 'fa-chart-bar', // Icône plus appropriée
    'color' => 'bg-purple-500',
    'text' => 'text-white',
    'link' => route('stat'),
    'action' => true
]
        ];
        @endphp

        @foreach ($cards as $card)
        <div>
            @if(isset($card['link']))
            <a href="{{ $card['link'] }}" class="no-underline block group">
            @endif
                <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full overflow-hidden transition-transform duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                    <div class="{{ $card['color'] }} {{ $card['text'] }} p-4">
                        <div class="flex items-center">
                            <div class="rounded-full p-2 mr-3 bg-white bg-opacity-30">
                                <i class="fas {{ $card['icon'] }}"></i>
                            </div>
                            <div class="flex-grow">
                                <h6 class="mb-1 text-sm font-medium">{{ $card['title'] }}</h6>
                                <h5 class="mb-0 font-bold flex items-center">
                                    {{ $card['value'] }}
                                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @if(isset($card['link']))
            </a>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Tableau des articles -->
    <div class="mt-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex flex-wrap justify-between items-center bg-slate-100 p-4">
                <!-- Barre de recherche avancée -->
                <form action="{{ route('page.accueil') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <!-- Champ de recherche principal -->
                    <div class="relative">
                        <input type="text" name="search" placeholder="Rechercher..." value="{{ old('search', request('search')) }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Tri des résultats -->
                    <div class="relative">
                        <button type="button" id="sortDropdown" class="flex items-center px-3 py-2 border border-slate-300 rounded-md text-sm bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-sort mr-1"></i> Trier par
                        </button>
                        <div id="sortDropdownMenu" class="absolute hidden z-10 mt-1 w-48 bg-white border border-slate-200 rounded-md shadow-lg">
                            <button type="submit" name="sort" value="nom_asc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Nom (A-Z)</button>
                            <button type="submit" name="sort" value="nom_desc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Nom (Z-A)</button>
                            <button type="submit" name="sort" value="prix_asc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Prix (Croissant)</button>
                            <button type="submit" name="sort" value="prix_desc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Prix (Décroissant)</button>
                            <button type="submit" name="sort" value="stock_asc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Stock (Croissant)</button>
                            <button type="submit" name="sort" value="stock_desc" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-100">Stock (Décroissant)</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-4">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-center border-separate border-spacing-0">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">ID</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">Nom</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">Catégorie</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">P. Vente Unité</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">P. Vente Cageot/Pack</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">P. Détails</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">Quantité</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">Date</th>
                                <th class="px-4 py-2 text-xs font-bold uppercase border-b-2 border-slate-300">Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="openModal('editArticleModal{{ $article['id'] }}')">
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ $article['id'] }}</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ \Illuminate\Support\Str::limit($article['nom'], 15) }}</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ $article['categorie'] }}</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ number_format($article['prix_unitaire'], 2) }} Ar</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ number_format($article['prix_conditionne'], 2) }} Ar</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">{{ number_format($article['prix_gros'], 2) }} Ar</td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">
                                    @php
                                    $quotient = intdiv($article['quantite'], $article['conditionnement']);
                                    $reste = $article['quantite'] % $article['conditionnement'];
                                    @endphp
                                    {{ $quotient }} cageot/pack{{ $quotient > 1 ? 's' : '' }}
                                    @if($reste > 0)
                                    et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b border-slate-200 text-slate-600">
                                    @if (!empty($article['created_at']))
                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $article['created_at'])->format('Y-m-d') }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b border-slate-200">
                                    <button onclick="openModal('editArticleModal{{ $article['id'] }}')" class="text-slate-600 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de suppression -->
                           
                            <!-- Modal de modification -->
                            <div style="z-index: 20 !important;" id="editArticleModal{{ $article['id'] }}" class="fixed inset-0 bg-slate-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                                <div class="relative top-20 mx-auto p-4 border w-full max-w-2xl bg-white rounded-lg shadow-lg">
                                   
                                    <div class="p-4">
                                        <form action="{{ route('articles.update') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="nom" class="block text-sm font-medium text-slate-700">Nom</label>
                                                <input value="{{ $article['nom'] }}" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 text-sm" id="nom" name="nom" readonly>
                                                <input type="hidden" name="id" value="{{ $article['id'] }}">
                                            </div>

                                            <div class="mb-4">
                                                <label for="categorie" class="block text-sm font-medium text-slate-700">Catégorie</label>
                                                <select class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm searchable-select" id="categorie" name="categorie_id">
                                                    <option value="">----</option>
                                                    @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->id }}" {{ $categorie->id == $article['categorie_id'] ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label for="conditionnement" class="block text-sm font-medium text-slate-700">Conditionnement</label>
                                                <select class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 text-sm" id="conditionnement" name="conditionnement" readonly>
                                                    <option value="{{ $article['conditionnement'] }}">{{ $article['conditionnement'] }}</option>
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div class="flex items-center">
                                                    <input type="radio" class="h-4 w-4 text-blue-600" id="condi_cgt_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="cageot" {{ ($article['prix_consignation'] > 0 && $article['prix_cgt'] > 0) ? 'checked' : '' }}>
                                                    <label for="condi_cgt_{{ $article['id'] }}" class="ml-2 text-sm">Cageot</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="radio" class="h-4 w-4 text-blue-600" id="condi_pack_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="pack" {{ $article['prix_consignation'] == 0 ? 'checked' : '' }}>
                                                    <label for="condi_pack_{{ $article['id'] }}" class="ml-2 text-sm">Pack</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="radio" class="h-4 w-4 text-blue-600 condi_jet_radio" data-id="{{ $article['id'] }}" id="condi_jet_{{ $article['id'] }}" name="choix_{{ $article['id'] }}" value="jet" {{ $article['prix_consignation'] > 0 && ($article['prix_cgt'] == 0 || $article['prix_cgt'] == null) ? 'checked' : '' }}>
                                                    <label for="condi_jet_{{ $article['id'] }}" class="ml-2 text-sm">consigné/Emb jetable</label>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="prix_consignation" class="block text-sm font-medium text-slate-700">Prix consignation</label>
                                                    <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 text-sm" value="{{ $article['prix_consignation'] ?? '' }}" name="prix_consignation" readonly>
                                                </div>
                                                <div>
                                                    <label for="diff_{{ $article['id'] }}" class="block text-sm font-medium text-slate-700">Nouveau prix consignation</label>
                                                    <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="diff_{{ $article['id'] }}" name="diff_{{ $article['id'] }}">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="prix_achat" class="block text-sm font-medium text-slate-700">Prix d'achat unité</label>
                                                    <input value="{{ $article['prix_achat'] }}" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 text-sm" id="prix_achat" name="prix_achat" readonly>
                                                </div>
                                                <div>
                                                    <label for="prix_unitaire" class="block text-sm font-medium text-slate-700">Prix de gros unité</label>
                                                    <input value="{{ $article['prix_unitaire'] }}" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="prix_unitaire" name="prix_unitaire" required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="prix_gros" class="block text-sm font-medium text-slate-700">Prix détails unité</label>
                                                    <input value="{{ $article['prix_gros'] }}" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="prix_gros" name="prix_gros" step="0.01">
                                                </div>
                                                <div>
                                                    <label for="prix_conditionne" class="block text-sm font-medium text-slate-700">Prix de gros cageot/pack <span class="text-red-500">*</span></label>
                                                    <input value="{{ $article['prix_conditionne'] }}" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="prix_conditionne" name="prix_conditionne" step="0.01">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="quantite" class="block text-sm font-medium text-slate-700">Quantité en cageot/pack disponible</label>
                                                    <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="quantite" name="quantite" step="0.01" value="{{ intdiv($article['quantite'], $article['conditionnement']) }}">
                                                </div>
                                                <div>
                                                    <label for="quantite_unite" class="block text-sm font-medium text-slate-700">Quantité en unité disponible</label>
                                                    <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm" id="quantite_unite" name="quantite_unite" step="0.01" value="{{ $article['quantite'] % $article['conditionnement'] }}">
                                                </div>
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" onclick="closeModal('editArticleModal{{ $article['id'] }}')" class="bg-slate-500 hover:bg-slate-600 text-white px-3 py-1 rounded text-sm">
                                                    Fermer
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="9" class="py-4">
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Pas de donnée trouvé
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $articles->appends(['search' => request('search')])->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique des ventes -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-4">
        <!-- Meilleures Ventes -->
        <div>
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="border-b border-slate-200 p-4">
                    <h6 class="text-sm font-bold"><i class="fas fa-trophy mr-2 text-yellow-500"></i> Meilleures ventes</h6>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold uppercase">Produit</th>
                                    <th class="px-4 py-2 text-right text-xs font-bold uppercase">Ventes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($meilleur as $meilleu)
                                <tr class="border-t border-b border-slate-200 hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-slate-800">{{ $meilleu->nom }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-blue-600">
                                        {{ number_format($meilleu->ventes_count, 0, ',', ' ') }}
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-t border-b border-slate-200">
                                    <td colspan="2" class="text-center py-4 text-slate-500">
                                        <i class="fas fa-info-circle mr-2"></i>Aucune donnée de vente disponible
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($meilleur) > 0)
                <div class="bg-white p-3 text-slate-500 text-xs">
                    <i class="fas fa-clock mr-1"></i> Mis à jour à {{ now()->format('H:i') }}
                </div>
                @endif
            </div>
        </div>

        <!-- Stocks Faibles -->
        <div>
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="border-b border-slate-200 p-4">
                    <h6 class="text-sm font-bold"><i class="fas fa-exclamation-triangle mr-2 text-red-500"></i> Stocks faibles</h6>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold uppercase">Produit</th>
                                    <th class="px-4 py-2 text-right text-xs font-bold uppercase">Stock</th>
                                    <th class="px-4 py-2 text-right text-xs font-bold uppercase">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faible as $faib)
                                <tr class="border-t border-b border-slate-200 hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="w-9 h-9 rounded-full mr-3 flex items-center justify-center {{ $faib->quantite < 5 ? 'bg-red-100' : ($faib->quantite < 10 ? 'bg-yellow-100' : 'bg-slate-100') }}">
                                                <i class="fas fa-box-open {{ $faib->quantite < 5 ? 'text-red-500' : ($faib->quantite < 10 ? 'text-yellow-500' : 'text-slate-500') }}"></i>
                                            </div>
                                            <span class="font-medium text-slate-800">{{ $faib->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold {{ $faib->quantite < 5 ? 'text-red-500' : ($faib->quantite < 10 ? 'text-yellow-500' : 'text-slate-500') }}">
                                        {{ number_format($faib->quantite, 0, ',', ' ') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if($faib->quantite < 5)
                                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">URGENT</span>
                                        @elseif($faib->quantite < 10)
                                        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">ALERTE</span>
                                        @else
                                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold">NORMAL</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-t border-b border-slate-200">
                                    <td colspan="3" class="text-center py-4 text-slate-500">
                                        <i class="fas fa-check-circle mr-2 text-green-500"></i>Tous les stocks sont suffisants
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($faible) > 0)
                <div class="bg-white p-3 flex justify-between items-center">
                    <span class="text-slate-500 text-xs"><i class="fas fa-clock mr-1"></i> Dernière mise à jour</span>
                    <a href="{{ route('achat.page') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        <i class="fas fa-plus mr-1"></i>Approvisionner
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>



<!-- Script pour gérer les modals et le dropdown -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Gestion du dropdown de tri
        const sortButton = document.getElementById('sortDropdown');
        const sortMenu = document.getElementById('sortDropdownMenu');
        sortButton.addEventListener('click', function () {
            sortMenu.classList.toggle('hidden');
        });

        // Fermer le dropdown si on clique à l'extérieur
        document.addEventListener('click', function (event) {
            if (!sortButton.contains(event.target) && !sortMenu.contains(event.target)) {
                sortMenu.classList.add('hidden');
            }
        });

        // Gestion des modals (clic à l'extérieur pour fermer)
        document.querySelectorAll('.fixed.inset-0').forEach(modal => {
            modal.addEventListener('click', function (event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection