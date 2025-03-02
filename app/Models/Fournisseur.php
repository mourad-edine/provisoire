<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $tables = 'fournisseurs';
    protected $fillable = [
        'nom',
        'numero',
        'reference',

    ];
}
