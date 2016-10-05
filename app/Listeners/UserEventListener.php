<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use App\Notifications\toStaff\User\AwaitsActivationNotification;
use App\Notifications\toUser\ConfirmationRequiredNotification;
use App\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventListener
{
    public function onRegistered(User $user)
    {
        $user->notify(new ConfirmationRequiredNotification($user->confirmation->token));
    }

    public function onConfirmed(User $user)
    {
        User::filter(function (User $member) {
            return $member->hasPermissionTo('confirm-new-users');
        })->each(function (User $member) use ($user) {
            $member->notify(new AwaitsActivationNotification($user));
        });
    }

    public function onActivated(User $user)
    {
        Event::fire(new NewUserEvent($user));
    }
}
