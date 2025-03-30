<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    public $timestamps = false;
    protected $tables = 'fournisseurs';
    protected $fillable = [
        'nom',
        'numero',
        'reference',

    ];
    public function commandes(){
        return $this->hasMany(Commande::class , 'fournisseur_id');
    }
}
