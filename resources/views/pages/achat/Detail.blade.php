@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')

<div class="">

    <!-- Onglets navigation -->
    <ul class="flex border-b border-gray-300 mb-4 space-x-2">
        <li>
            <a href="{{route('achat.commande')}}" class="no-underline">
                <button class="px-4 py-2 text-gray-600 hover:text-blue-500 hover:border-b-2 hover:border-blue-500">
                    <i class="fas fa-user mr-2"></i> Listes par commandes
                </button>
            </a>
        </li>
        <li>
            <a href="{{route('achat.liste')}}" class="no-underline">
                <button class="px-4 py-2 text-blue-600 font-bold border-b-2 border-blue-500">
                    <i class="fas fa-wine-bottle mr-2"></i> Listes achats
                </button>
            </a>
        </li>
        <li>
            <a href="{{route('achat.page')}}" class="no-underline">
                <button class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
                    <i class="fas fa-cart-plus mr-2 text-white"></i> Nouvel achat
                </button>
            </a>
        </li>
    </ul>

    <!-- Informations fournisseur -->
    <div class="bg-white border border-gray-300 rounded-lg shadow mb-4">
        <div class="bg-gray-700 text-white px-4 py-3 rounded-t-lg">
            <h5 class="font-bold text-white">
                <i class="fas fa-user mr-2"></i> INFORMATIONS FOURNISSEUR
            </h5>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p><strong>Nom :</strong> {{ $commande->fournisseur->nom ?? 'N/A' }}</p>
                <p><strong>Prénom :</strong> ------</p>
            </div>
            <div>
                <p><strong>Téléphone :</strong> {{ $commande->client->telephone ?? 'N/A' }}</p>
                <p><strong>Email :</strong> {{ $commande->fournisseur->email ?? 'N/A' }}</p>
            </div>
            <div>
                <p><strong>Adresse :</strong> {{ $commande->client->adresse ?? 'N/A' }}</p>
                <p><strong>Date commande :</strong> {{ $commande->created_at }}</p>
            </div>
        </div>
    </div>

    <!-- Tableau achats -->
    <div class="bg-white shadow border border-gray-300 rounded-lg mb-4">
        <div class="flex justify-between items-center bg-gray-700 px-4 py-3 rounded-t-lg">
            <h5 class="text-white font-bold">ACHAT - DETAILS</h5>
            <div class="flex space-x-3">
                <a href="{{route('pdf.achat' , ['id' => $id])}}" class="text-white">
                    <button class="px-3 py-1 text-sm border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-gray-900 rounded">
                        <i class="fas fa-print mr-2"></i> facture
                    </button>
                </a>
                <a href="{{ url()->previous() }}">
                    <button class="px-3 py-1 text-sm bg-gray-800 text-white rounded hover:bg-gray-900">
                        retour
                    </button>
                </a>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="mb-3 p-3 rounded bg-green-100 text-green-700 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">id</th>
                            <th class="px-4 py-2 border">article</th>
                            <th class="px-4 py-2 border">Prix unité</th>
                            <th class="px-4 py-2 border">Prix / cageot</th>
                            <th class="px-4 py-2 border">commande</th>
                            <th class="px-4 py-2 border">quantite</th>
                            <th class="px-4 py-2 border">état</th>
                            <th class="px-4 py-2 border">total</th>
                            <th class="px-4 py-2 border">date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{$achat['id']}}</td>
                            <td class="px-4 py-2 border">{{$achat['article']}}</td>
                            <td class="px-4 py-2 border">{{$achat['prix_unite']}}</td>
                            <td class="px-4 py-2 border">{{$achat['prix_unite'] * $achat['conditionnement']}}</td>
                            <td class="px-4 py-2 border">C-{{$achat['numero_commande']}}</td>
                            <td class="px-4 py-2 border">{{$achat['quantite']}} - {{ $achat['type_achat']}}</td>
                            <td class="px-4 py-2 border"><span class="text-green-600">payé</span></td>
                            <td class="px-4 py-2 border font-bold">{{ $achat['prix']  .' Ar' }}</td>
                            <td class="px-4 py-2 border">{{$achat['created_at']}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-3 text-center text-yellow-700 bg-yellow-50 border border-yellow-200">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Pas de donnée trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="flex justify-end items-center mt-4 border-t pt-3">
                <p class="mr-2 font-medium text-gray-700">Total :</p>
                <p class="font-bold text-xl text-gray-900">{{$total}} Ar</p>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $achats->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
