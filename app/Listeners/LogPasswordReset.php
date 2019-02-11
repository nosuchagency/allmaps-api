<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;

class LogPasswordReset
{
    /**
     * Handle the event.
     *
     * @param  PasswordReset $event
     *
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        activity()
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->log('reset password');
    }
}
