<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueVente extends Model
{
    protected $table = 'historique_ventes';
    protected $fillable = [
        'id_article',
        'id_vente',
        'type_historique',
        'quantite_initiale',
        'quantite_enleve',
        'quantite_finale',
        'prix',
        'total',
        'created_at',
        'updated_at',
    ];

    public function vente(){
        return $this->belongsTo(Vente::class ,'id_vente');
    }

    public function article(){
        return $this->belongsTo(Article::class ,'id_article');
    }
}
