<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable= ['user_id','categorie_id','validateur_id','titre','raison',
        'status'];


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

    public function ressources(){
        return  $this->belongsToMany(
            Ressource::class,'demandes_pivot_ressources');
    }

    public function transaction()
    {
        return  $this->hasOne(Transaction::class);
    }
}
