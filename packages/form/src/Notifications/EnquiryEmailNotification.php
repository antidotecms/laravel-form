<?php

namespace Antidote\LaravelForm\Notifications;

use Antidote\LaravelForm\Mail\EnquiryMail;
use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryEmailNotification extends Notification
{
    private Enquiry $enquiry;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
//        $message = (new MailMessage)
//            ->subject('Enquiry sent via the \''.$this->form->name.'\' form')
//            ->line('The introduction to the notification.');
//
//        collect($this->enquiry->data)->map(function($value, $key) use ($message) {
//             $message->line($key.':'.$value);
//        });
//
//        $message->action('Notification Action', url('/'))
//            ->line('Thank you for using our application!');
//
//        return $message;

        $address = $notifiable instanceof AnonymousNotifiable
            ? $notifiable->routeNotificationFor('mail')
            : $notifiable->email;

        return(new EnquiryMail($this->enquiry))
            ->to($address)
            ->cc($this->enquiry->form->cc)
            ->bcc($this->enquiry->form->bcc);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
