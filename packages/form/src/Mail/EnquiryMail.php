<?php

namespace Antidote\LaravelForm\Mail;

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EnquiryMail extends \Illuminate\Mail\Mailable
{
    private Enquiry $enquiry;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('info@titan21.co.uk', 'Tim Smith'),
            subject: 'Enquiry sent via the \''.$this->enquiry->form->name.'\' form'
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'laravel-form::email.enquiry-data',
            with: [
                'data' => $this->enquiry->data
            ]
        );
    }
}