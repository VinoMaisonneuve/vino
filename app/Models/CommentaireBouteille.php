<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireBouteille extends Model
{
    use HasFactory;

    protected $table = 'commentaires_bouteilles';

    protected $fillable = [
        'bouteille_id',
        'bouteille_personnalisee_id',
        'user_id',
        'corps'
    ]; 

    public function bouteille() 
    {
        return $this->belongsTo(Bouteille::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
