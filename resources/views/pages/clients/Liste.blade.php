@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Ajouter votre client
        .</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listes catégorie</h6>
            <button class="btn btn-primary btn-sm">Ajouter catégorie</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nom</th>
                            <th>numero</th>
                            <th>reference</th>
                            <th>date creation</th>
                            <th>options</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>nom</th>
                            <th>numero</th>
                            <th>reference</th>
                            <th>date creation</th>
                            <th>options</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($clients as $client)

                        <tr>
                            <td>{{$client->id}}</td>
                            <td>{{$client->nom}}
                            <td>{{$client->numero ? $client->numero  :'pas de numero'}}
                            <td>{{$client->reference ? $client->reference  :'pas de reference'}}
                            <td>{{$client->date_entre}}
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
            </div>
        </div>
    </div>

</div>
@endsection