<?php

namespace App\Listeners;
use App\Models\Auth\User;

use App\Events\UserBlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class setTime
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
     * @param  \App\Events\UserBlocked  $event
     * @return void
     */
    public function handle(UserBlocked $event)
    {
        $event->user->last_blocked_at = \Carbon\Carbon::now();
        $event->user->save();
    }
}
