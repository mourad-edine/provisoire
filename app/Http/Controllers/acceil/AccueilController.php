<?php

namespace App\Http\Controllers\acceil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(){
        return view('pages.Dashboard');
    }

    public function dash(){
        return view('pages.Accueil');
    }
}
