<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    protected $fillable = ['categorie_id','user_id', 'nom', 'date', 'marque', 'model','estimation_montant','status'];
    public function demandes(){
        return  $this->belongsToMany(Demande::class,'demandes_pivot_ressources')
            ->withPivot('status','estimation_montant');
    }
    public function categorie(){
        return  $this->belongsTo(Categorie::class,);
    }
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
