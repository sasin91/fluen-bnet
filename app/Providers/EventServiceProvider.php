<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.activated: App\User'   =>  ['App\Listeners\ActivationEventsListener@onUserActivated'],

        'eloquent.activating: *'   =>  ['App\Listeners\ActivationEventsListener@onActivating'],
        'eloquent.activated: *'   =>  ['App\Listeners\ActivationEventsListener@onActivated'],
        'eloquent.deactivating: *'   =>  ['App\Listeners\ActivationEventsListener@onDeactivating'],
        'eloquent.deactivated: *'   =>  ['App\Listeners\ActivationEventsListener@onDeactivated'],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
