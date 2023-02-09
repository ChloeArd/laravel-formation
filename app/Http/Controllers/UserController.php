<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Nette\Schema\ValidationException;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('profile');
    }

    public function profile(User $user)
    {
        $data = [
            'title' => "Profil de " . $user->name,
            'description' => $user->name . " est inscrit depuis le " . $user->created_at->isoFormat("LL") . "et à posté " . $user->articles()->count() . " article(s)",
            'user' => $user,
            'articles' => $user->articles()->withCount('comments')->orderByDesc('comments_count')->paginate(2)
        ];
        // withCount() -> permet de compter le nombre de commentaire pour chaque article et s'ajoute dans le tableau de l'article

        return view('user.profile', $data);
    }

    // Formulaire de mise à jour des informations du user connecté
    public function edit() {
        $user = auth()->user();
        $data = [
            'title' => $description = "Editer mon profil",
            'description' => $description,
            'user' => $user
        ];

        return view('user.edit', $data);
    }

    // Formulaire de changement de mot de passe
    public function password() {
        $data = [
            'title' => $description = "Modifier mon mot de passe",
            'description' => $description,
            'user' => auth()->user()
        ];

        return view('user.password', $data);
    }

    // Mise à jour du mot de passe
    public function updatePassword() {
        request()->validate([
           'current' => 'required|password', // password -> verifie si les 2 password sont identiques
           'password' => 'required|between:9,20|confirmed'
        ]);

        $user = auth()->user();

        $user->password = bcrypt(request('password'));
        $user->save();

        $success = "Mot de passe mis à jour !";

        return back()->withSuccess($success);
    }

    // Sauvegarde des informations sur l'utilisateur
    public function store() {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            // On met à jour l'utilisateur
            // On prend l'utilisateur connecté et vérifie s'il existe
            $user = $user->updateOrCreate(['id' => $user->id],
                request()->validate([
                    'name' => ['required', 'min:3', 'max:20', Rule::unique('users')->ignore($user)],
                    'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                    'avatar' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpg,jpeg,png',
                        'dimensions:min_width=200,min_height=200']
                ]));

            if (request()->hasFile('avatar') && request()->file('avatar')->isValid()) {

                if (Storage::exists('avatars/' . $user->id)) {
                    Storage::deleteDirectory('avatars/' . $user->id);
                }

                $ext = request()->file('avatar')->extension();
                $filename = Str::slug($user->name) . "-" . $user->id . "." . $ext;
                // J'ajoute l'image dans un dossier avatars qui va se trouver dans le dossier storage
                $path = request()->file('avatar')->storeAs('avatars/' . $user->id, $filename);
                // redimensionne une image
                $thumbnailImage = Image::make(request()->file("avatar"))->fit(200,200, function($constraint) {
                    $constraint->upsize();
                })->encode($ext, 50);

                $thumbnailPath = "avatars/" . $user->id . "/thumbnail/" . $filename;

                Storage::put($thumbnailPath, $thumbnailImage);

                $user->avatar()->updateOrCreate(['user_id' => $user->id],
                    [
                        'filename' => $filename,
                        'url' => Storage::url($path),
                        'path' => $path,
                        'thumb_url' => Storage::url($thumbnailPath),
                        'thumb_path' => $thumbnailPath
                    ]
                );
            }
        }
        catch (ValidationException $e) {
            DB::rollBack();
        }

        DB::commit();

        $success = "Informations mises à jour.";
        return back()->withSuccess($success);
    }

    // L'utilisateur peut supprimer son compte
    public function destroy(User $user)
    {
        // delete le user et son image de profil

        abort_if($user->id != auth()->id(), 403);
        Storage::deleteDirectory("avatars/" . $user->id); // Supprime la photo

        $user->delete();

        $success = "Utilisateur supprimé";
        return redirect("/")->withSuccess($success);
    }
}
