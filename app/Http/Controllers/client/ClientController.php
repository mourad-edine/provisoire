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
            'clients' => Client::paginate(6)
        ]);
    }

    public function store(Request $request){
        if ($request) {
            $tab = [
                'nom' => $request->nom,
                'numero' => $request->numero,
                'reference' =>$request->reference ? $request->reference : null,
            ];

            $insert = Client::create($tab);
            if ($insert) {
                return redirect()->route('client.liste')->withSuccess('Success', 'success');
            }
        }
    }

    public function performance(){
        return view('pages.clients.Performance');
    }
}
