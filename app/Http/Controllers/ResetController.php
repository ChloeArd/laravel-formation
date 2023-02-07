<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{

    // redirige vers une page si non connecté !
    public function __construct() {
        $this->middleware('guest');
    }

    public function index(string $token) { // formulaire de réinitialisation de mdp
        $password_reset = DB::table('password_resets')->where('token', $token)->first();

        abort_if(!$password_reset, 403); // s'il n'y a pas de token

        $data = [
            'title' => $description = "réinitialisation de mot de passe - " . config('app.name'),
            'description' => $description,
            'password_reset' => $password_reset,
        ];

        return view('auth.reset', $data);
    }

    public function reset() // traitement de réinitialisation du mot de passe
    {
        request()->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|between:9, 20, confirmed'
        ]);

        if(! DB::table('password_resets')
            ->where('email', request('email'))
            ->where('token', request('token'))->count()) {
            $error = "Vérifier l'adresse email.";
            return back()->withError($error)->withInput();
        }

        // Pour récupérer l'utilisateur
        $user = User::whereEmail(request('email'))->firstOrFail();

        // Modifier son mdp
        $user->password = bcrypt(request('password'));
        $user->save();

        DB::table('password_resets')->where('email', request('email'))->delete();

        $success = "Mot de passe bien mis à jour !";
        return redirect()->route('login')->withSuccess($success);
    }
}
