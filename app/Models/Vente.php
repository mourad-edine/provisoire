<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $tables = 'ventes';
    protected $fillable = [
        'article_id',
        'commande_id',
        'quantite',
        'date_sortie',
        'prix',
        'type_achat',
        'btl',
        'cgt',
        'prix_cgt',
        'etat',
        'client'
    ];

    public function article(){
        return $this->belongsTo(Article::class ,'article_id');
    }
    public function commande(){
        return $this->belongsTo(Commande::class ,'commande_id');
    }

    public function consignation(){
        return $this->hasOne(Consignation::class , 'vente_id');
    }
}
