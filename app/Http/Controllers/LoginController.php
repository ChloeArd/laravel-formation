<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest');
    }
    public function index() { // formulaire de connexion
        //dd(Auth::check()); // Verifie si la personne est connecté
        //dd(Auth::guest()); // Verifie si la personne est non connecté
        $data = [
            'title' => 'Login - ' . config('app.name'),
            'description' => 'Connexion à votre compte - ' . config('app.name')
        ];

        return view('auth.login', $data);
    }

    public function login() { // traitement du login
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = request()->has('remember');

        if (Auth::attempt(['email' => \request('email'), 'password' => request('password')], $remember)) {
            return redirect("/");
        }

        return back()->withError('Mauvais identifiants.')->withInput();

    }
}
