<?php

namespace Antidote\LaravelForm\Events;

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EnquirySentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Enquiry $enquiry;
    public Form $form;

    public function __construct(Form $form, Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
        $this->form = $form;
    }
}