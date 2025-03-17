<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conditionnement extends Model
{
    protected $tables = 'conditionnements';
    protected $fillable = [
        'commande_id',
        'nombre_cageot',
        'etat',
        'created_at',
        'updated_at'
    ];

    public function commande(){
        return $this->belongsTo(Commande::class , 'commande_id');
    }
}
