<?php

namespace Antidote\LaravelForm\Models;

use Antidote\LaravelForm\Events\EnquirySentEvent;
use Antidote\LaravelForm\Database\Factories\FormFactory;
use Antidote\LaravelForm\Notifications\EnquiryEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class Form extends Model
{
    use HasFactory, Notifiable;

    protected static function newFactory()
    {
        return new FormFactory();
    }

    protected $fillable = [
        'name',
        'to',
        'cc',
        'bcc'
    ];

    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array'
    ];

    public function fields()
    {
        return $this->hasMany(Field::class)->orderBy('order', 'ASC');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function send($data)
    {
        $enquiry = Enquiry::create([
            'data' => $data,
            'form_id' => $this->id
        ]);

        //Event::dispatch(new \Antidote\LaravelForm\Events\EnquirySentEvent($this, $enquiry));
        EnquirySentEvent::dispatch($this, $enquiry);
    }
}