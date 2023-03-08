<?php

namespace Antidote\LaravelForm\Listeners;

use Antidote\LaravelForm\Events\EnquirySentEvent;
use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelForm\Notifications\EnquiryEmailNotification;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class EnquirySentListener
{
    public function handle(EnquirySentEvent $event)
    {
        Notification::route('mail', $event->form->to)
            ->notify(new EnquiryEmailNotification($event->enquiry));
    }
}