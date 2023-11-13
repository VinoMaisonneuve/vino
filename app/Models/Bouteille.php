<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouteille extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom',
        'prix',
        'format',
        'pays',
        'region',
        'cepage',
        'lienProduit',
        'srcImage',
        'srcsetImage',
        'designation',
        'degre',
        'tauxSucre',
        'couleur',
        'producteur',
        'agentPromotion',
        'produitQuebec',
        'type',
        'millesime',
        'pastilleGoutTitre',
        'pastilleImageSrc',
    

      
    ];


    public function bouteillesCelliers() 
    {
        return $this->hasMany(BouteilleCellier::class);
    }

    public function bouteillesListes() 
    {
        return $this->hasMany(BouteilleListe::class);
    }

    public function commentaires() 
    {
        return $this->hasMany(Commentaire::class);
    }

    public function favoris() 
    {
        return $this->hasMany(Favoris::class);
    }


    /**
     * Supprime la chaîne de requête de l'URL de l'image.
     * 
     * (pour avoir l'url de l'image en plus grand)
     * ex.: https://www.saq.com/media/catalog/product/1/5/15111029-1_1680097084.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166&dpr=2
     * pour avoir: https://www.saq.com/media/catalog/product/1/5/15111029-1_1680097084.png
     *
     * @return string
     */
    public function bigImageUrl()
    {
        return explode('?', $this->srcImage)[0];
    }
}
