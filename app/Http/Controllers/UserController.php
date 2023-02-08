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
        return "Je suis un utilisateur et mon nom est " . $user->name;
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
}
