@extends('layouts.AdminLayout')
@section('title', 'Statistiques des Sorties')
@section('content')

<div class="max-w-screen-4xl mx-auto px-4 py-6">
    <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
        <li class="mr-2" role="presentation">
            <a href="{{ route('stock.liste') }}"
                class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                <i class="fas fa-warehouse mr-1"></i> Listes globales
            </a>
        </li>
        <li class="mr-2" role="presentation">
            <a href="{{ route('stock.faible.liste') }}"
                class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.faible.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                <i class="fas fa-exclamation-triangle mr-1"></i> Stocks faibles
            </a>
        </li>
        <li role="presentation">
            <a href="{{ route('stock.categorie.liste') }}"
                class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('stock.categorie.liste') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                <i class="fas fa-th-large mr-1"></i> Catégories
            </a>
        </li>
        <li role="presentation">
            <a href="{{ route('sortie.stat') }}"
                class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('sortie.stat') ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                <i class="fas fa-th-recycle mr-1"></i> Mouvement stock
            </a>
        </li>
    </ul>
    <div class="p-4 bg-gray-50 rounded-t-lg shadow-sm">
        <form method="GET" action="#" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Nom de l'article</label>
                <input type="text" id="search" name="search" value=""
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date début</label>
                <input type="date" id="date_debut" name="date_debut" value=""
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date fin</label>
                <input type="date" id="date_fin" name="date_fin" value=""
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="tri" class="block text-sm font-medium text-gray-700">Trier par date</label>
                <select name="tri" id="tri"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="desc" selected>Décroissant</option>
                    <option value="asc">Croissant</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm">
                    <i class="fas fa-search mr-2"></i>Rechercher
                </button>
            </div>
        </form>
    </div>
    @foreach($articles as $article)
    @php
    // Collection d'historique pour faciliter les totaux
    $hist = $article->historiqueventes;
    $total_entre_qte = $hist->where('type_historique', 1)->sum('quantite_enleve');
    $total_entre_val = $hist->where('type_historique', 1)->sum('total');
    $total_sortie_qte = $hist->where('type_historique', 0)->sum('quantite_enleve');
    $total_sortie_val = $hist->where('type_historique', 0)->sum('total');
    @endphp

    <div class="border border-gray-300 rounded shadow my-2">

        <!-- Header cliquable -->
        <div class="border border-gray-200 rounded-lg shadow-sm overflow-hidden my-3 bg-white">
            <table class="w-full border-collapse">
                <!-- Ligne d'en-tête cliquable -->
                <tr class="cursor-pointer transition-all duration-300 hover:bg-slate-50 toggle-header group border-b border-gray-100"
                    role="button" aria-expanded="false">

                    <!-- Article -->
                    <td class="px-4 py-3 w-3/12">
                        <div class="font-semibold text-slate-800 group-hover:text-slate-900 text-sm">
                            {{ $article->nom }}
                        </div>
                    </td>

                    <!-- Stock -->
                    <td class="px-4 py-3 w-2/12">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Stock</span>
                            <span class="font-mono text-slate-700 text-sm">
                                {{ intdiv($article->quantite, $article->conditionnement) }}p
                                @php $r0 = $article->quantite % $article->conditionnement; @endphp
                                @if($r0 > 0)
                                + {{ $r0 }}u
                                @endif
                            </span>
                        </div>
                    </td>

                    <!-- Dernière mise à jour -->
                    <td class="px-4 py-3 w-2/12">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Mise à jour</span>
                            <span class="text-slate-600 text-xs">
                                {{ \Carbon\Carbon::parse($article->updated_at)->locale('fr')->isoFormat('DD/MM HH:mm') }}
                            </span>
                        </div>
                    </td>

                    <!-- Prix -->
                    <td class="px-4 py-3 w-2/12">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Prix unité</span>
                            <span class="text-green-600 font-medium text-sm">
                                {{ number_format($article->prix_vente, 0, ',', ' ') }} Ar
                            </span>
                        </div>
                    </td>

                    <!-- Valeur -->
                    <td class="px-4 py-3 w-2/12">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Valeur stock</span>
                            <span class="text-blue-600 font-medium text-sm">
                                {{ number_format($article->quantite * $article->prix_vente, 0, ',', ' ') }} Ar
                            </span>
                        </div>
                    </td>

                    <!-- Action -->
                    <td class="px-4 py-3 w-1/12 text-right">
                        <div class="transform transition-transform duration-300 toggle-icon">
                            <i class="fas fa-chevron-down text-slate-400 group-hover:text-amber-500 text-xs"></i>
                        </div>
                    </td>
                </tr>

                <!-- Contenu déroulant -->
                <tr class="hidden toggle-content">
                    <td colspan="6" class="p-0">
                        <div class="border-t border-gray-100">
                            <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Type</th>
                                        <th class="px-4 py-2 text-left">Quantité Initiale</th>
                                        <th class="px-4 py-2 text-left">Mouvement</th>
                                        <th class="px-4 py-2 text-left">Quantité Finale</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Valeur Transaction</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($hist as $historique)
                                    <tr>
                                        <td class="px-4 py-2 align-top">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                {{ $historique->type_historique == 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                <i class="bi {{ $historique->type_historique == 0 ? 'bi-box-arrow-left' : 'bi-box-arrow-in-right' }}"></i>
                                                {{ $historique->type_historique == 0 ? 'sortie' : 'entrée' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-2 align-top">
                                            @php
                                            $qi = intdiv($article->quantite, $article->conditionnement);
                                            $ri = $article->quantite % $article->conditionnement;
                                            @endphp
                                            {{ $qi }} cageot/pack{{ $qi > 1 ? 's' : '' }}
                                            @if($ri > 0)
                                            et {{ $ri }} unité{{ $ri > 1 ? 's' : '' }}
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 align-top {{ $historique->type_historique == 0 ? 'text-red-600' : 'text-green-600' }}">
                                            @php
                                            $qen = intdiv($historique->quantite_enleve, $article->conditionnement);
                                            $ren = $historique->quantite_enleve % $article->conditionnement;
                                            @endphp
                                            {{ $qen }} cageot/pack{{ $qen > 1 ? 's' : '' }}
                                            @if($ren > 0)
                                            et {{ $ren }} unité{{ $ren > 1 ? 's' : '' }}
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 align-top">
                                            @php
                                            $nouvelle_quantite = $historique->quantite_finale;
                                            $qf = intdiv($nouvelle_quantite, $article->conditionnement);
                                            $rf = $nouvelle_quantite % $article->conditionnement;
                                            @endphp
                                            {{ $qf }} cageot/pack{{ $qf > 1 ? 's' : '' }}
                                            @if($rf > 0)
                                            et {{ $rf }} unité{{ $rf > 1 ? 's' : '' }}
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 align-top text-gray-600">
                                            <i class="bi bi-calendar"></i>
                                            {{ \Carbon\Carbon::parse($historique->created_at)->locale('fr')->isoFormat('LLL') }}
                                        </td>

                                        <td class="px-4 py-2 align-top {{ $historique->type_historique == 0 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $historique->type_historique == 0 ? '+' : '-' }}{{ number_format($historique->total, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>
                                    @endforeach

                                    {{-- Totaux Entrées --}}
                                    @php
                                    $q_entre_pack = intdiv($total_entre_qte, $article->conditionnement);
                                    $r_entre_pack = $total_entre_qte % $article->conditionnement;

                                    $q_sortie_pack = intdiv($total_sortie_qte, $article->conditionnement);
                                    $r_sortie_pack = $total_sortie_qte % $article->conditionnement;
                                    @endphp

                                    <tr class="bg-green-50 font-semibold">
                                        <td class="px-4 py-2"><i class="bi bi-plus-circle"></i> Total Entrées</td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2">
                                            {{ $q_entre_pack }} cageot/pack{{ $q_entre_pack > 1 ? 's' : '' }}
                                            @if($r_entre_pack > 0) et {{ $r_entre_pack }} unité{{ $r_entre_pack > 1 ? 's' : '' }} @endif
                                        </td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2 text-green-600 font-bold">
                                            {{ number_format($total_entre_val, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>

                                    <tr class="bg-red-50 font-semibold">
                                        <td class="px-4 py-2"><i class="bi bi-dash-circle"></i> Total Sorties</td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2">
                                            {{ $q_sortie_pack }} cageot/pack{{ $q_sortie_pack > 1 ? 's' : '' }}
                                            @if($r_sortie_pack > 0) et {{ $r_sortie_pack }} unité{{ $r_sortie_pack > 1 ? 's' : '' }} @endif
                                        </td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2 text-red-600 font-bold">
                                            {{ '+' . number_format($total_sortie_val, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Table masquée/affichée -->
        <div class="overflow-x-auto bg-white hidden toggle-content">
            <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Quantité Initiale</th>
                        <th class="px-4 py-2 text-left">Quantité Ajoutée/Retirée</th>
                        <th class="px-4 py-2 text-left">Quantité Finale</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Valeur Transaction</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($hist as $historique)
                    <tr>
                        <td class="px-4 py-2 align-top">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                {{ $historique->type_historique == 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                <i class="bi {{ $historique->type_historique == 0 ? 'bi-box-arrow-left' : 'bi-box-arrow-in-right' }}"></i>
                                {{ $historique->type_historique == 0 ? 'sortie' : 'entrée' }}
                            </span>
                        </td>

                        <td class="px-4 py-2 align-top">
                            @php
                            $qi = intdiv($article->quantite, $article->conditionnement);
                            $ri = $article->quantite % $article->conditionnement;
                            @endphp
                            {{ $qi }} cageot/pack{{ $qi > 1 ? 's' : '' }}
                            @if($ri > 0)
                            et {{ $ri }} unité{{ $ri > 1 ? 's' : '' }}
                            @endif
                        </td>

                        <td class="px-4 py-2 align-top {{ $historique->type_historique == 0 ? 'text-red-600' : 'text-green-600' }}">
                            @php
                            $qen = intdiv($historique->quantite_enleve, $article->conditionnement);
                            $ren = $historique->quantite_enleve % $article->conditionnement;
                            @endphp
                            {{ $qen }} cageot/pack{{ $qen > 1 ? 's' : '' }}
                            @if($ren > 0)
                            et {{ $ren }} unité{{ $ren > 1 ? 's' : '' }}
                            @endif
                        </td>

                        <td class="px-4 py-2 align-top">
                            @php
                            $nouvelle_quantite = $historique->quantite_finale;
                            $qf = intdiv($nouvelle_quantite, $article->conditionnement);
                            $rf = $nouvelle_quantite % $article->conditionnement;
                            @endphp
                            {{ $qf }} cageot/pack{{ $qf > 1 ? 's' : '' }}
                            @if($rf > 0)
                            et {{ $rf }} unité{{ $rf > 1 ? 's' : '' }}
                            @endif
                        </td>

                        <td class="px-4 py-2 align-top text-gray-600">
                            <i class="bi bi-calendar"></i>
                            {{ \Carbon\Carbon::parse($historique->created_at)->locale('fr')->isoFormat('LLL') }}
                        </td>

                        <td class="px-4 py-2 align-top {{ $historique->type_historique == 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $historique->type_historique == 0 ? '+' : '-' }}{{ number_format($historique->total, 0, ',', ' ') }} Ar
                        </td>
                    </tr>
                    @endforeach

                    {{-- Totaux Entrées --}}
                    @php
                    $q_entre_pack = intdiv($total_entre_qte, $article->conditionnement);
                    $r_entre_pack = $total_entre_qte % $article->conditionnement;

                    $q_sortie_pack = intdiv($total_sortie_qte, $article->conditionnement);
                    $r_sortie_pack = $total_sortie_qte % $article->conditionnement;
                    @endphp

                    <tr class="bg-green-50 font-semibold">
                        <td class="px-4 py-2"><i class="bi bi-plus-circle"></i> Total Entrées</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2">
                            {{ $q_entre_pack }} cageot/pack{{ $q_entre_pack > 1 ? 's' : '' }}
                            @if($r_entre_pack > 0) et {{ $r_entre_pack }} unité{{ $r_entre_pack > 1 ? 's' : '' }} @endif
                        </td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2 text-green-600 font-bold">
                            {{ number_format($total_entre_val, 0, ',', ' ') }} Ar
                        </td>
                    </tr>

                    <tr class="bg-red-50 font-semibold">
                        <td class="px-4 py-2"><i class="bi bi-dash-circle"></i> Total Sorties</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2">
                            {{ $q_sortie_pack }} cageot/pack{{ $q_sortie_pack > 1 ? 's' : '' }}
                            @if($r_sortie_pack > 0) et {{ $r_sortie_pack }} unité{{ $r_sortie_pack > 1 ? 's' : '' }} @endif
                        </td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2 text-red-600 font-bold">
                            {{ '+' . number_format($total_sortie_val, 0, ',', ' ') }} Ar
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</div>

<!-- Script toggle (Vanilla JS) -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".toggle-header").forEach(header => {
            header.addEventListener("click", () => {
                const content = header.parentElement.querySelector(".toggle-content");
                const icon = header.querySelector(".toggle-icon");
                const expanded = header.getAttribute('aria-expanded') === 'true';

                // Toggle affichage
                content.classList.toggle("hidden");

                // Toggle icône
                if (icon) {
                    icon.classList.toggle("bi-chevron-down");
                    icon.classList.toggle("bi-chevron-up");
                }

                // Mettre à jour aria-expanded pour accessibilité
                header.setAttribute('aria-expanded', (!expanded).toString());
            });
        });
    });
</script>

@endsection