<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignationAchat extends Model
{
    protected $table = 'consignation_achats';
    protected $fillable = [
       'achat_id',
        'prix',
        'prix_cgt',
        'etat',
        'etat_cgt',
        'date_consignation'
    ];

    public function achat(){
        return $this->belongsTo(Achat::class , 'achat_id');
    }
}
