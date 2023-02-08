<?php

namespace App\Listeners;

use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CommentWasCreated as CommentEvent;

class CommentWasCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CommentEvent $event
     * @return void
     */
    // Envoi la notification  à l'auteur d'un article
    public function handle(CommentEvent $event)
    {
        // On a accès a comment car il est dans CommentEvent
        $when = now()->addSeconds(10);
        $event->comment->user->notify((new NewCommentNotification($event->comment))->delay($when));
    }

    public function failed(CommentEvent $event, $exception)
    {

    }
}
