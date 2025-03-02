<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function achats(){
        return $this->hasMany(Achat::class , 'commande_id');
    }
}
