<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    protected $guarded = [];

    // il appartient à un utilisateur
    // toujours spécifier les classes qui tiennent avec le model
    public function user() {
        return $this->belongsTo(User::class);
    }
}
