<?php

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelForm\Notifications\EnquiryEmailNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

it('will send out a notification', function() {

    Notification::fake();

    $form = Form::factory()->create();

    $enquiry = Enquiry::factory()->fromForm($form)->withData('name', 'Tim Smith')->create();

    Event::dispatch(new \Antidote\LaravelForm\Events\EnquirySentEvent($form, $enquiry));

    Notification::assertSentOnDemand(EnquiryEmailNotification::class, function(EnquiryEmailNotification $notification, $channels, AnonymousNotifiable $notifiable) use ($form)  {
        expect($notifiable->routes['mail'])->toBe($form->to);
        expect(collect($notification->toMail($notifiable)->to)->pluck('address')->toArray())->toBe($form->to);
        expect(collect($notification->toMail($notifiable)->cc)->pluck('address')->toArray())->toBe($form->cc);
        expect(collect($notification->toMail($notifiable)->bcc)->pluck('address')->toArray())->toBe($form->bcc);
        return true;
    });
});