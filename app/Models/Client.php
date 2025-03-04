<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $tables = 'clients';
    protected $fillable = [
        'nom',
        'numero',
        'reference',
        'created_at',
        'updated_at'

    ];

}
