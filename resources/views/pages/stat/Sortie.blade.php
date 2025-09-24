@extends('layouts.AdminLayout')
@section('title', 'Statistiques des Sorties')
@section('content')

<div class="space-y-4">
    <div class="p-4 bg-gray-50 rounded-t-lg shadow-sm">
        <form method="GET" action="#" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Nom | Numéro commande</label>
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

    <div class="border border-gray-300 rounded shadow">

        <!-- Header cliquable -->
       <div class="flex justify-between items-center cursor-pointer transition-all duration-300 
            bg-slate-50 hover:bg-white border border-slate-200 hover:border-slate-300
            px-5 py-3 toggle-header group"
     role="button" aria-expanded="false">
    
    <div class="flex items-center gap-4">
        <!-- Indicateur visuel -->
      
        
        <div class="space-y-1">
            <!-- Nom de l'article -->
            <div class="text-base font-semibold text-slate-800 group-hover:text-slate-900">
                {{ $article->nom }}
            </div>
            
            <!-- Stock formaté -->
            <div class="text-sm text-slate-600">
                <span class="font-mono bg-slate-100 px-2 py-0.5 rounded">
                    {{ intdiv($article->quantite, $article->conditionnement) }} pack(s)
                </span>
                @php $r0 = $article->quantite % $article->conditionnement; @endphp
                @if($r0 > 0)
                <span class="mx-2 text-slate-400">•</span>
                <span class="font-mono bg-slate-100 px-2 py-0.5 rounded">
                    {{ $r0 }} unité(s)
                </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Indicateur simple -->
    <div class="transform transition-transform duration-300 toggle-icon group-hover:translate-y-0.5">
        <i class="fas fa-chevron-down text-slate-400 group-hover:text-amber-500 text-sm"></i>
    </div>
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