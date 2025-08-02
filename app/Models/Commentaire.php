<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $demande_id
 * @property int $user_id
 * @property string $contenu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Demande $demande
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereDemandeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereUserId($value)
 * @mixin \Eloquent
 */
class Commentaire extends Model
{
    protected $fillable= ['nom','demande_id','user_id','contenu','date'];

    public function demande(){
        return $this->belongsTo(Demande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
