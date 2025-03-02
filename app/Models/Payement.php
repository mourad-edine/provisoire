<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    protected $tables = 'payements';
    protected $fillable = [
        'commande_id',
        'mode_paye',
        'somme',
    ];
}
