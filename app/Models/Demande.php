<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable= ['user_id','categorie_id','validateur_id','titre','raison','estimation_montant',
        'montant_valide','type','status','quantite','date'];


    public function categorie()
    {
         return $this->belongsTo(Categorie::class);
    }
    public function user()
    {
      return  $this->belongsTo(User::class);
    }

    public function commentaires(){
        return  $this->hasMany(Commentaire::class);
    }
}
