<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouteillePersonnalisee extends Model
{
    use HasFactory;

    protected $table = 'bouteilles_personnalisees';

    protected $fillable = [
        'nom',
        'pays',
        'region',
        'couleur',
        'format',
        'prix',
        'producteur',
        'millesime',
        'cepage',
        'tauxSucre',
        'degre',
        'type', 
        'user_id'
    ]; 

    public function bouteillesPersonnaliseesCelliers() 
    {
        return $this->hasMany(BouteillePersonnaliseeCellier::class, 'bouteille_id');
    }

    public function commentaires() 
    {
        return $this->hasMany(Commentaire::class);
    }

    public function favoris() 
    {
        return $this->hasMany(Favoris::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
