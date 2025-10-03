<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emballage extends Model
{
    protected $fillable = [
        'type_cageot',
        'quantite',
        'nom_emballage',
    ];
    protected $table = 'emaballages';
    public $timestamps = false;
}
