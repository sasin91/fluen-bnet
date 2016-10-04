<?php

namespace App\Listeners;

use App\Events\NewModelEvent;
use App\Events\NewUserEvent;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;

class ActivationEventsListener implements ShouldQueue
{
    public function onActivating(Model $model)
    {
        //
    }

    public function onActivated(Model $model)
    {
        Event::fire(new NewModelEvent($model));
    }

    public function onUserActivated(User $user)
    {
        Event::fire(new NewUserEvent($user));
    }

    public function onDeactivating(Model $model)
    {
        //
    }

    public function onDeactivated(Model $model)
    {
        //
    }
}
