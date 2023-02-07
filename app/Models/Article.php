<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // permet de récuper le slug que l'id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Un article peut avoir q'un utilisateur
    public function user(){
        return $this->belongsTo(User::class); // L'article appartient à un utilisateur
    }

    // Un article appartient à une catégorie
    public function category() {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => "Catégorie anonyme"
        ]);
    }
}
