@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="bg-white rounded-sm shadow-md overflow-hidden">
        <div class="flex justify-between items-center mb-6">
        <div>
            <ul class="flex border-b mb-4" id="parametresTabs" role="tablist">
                
                <li role="presentation">
                    <a href="{{ route('vente.rendu', ['id' => $commande->id]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('vente.rendu' , ['id' => $commande->id]) ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-large mr-1"></i> article à rendre
                    </a>
                </li>
                 <li role="presentation">
                    <a href="{{ route('article.rendu.historique' , ['id' => $commande->id]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-t-lg border-b-2 
                      {{ request()->routeIs('article.rendu.historique' , ['id' => $commande->id])  ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-gray-300' }}">
                        <i class="fas fa-th-list mr-1"></i> Historiques des retours
                    </a>
                </li>
                
            </ul>
        </div>
        
    </div>
        <!-- Header -->
        <div class="bg-gray-10 px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <h5 class="text-lg font-bold text-dark mb-2 md:mb-0">
                <i class="fas fa-receipt mr-2"></i>ARTICLE - A RENDRE C-{{$commande->id}}
            </h5>
            <div class="flex gap-2">
                <a href="{{route('rendrepdf.download',['id' => $commande->id ])}}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                    <i class="fas fa-print mr-1"></i>Facture
                </a>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i>Retour
                </a>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>

            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- FORMULAIRE PRINCIPAL POUR RENDU MULTIPLE -->
            <form id="multipleForm" method="POST" action="{{ route('article.rendu.all') }}">
                @csrf
                @method('PUT')
                
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-white">ID</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Article</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Statut</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Bouteille rendu</th>
                                <th class="px-6 py-3 text-xs font-medium text-white">Bouteille cassé</th>
                                <th class="px-6 py-3 text-xs font-medium text-white text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($articlerendus as $articlerendu)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $articlerendu->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $articlerendu->vente->article->nom }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($vente->etat === 1)
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Livré</span>
                                   
                                    @endif
                                </td>
                                            
                                <td class="px-6 py-4 text-sm">
                                    {{ $vente->quantite }} Bouteille(s)
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $vente->quantite_casse }} Bouteille(s)
                                </td>
                                <!-- Input pour bouteilles à rendre -->
                              

                                <!-- Input pour casse -->
       

                              
                                <!-- Bouton rendre (unique) -->
                                <td class="px-6 py-4 text-right">
                                   <div class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition duration-150 cursor-pointer">
                                    <i class="fa fa-list" ></i>
                                   </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                                    <p class="text-lg">Aucune donnée disponible</p>
                                </td>
                            </tr> 
                            @endforelse                     
                        </tbody>
                    </table>
                </div>

                <!-- Rendre Multiple -->
                
            </form>
        </div>
    </div>
</div>

