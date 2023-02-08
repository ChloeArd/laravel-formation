<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'content'];

    // Le commentaire appartient à un article
    public function article() {
        return $this->belongsTo(Article::class);
    }

    // Le commentaire appartient à un utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }
}
