<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticable
{
    protected $fillable= ['nom','email','password','role'];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

}
