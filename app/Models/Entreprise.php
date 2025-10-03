<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'numero',
        'email',
        'nif',
        'stat',
        'logo',
    ];
    protected $table = 'entreprises';
    public $timestamps = false;
}
