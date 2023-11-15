<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'user_id'
    ]; 

    public function bouteillesCelliers() 
    {
        return $this->hasMany(BouteilleCellier::class);
    }

    public function bouteillesPersonnaliseesCelliers() 
    {
        return $this->hasMany(BouteillePersonnaliseeCellier::class);
    }


    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}

