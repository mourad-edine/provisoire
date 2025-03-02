<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function show(){
        //dd(Client::all()->toArray());
        return view('pages.clients.Liste' ,[
            'clients' => Client::all()
        ]);
    }
}
