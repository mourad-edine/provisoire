<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{

    public $timestamps = false;
    protected $tables = 'commandes';
    protected $fillable = [
        'user_id',
        'client_id',
        'fournisseur_id',
        'etat_client',
        'etat_commande',
        'numero',
        'commande_id',
        'disposition'

    ];
    public function achats(){
        return $this->hasMany(Achat::class , 'commande_id');
    }

    public function ventes(){
        return $this->hasMany(Vente::class , 'commande_id');
    }

    public function conditionnement(){
        return $this->hasOne(Conditionnement::class , 'commande_id');
    }

    public function client(){
        return $this->belongsTo(Client::class ,  'client_id');
    }
    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class ,  'fournisseur_id');
    }
    public function payements(){
        return $this->hasMany(Payement::class , 'commande_id');
    }
}
