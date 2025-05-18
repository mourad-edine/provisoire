<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignation extends Model
{
    public $timestamps = false;
    protected $tables = 'consignations';
    protected $fillable = [
        'vente_id',
        'prix',
        'prix_cgt',
        'etat',
        'etat_cgt',
        'date_consignation',
        'casse',
        'casse_cgt',
        'rendu_btl',
        'rendu_cgt'
    ];

    public function vente(){
        return $this->belongsTo(Vente::class , 'vente_id');
    }
}
