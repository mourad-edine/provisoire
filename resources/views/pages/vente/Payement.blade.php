@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Navigation Tabs -->
    <!-- <div class="border-b border-gray-200 mb-6">
        <nav class="flex flex-wrap -mb-px space-x-2 md:space-x-8">
            <a href="{{ route('commande.liste.vente') }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-list-alt mr-2"></i> Listes par commandes
            </a>
            <a href="{{ route('commande.liste.vente.detail', ['id' => $commande->id]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Détails commande
            </a>
            <a href="{{ route('paiment.boissons' ,['id' => $commande->id ]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-history mr-2"></i> Historique des paiements
            </a>
            @if($exist == true)
            <a href="{{ route('vente.rendu' ,['id' => $commande->id ]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-list mr-2"></i> Article à rendre
            </a>
            @endif
            @if($commande->etat_client == 2)
            <a href="{{ route('rendre.boissons',['id' => $commande->id ]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Compte rendu
            </a>
            @endif
            @if($commande->etat_commande == 'non payé' && $commande->etat_client != 2)
            <a href="{{ route('pay.index', ['id' => $commande->id]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Payment
            </a>
            @endif
            <a href="{{ route('reglement.index', ['id' => $commande->id]) }}" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Déconsignation
            </a>
            <a href="{{route('vente.page')}}" class="py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 border-blue-500 flex items-center">
                <i class="fas fa-cart-plus mr-2"></i> Nouvelle vente
            </a>
        </nav>
    </div> -->

    <!-- Header Card -->
    <div class="bg-gray-10 rounded-t-lg px-6 py-4 flex flex-col md:flex-row justify-between items-center mb-0 border-b-2 border-gray-300">
        <h5 class="text-lg font-semibold text-dark mb-2 md:mb-0">
            <i class="fas fa-receipt mr-2"></i>VENTE - PAYEMENTS
        </h5>
        <div class="flex gap-2">
            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                <i class="fas fa-print mr-1"></i> Facture
            </a>
            <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium transition duration-150 flex items-center">
                <i class="fas fa-arrow-left mr-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-b-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Facture</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Type opération</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Méthode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($payements as $payement)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$payement->id}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">F-{{$payement->id}}-{{$commande->id}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{optional($commande->client)->nom ? optional($commande->client)->nom : 'client occasionel'}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">{{$payement->somme}} Ar</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$payement->created_at->format('d/m/y')}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$payement->operation}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{$payement->mode_paye}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-red-600 hover:text-red-900 p-1 rounded transition duration-150">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-center justify-center text-yellow-700">
                                        <i class="fas fa-exclamation-triangle mr-2 text-lg"></i>
                                        <span class="font-medium">Pas de paiement trouvé</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payements->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="bg-white px-4 py-3 border border-gray-200 rounded-lg">
                    {{ $payements->links('pagination::tailwind') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .payment-card {
        transition: transform 0.2s;
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

@endsection