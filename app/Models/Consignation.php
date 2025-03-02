<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignation extends Model
{
    protected $tables = 'consignations';
    protected $fillable = [
        'vente_achat_id',
        'prix',
        'etat',
        'date_consignation'
    ];
}
