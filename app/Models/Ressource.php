<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $categorie_id
 * @property int $user_id
 * @property string $nom
 * @property string $status
 * @property string|null $estimation_montant
 * @property string|null $model
 * @property string|null $marque
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categorie $categorie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Demande> $demandes
 * @property-read int|null $demandes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereEstimationMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereMarque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ressource whereUserId($value)
 * @mixin \Eloquent
 */
class Ressource extends Model
{
    protected $fillable = ['categorie_id','user_id', 'nom', 'date', 'marque', 'model','estimation_montant','status'];
    public function demandes(){
        return  $this->belongsToMany(Demande::class,'demandes_pivot_ressources')
            ->withPivot('id','status','estimation_montant');
    }
    public function categorie(){
        return  $this->belongsTo(Categorie::class,);
    }
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
