<?php

namespace App\Http\Controllers;

use App\Events\CommentWasCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function store(CommentRequest $request, Article $article) {
        $validateData = $request->validated();
        $validateData['user_id'] = auth()->id();

        $comment = $article->comments()->create($validateData);

        if (auth()->id() != $article->user_id) { // Si le commentateur n'est pas l'auteur de l'article
            // on appelle l'évenement pour envoyer la notification
            event(new CommentWasCreated($comment));
        }
        $success = "Commentaire ajouté";

        return back()->withSuccess($success);
    }
}
