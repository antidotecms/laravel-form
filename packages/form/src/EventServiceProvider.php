<?php

namespace Antidote\LaravelForm;

use Antidote\LaravelForm\Events\EnquirySentEvent;
use Antidote\LaravelForm\Listeners\EnquirySentListener;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    public function boot()
    {
        Event::listen(
             EnquirySentEvent::class, [EnquirySentListener::class, 'handle']
        );
    }
}