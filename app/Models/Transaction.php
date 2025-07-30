<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id','caisse_id','demande_id','montant_transaction','type','motif'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function demande()
    {
        return  $this->belongsTo(Demande::class);
    }
}
