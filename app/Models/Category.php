<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //plusieurs articles peuvent appartenir à la meme categorie
    public function articles() {
        return $this->hasMany(Article::class);
    }
}
