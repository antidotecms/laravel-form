<?php

use Antidote\LaravelForm\Events\EnquirySentEvent;
use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Field;
use Antidote\LaravelForm\Models\Form;

it('has fields', function() {

    $form = Form::factory()->create([
        'name' => 'Contact',
        'to' => 'info@titan21.co.uk'
    ]);

    $field = Field::Factory()
        ->withAttribute('color', 'red')
        ->withForm($form)->create([
            'name' => 'email',
            'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
    ]);

    expect($form->fields->count())->toBe(1);

});

it('will save an enquiry', function () {

    \Illuminate\Support\Facades\Notification::fake();

    $form = Form::factory()->create([
        'name' => 'Contact',
        'to' => 'info@titan21.co.uk'
    ]);

    $field = Field::Factory()
        ->withAttribute('color', 'red')
        ->withForm($form)->create([
            'name' => 'email',
            'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
        ]);

    $form->send([
        'email' => 'some@email.com'
    ]);

    expect(Enquiry::count())->toBe(1);
    expect(Enquiry::first()->data->email)->toBe('some@email.com');
    expect(Enquiry::first()->form->name)->toBe($form->name);
});

it('will email an enquiry', function () {

    \Illuminate\Support\Facades\Event::fake();

    $form = Form::factory()->create([
        'name' => 'Contact',
        'to' => 'info@titan21.co.uk'
    ]);

    $field = Field::Factory()
        ->withAttribute('color', 'red')
        ->withForm($form)->create([
            'name' => 'email',
            'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
        ]);

    $form->send([
        'email' => 'some@email.com'
    ]);

    \Illuminate\Support\Facades\Event::assertDispatched(\Antidote\LaravelForm\Events\EnquirySentEvent::class);
});