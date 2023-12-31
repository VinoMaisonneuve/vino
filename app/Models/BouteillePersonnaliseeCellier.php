<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouteillePersonnaliseeCellier extends Model
{
    use HasFactory;
    
    protected $table = 'bouteilles_personnalisees_celliers';

    protected $fillable = [
        'bouteille_id',
        'cellier_id',
        'quantite' 
    ]; 

    public function bouteillePersonnalisee() 
    {
        return $this->belongsTo(BouteillePersonnalisee::class, 'bouteille_id');
    }

    public function cellier() 
    {
        return $this->belongsTo(Cellier::class);
    }
}
