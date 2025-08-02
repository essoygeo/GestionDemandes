<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $caisse_id
 * @property int|null $demande_id
 * @property string $type
 * @property string $montant_transaction
 * @property string $motif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Demande|null $demande
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCaisseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDemandeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereMontantTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserId($value)
 * @mixin \Eloquent
 */
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
