<?php

use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages\CreateForm;

it('can create a form', function() {

    $form = Form::factory()
        ->withRecipient('to', 'Tim Smith', 'test@test.com')
        ->make();

    $repeater_key = null;

    \Pest\Livewire\livewire(CreateForm::class)
        /**
         * @todo we need ot add the follwing "taps" since if `assertHasNoFormErrors` is not passed any keys, it will check against the uuid and since
         * we do not normally have to pass in a key when filling the form, validation fails
         */
        ->tap(function($livewire) use (&$repeater_key) {
            $repeater_key = collect(array_keys($livewire->data['to']))->first();
        })
        ->tap(function() use ($form, $repeater_key) {
            $form->to = [
                $repeater_key => [
                    'name' => 'Tim Smith',
                    'email' => 'test@test.com'
                ]
            ];
        })
        ->fillForm($form->attributesToArray())
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
//        ->tap(function($livewire) use (&$repeater_key) {
//            $repeater_key = collect(array_keys($livewire->data['to']))->first();
//        })
//        ->tap(function() use ($form, $repeater_key) {
//            $form->to = [
//                $repeater_key => [
//                    'name' => '',
//                    'email' => ''
//                ]
//            ];
//        })
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
//            "to.{$repeater_key}.name" => 'required',
//            "to.{$repeater_key}.email" => 'required',
            "to.0.name" => 'required',
            "to.0.email" => 'required'
        ]);

    $form = Form::factory()
        //->withRecipient('to', 'Tim Smith', 'invalid email address')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->tap(function($livewire) use (&$repeater_key) {
            $repeater_key = collect(array_keys($livewire->data['to']))->first();
        })
        ->tap(function() use ($form, $repeater_key) {
            $form->to = [
                $repeater_key => [
                    'name' => 'Tim Smith',
                    'email' => 'invalid email address'
                ]
            ];
        })
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasFormErrors([
            "to.{$repeater_key}.email" => 'email'
        ]);

    $form = Form::factory()
        ->withRecipient('to', 'Tim Smith', 'test@test.com')
        ->make();

    \Pest\Livewire\livewire(CreateForm::class)
        ->tap(function($livewire) use (&$repeater_key) {
            $repeater_key = collect(array_keys($livewire->data['to']))->first();
        })
        ->tap(function() use ($form, $repeater_key) {
            $form->to = [
                $repeater_key => [
                    'name' => 'Tim Smith',
                    'email' => 'test@test.com'
                ]
            ];
        })
        ->fillForm($form->attributesToArray())
        ->call('create')
        ->assertHasNoFormErrors([
            "to.{$repeater_key}.name",
            "to.{$repeater_key}.email"
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
            "cc.0.name" => 'required',
            "cc.0.email" => 'required'
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