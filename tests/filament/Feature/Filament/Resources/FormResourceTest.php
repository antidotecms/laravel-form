<?php

use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages\CreateForm;

it('can create a form', function() {

    $form = Form::factory()->withRecipient('to', 'Tim Smith', 'test@test.com')->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray()
        )
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Form::count())->toBe(1);
});

it('will validate to recipients', function () {

    $form = Form::factory()
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        //@todo add to filament docs?
        ->assertHasFormErrors([
            'to' => 'min:1.array'
        ]);

    $form = Form::factory()
        ->withRecipient()
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'to.0.name' => 'required',
            'to.0.email' => 'required'
        ]);

    $form = Form::factory()
        ->withRecipient('to', 'Tim Smith', 'invalid email address')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'to.0.email' => 'email'
        ]);

    $form = Form::factory()
        ->withRecipient('to', 'Tim Smith', 'test@test.com')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasNoFormErrors([
            'to.0.name',
            'to.0.email'
        ]);
});

it('will validate a cc recipient', function () {

    $form = Form::factory()
        ->withRecipient('cc')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'cc.0.name' => 'required',
            'cc.0.email' => 'required'
        ]);

    $form = Form::factory()
        ->withRecipient('cc', 'Tim Smith', 'invalid email address')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'cc.0.email' => 'email'
        ]);

    $form = Form::factory()
        ->withRecipient('cc', 'Tim Smith', 'test@test.com')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasNoFormErrors([
            'cc.0.name',
            'cc.0.email'
        ]);

});

it('will validate a bcc recipient', function () {

    $form = Form::factory()
        ->withRecipient('bcc')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'bcc.0.name' => 'required',
            'bcc.0.email' => 'required'
        ]);

    $form = Form::factory()
        ->withRecipient('bcc', 'Tim Smith', 'invalid email address')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            'bcc.0.email' => 'email'
        ]);

    $form = Form::factory()
        ->withRecipient('bcc', 'Tim Smith', 'test@test.com')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasNoFormErrors([
            'bcc.0.name',
            'bcc.0.email'
        ]);

});