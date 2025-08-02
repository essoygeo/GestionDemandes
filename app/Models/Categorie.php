<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ressource> $ressources
 * @property-read int|null $ressources_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie whereUserId($value)
 * @mixin \Eloquent
 */
class Categorie extends Model
{
    protected $fillable= ['nom','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ressources()
    {
        return $this->hasMany(Ressource::class);
    }
}
