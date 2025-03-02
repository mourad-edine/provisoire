<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $tables = 'achats';
    protected $fillable = [
        'article_id',
        'commande_id',
        'quantite',
        'fournisseur_id',
        'date_entre',
        'prix'
    ];

    public function articles(){
        return $this->belongsTo(Article::class ,'article_id');
    }

    public function commandes(){
        return $this->belongsTo(Commande::class ,'commande_id');
    }

}
