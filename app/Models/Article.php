<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $tables = 'articles';

    protected $fillable = [
        'categorie_id',
        'nom',
        'reference',
        'conditionnement',
        'imagep',
        'prix_unitaire',
        'prix_consignation',
        'prix_conditionne',
        'quantite',
    ];

    public function categorie(){
        return $this->belongsTo(Categorie::class , 'categorie_id');
    }

    public function achats(){
        return $this->hasMany(Achat::class , 'article_id');
    }

    public function ventes(){
        return $this->hasMany(Vente::class , 'article_id');
    }
}
