<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $validateur_id
 * @property string $titre
 * @property string $raison
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categorie|null $categorie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Commentaire> $commentaires
 * @property-read int|null $commentaires_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ressource> $ressources
 * @property-read int|null $ressources_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereRaison($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Demande whereValidateurId($value)
 * @mixin \Eloquent
 */
class Demande extends Model
{
    protected $fillable= ['user_id','categorie_id','validateur_id','titre','raison',
        'status'];


    public function categorie()
    {
         return $this->belongsTo(Categorie::class);
    }
    public function user()
    {
      return  $this->belongsTo(User::class);
    }

    public function commentaires(){
        return  $this->hasMany(Commentaire::class);
    }

    public function ressources(){
        return  $this->belongsToMany(
            Ressource::class,'demandes_pivot_ressources')
            ->withPivot('id','status','estimation_montant');
    }

    public function transaction()
    {
        return  $this->hasOne(Transaction::class);
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

}
