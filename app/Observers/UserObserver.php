<?php

namespace App\Observers;

use App\Jobs\SendEmailFromTemplate;
use App\Models\EmailTemplate;
use App\Models\User;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
//        dispatch(new SendEmailFromTemplate(EmailTemplate::USER_WELCOME_EMAIL, [
//            '[name]' => $user->name,
//            '[email]' => $user->email,
//            '[app]' => config('app.name'),
//            '[link]' => $user->getInvitationLink()
//        ], $user->email));
    }
}