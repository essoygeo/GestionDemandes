<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    protected $fillable = ['user_id','montant_init'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
