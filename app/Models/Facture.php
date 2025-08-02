<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $demande_id
 * @property string $path_image
 * @property string $montant
 * @property string $fournisseur
 * @property string $nom_article
 * @property int $quantite_achete
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereDemandeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereFournisseur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereNomArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture wherePathImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereQuantiteAchete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Facture extends Model
{
    protected $fillable = [
       'demande_id',  'path_image','date','filesize'
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
