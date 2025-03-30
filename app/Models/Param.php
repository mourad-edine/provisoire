<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $tables = 'params';
    protected $fillable = [
        'type_btl',
        'prix_consignation',
    ];
}
