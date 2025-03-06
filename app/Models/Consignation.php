<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignation extends Model
{
    public $timestamps = false;
    protected $tables = 'consignations';
    protected $fillable = [
        'vente_id',
        'prix',
        'etat',
        'date_consignation'
    ];
}
