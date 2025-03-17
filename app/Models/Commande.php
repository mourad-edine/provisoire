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
}
