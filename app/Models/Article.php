<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'user_id', 'slug', 'content', 'category_id']; // assignment

    protected $guarded = ['user_id', 'slug']; // ca veut dire que tous les champs sont fillable sauf ceux qui seront dans []
    // ex : ['active'] -> pour pas qu'un utilisateur le remplisse et l'active soit meme

    // permet de récuper le slug que l'id

    //mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Larticle peut contenir plusieurs commentaires
    public function comments() {
        return $this->hasMany(Comment::class);
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
