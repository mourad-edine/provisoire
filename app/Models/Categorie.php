<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $tables = 'categories';
    protected $fillable = [
        'nom',
        'reference',
        'imagep'
    ];

    public function articles(){
        return $this->hasMany(Article::class , 'categorie_id');
    }
}
