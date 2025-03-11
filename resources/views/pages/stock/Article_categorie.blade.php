@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">liste des articles
        .</p>

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
                            <th>P.U</th>
                            <th>P.C</th>
                            <th>quantite</th>
                            <th>image</th>
                            <th>consignation</th>
                            <th>mise à jour</th>
                            <th>date creation</th>
                            <th>options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{$article->id }}</td>
                            <td>{{$article->nom}}</td>
                            <td>{{$article->categorie_id}}</td>
                            <td>{{$article->prix_unitaire}} Ar</td>
                            <td>{{$article->prix_conditionne  ? $article->prix_conditionne :'pas de prix'}}</td>
                            <td>{{$article->quantite}}</td>
                            <td><img src="{{asset('assets/images/bouteille.jpg')}}" alt="" width="40" height="40"></td>
                            <td>{{$article->prix_consignation ? $article->prix_consignation . ' Ar' : 'pas de prix'}}</td>
                            <td>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->updated_at)->format('Y-m-d') }}</td>
                            <td>
                                <!-- Icônes d'options -->
                                <a href="#"><i class="fas fa-eye"></i></a>
                                <a href="#"><i class="fas fa-edit"></i></a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none; border:none; color:red;"><i class="fas fa-trash-alt"></i></button>
                                </form>
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