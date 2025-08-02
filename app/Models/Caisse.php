<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $montant_init
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse whereMontantInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caisse whereUserId($value)
 * @mixin \Eloquent
 */
class Caisse extends Model
{
    protected $fillable = ['user_id','montant_init'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
