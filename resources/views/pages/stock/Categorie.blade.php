@extends('layouts.AdminLayout')

@section('title', 'Accueil')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">categories</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> retour</a>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
       @forelse($categories as $categorie)
       <div class="col-xl-3 col-md-6 mb-4">
            <a style="cursor: pointer;" href="{{ route('stock.liste.id', ['id' => $categorie->id]) }}">

            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{$categorie->nom}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">nombre d'article - <span class="text-warning">{{$categorie->articles_count}}</span></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
       @empty
       <div class="col-xl-3 col-md-6 mb-4">
                <p>pas encore de donnée !</p>
        </div>
       @endforelse


        <!-- Earnings (Monthly) Card Example -->
       
    <!-- Content Row -->

   

    <!-- Content Row -->
  

</div>

@endsection