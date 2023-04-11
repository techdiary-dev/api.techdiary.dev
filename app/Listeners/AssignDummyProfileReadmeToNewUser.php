<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignDummyProfileReadmeToNewUser implements ShouldQueue
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
     * @return void
     */
    public function handle(NewUserCreated $event)
    {
        $event->user->update([
            'profile_readme' => '# Hello, I am '.$event->user->name,
        ]);
    }
}
