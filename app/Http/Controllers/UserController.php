<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(string $username)
    {
        return "Je suis un utilisateur et mon nom est $username";
    }
}
