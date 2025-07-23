<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    protected $fillable = ['user_id', 'demande_id', 'nom', 'date', 'marque', 'model'];

}
