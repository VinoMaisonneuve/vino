<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouteillePanier extends Model
{
    use HasFactory;

    protected $fillable = [
        'bouteille_id',
        'cellier_id',
        'quantite' 
    ]; 

    public function bouteille() 
    {
        return $this->belongsTo(Bouteille::class);
    }

    public function bouteillePersonnalisee() 
    {
        return $this->belongsTo(BouteillePersonnalisee::class);
    }

    public function panier() 
    {
        return $this->belongsTo(Panier::class);
    }
}
