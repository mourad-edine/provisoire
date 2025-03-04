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
}
