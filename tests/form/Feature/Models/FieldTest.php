<?php

it('has a type', function() {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->asTextField()->create([
        'name' => 'email'
    ]);

    expect($field->field_type)->toBe(\Antidote\LaravelForm\Domain\Fields\TextField::class);
});

it('will accept a valid field type', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->create([
        'name' => 'Test Form',
        'field_type' => \Antidote\LaravelForm\Domain\Fields\TextField::class
    ]);

    $this->expectNotToPerformAssertions();
});

it('will throw an exception if it has an invalid field type', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('not a valid field type - must extend from \Antidote\LaravelForm\Domain\Fields\Field');

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->create([
        'name' => 'Test Form',
        'field_type' => 'not valid'
    ]);
});

it('has a common attribute', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->asTextField()->withAttribute('required', true)->create([
        'name' => 'email'
    ]);

    //expect($field->attributes['required'])->toBeTrue();
    expect($field->required)->toBeTrue();

});

it('does not have a common attribute but will supply a default', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->asTextField()->create([
        'name' => 'email'
    ]);

    //expect($field->attributes['required'])->toBeTrue();
    \Pest\Laravel\withoutExceptionHandling();
    expect($field->required)->toBeFalse();

});

it('has an attribute', function () {

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()->withForm($form)->asTextField()->withAttribute('color', 'red')->create([
        'name' => 'email'
    ]);

    //expect($field->attributes['required'])->toBeTrue();
    expect($field->color)->toBe('red');

});

it('throws an exception if an attribute does not exist', function () {

    $this->markTestSkipped('possibly not needed');

    $form = \Antidote\LaravelForm\Models\Form::factory()->create();

    $field = \Antidote\LaravelForm\Models\Field::factory()
        ->withForm($form)
        ->asTextField()
        ->withAttribute('color', 'red')
        ->create([
            'name' => 'email'
        ]);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('no such field or attribute');
    expect($field->foo)->toBe('bar');

});