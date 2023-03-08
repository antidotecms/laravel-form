<?php

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelForm\Notifications\EnquiryEmailNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

it('includes the details of the enquiry', function() {

    Notification::fake();

    $form = Form::factory()->create([
        'name' => 'Contact Us'
    ]);

    $enquiry = Enquiry::factory()->fromForm($form)->withData('color', 'red')->create();

    Event::dispatch(new \Antidote\LaravelForm\Events\EnquirySentEvent($form, $enquiry));

    Notification::assertSentOnDemand(EnquiryEmailNotification::class, function(EnquiryEmailNotification $notification, $channels, AnonymousNotifiable $notifiable) {

//        expect($notification->toMail($notifiable)->subject)->toBe('Enquiry sent via the \'Contact Us\' form');
//        expect($notification->toMail($notifiable)->render()->toHtml())->toContain('The introduction to the notification.');
//        expect($notification->toMail($notifiable)->render()->toHtml())->toContain('color:red');
        expect(get_class($notification->toMail($notifiable)))->toBe(\Antidote\LaravelForm\Mail\EnquiryMail::class);
        expect($notification->toMail($notifiable)->envelope()->subject)->toBe('Enquiry sent via the \'Contact Us\' form');
        return true;

    });


});
