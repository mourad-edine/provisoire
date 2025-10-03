<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRendu extends Model
{
    protected $fillable = [
        'id_vente',
        'commande_id',
        'quantite',
        'quantite_casse',
    ];
    protected $table = 'articles_rendus';
    public $timestamps = false;
    public function vente(){
        return $this->belongsTo(Vente::class ,'id_vente');
    }
}
