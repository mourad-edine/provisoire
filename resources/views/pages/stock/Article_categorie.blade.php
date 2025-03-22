@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes par catégorie</h6>
            <button class="btn btn-primary btn-sm">retour</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nom</th>
                            <th>categorie</th>
                            <th>P.Vente</th>
                            <th>P.C</th>
                            <th>quantite</th>
                            <th>image</th>
                            <th>consignation</th>
                            <th>mise à jour</th>
                            <th>date creation</th>
                            <th>Ajouter</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{$article->id }}</td>
                            <td>{{$article->nom}}</td>
                            <td>{{$article->categorie_id}}</td>
                            <td>{{$article->prix_unitaire}} Ar</td>
                            <td>{{$article->prix_conditionne ? $article->prix_conditionne .' Ar' :'pas de prix'}}</td>
                            <td>
                                @php
                                $quotient = intdiv($article->quantite, $article->conditionnement); // Division entière
                                $reste = $article->quantite % $article->conditionnement; // Reste de la division
                                $affichage = $quotient;
                                @endphp

                                @if($quotient > 0)
                                <span class="text-success">{{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}</span>
                                @else
                                <span class="text-danger"> {{ $affichage }} cageot{{ $affichage > 1 ? 's' : '' }}
                                </span>
                                @endif

                                @if($reste > 0)
                                et {{ $reste }} unité{{ $reste > 1 ? 's' : '' }}
                                @endif
                            </td>
                            <td><img src="{{asset('assets/images/bouteille.png')}}" alt="" width="20" height="20"></td>
                            <td>{{$article->prix_consignation ? $article->prix_consignation . ' Ar' : 'pas de prix'}}</td>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a class="ml-3" href="{{route('achat.liste')}}"><i class="fas fa-edit text-secondary"></i></a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-warning">pas encore de donné inséré pour le moment</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
                <div class="d-flex justify-content-start mt-3">
                    {{ $articles->links('pagination::bootstrap-4') }} <!-- Ou 'pagination::bootstrap-5' -->
                </div>
            </div>
        </div>
    </div>

</div>
@endsection