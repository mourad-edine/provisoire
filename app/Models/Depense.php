<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $table = 'depenses';
    protected $fillable = [
        'categorie',
        'description',
        'montant',
        'quantite',
        'mode_paye',
    ];
}
