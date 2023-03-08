<?php

it('displays the form', function() {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create([
        'name' => 'Contact'
    ]);

    $text_field = \Antidote\LaravelForm\Models\Field::factory()->asTextField()->withForm($form)->create();

    \Pest\Livewire\livewire(\Antidote\LaravelForm\Http\Livewire\Form::class, [
        'form_id' => $form->id
    ])
        ->assertViewIs('laravel-form::livewire.form')
        ->assertHasNoErrors();
});

it('will raise an exception if the form id is invalid', function () {

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('form does not exist');
    \Pest\Livewire\livewire(\Antidote\LaravelForm\Http\Livewire\Form::class, [
        'form_id' => 100
    ]);
});

it('will send an enquiry', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create([
        'name' => 'Contact',
        'to' => 'info@titan21.co.uk'
    ]);

    $field = \Antidote\LaravelForm\Models\Field::factory()->asTextField()->withForm($form)->create([
        'name' => 'message',
        'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
    ]);

    \Illuminate\Support\Facades\Event::fake();

    \Pest\Livewire\livewire(\Antidote\LaravelForm\Http\Livewire\Form::class, [
        'form_id' => $form->id
    ])
        ->fillForm([
            'submitted_data.message' => 'this is a message'
        ])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertNotified(\Filament\Notifications\Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send());

    \Illuminate\Support\Facades\Event::assertDispatched(\Antidote\LaravelForm\Events\EnquirySentEvent::class);
});

it('will save an enquiry', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create([
        'name' => 'Contact',
        'to' => 'info@titan21.co.uk'
    ]);

    $field = \Antidote\LaravelForm\Models\Field::factory()->asTextField()->withForm($form)->create([
        'name' => 'message',
        'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
    ]);

    \Illuminate\Support\Facades\Mail::fake();

    \Pest\Livewire\livewire(\Antidote\LaravelForm\Http\Livewire\Form::class, [
        'form_id' => $form->id
    ])
        ->fillForm([
            'submitted_data.message' => 'this is a message'
        ])
        ->call('submit')
        ->assertHasNoErrors();

    expect(\Antidote\LaravelForm\Models\Enquiry::count())->toBe(1);
    expect(\Antidote\LaravelForm\Models\Enquiry::first()->data->message)->toBe('this is a message');
});