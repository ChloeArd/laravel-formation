<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() { // formulaire de connexion
        $data = [
            'title' => 'Login - ' . config('app.name'),
            'description' => 'Connexion à votre compte - ' . config('app.name')
        ];

        return view('auth.login', $data);
    }

    public function login() { // traitement du login

    }
}
