<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireBouteillePersonnalisee extends Model
{
    use HasFactory;

    protected $table = 'commentaires_bouteilles_personnalisees';

    protected $fillable = [
        'bouteille_id',
        'bouteille_personnalisee_id',
        'user_id',
        'corps'
    ]; 

    public function bouteillePersonnalisee() 
    {
        return $this->belongsTo(BouteillePersonnalisee::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
