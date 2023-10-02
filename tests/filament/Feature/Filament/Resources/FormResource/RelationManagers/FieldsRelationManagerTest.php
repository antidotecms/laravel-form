<?php

beforeEach(function() {
    $this->form = \Antidote\LaravelForm\Models\Form::factory()
        ->withRecipients()
        ->create();

    $this->name_field = \Antidote\LaravelForm\Models\Field::factory()
        ->asTextField()
        ->withForm($this->form)
        ->create([
            'name' => 'Name',
            'is_display_field' => true
        ]);

    //@todo why do I need this??
    $this->name_field->restore();

    $this->enquiry = \Antidote\LaravelForm\Models\Enquiry::factory()
        ->fromForm($this->form)
        ->withData($this->name_field->name, 'a name')
        ->create();
});

it('will populate the field choice field with the relevant options', function() {

    $this->markTestIncomplete('How to test fields for a form within a relation manager');
    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager::class, [
        'ownerRecord' => $this->form
    ])
    ->mountTableAction('edit', $this->name_field)
    ->callTableAction('edit', $this->name_field)
    ->assertFormFieldExists('name');
//    ->mountTableAction('associate')
//    ->assertFormFieldExists('field_type',function(\Filament\Forms\Components\Select $field) {
//        return $field->getOptions() == [
//            \Antidote\LaravelForm\Domain\Fields\SelectField::class,
//            \Antidote\LaravelForm\Domain\Fields\TextAreaField::class,
//            \Antidote\LaravelForm\Domain\Fields\TextField::class
//        ];
//    });
});

it('will allow adding custom fields to the available fields', function () {

    $this->markTestIncomplete('How to test fields for a form within a relation manager');
});

it('will not allow a field to have the same name as another within the same form', function () {

    $this->markTestIncomplete('How to test fields for a form within a relation manager');
});

it('will allow a field to have a name that exists in another form', function () {

    $this->markTestIncomplete('How to test fields for a form within a relation manager');
});

it('will soft delete a field', function () {

//    dump($this->name_field->attributesToArray());
//    dump($this->name_field->restore());
//    //$this->name_field->refresh();
//    dump($this->name_field->trashed());
//    dump($this->name_field->attributesToArray());

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager::class, [
        'ownerRecord' => $this->form,
        'pageClass' => \Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages\EditForm::class
    ])
    ->callTableAction(\Filament\Tables\Actions\DeleteAction::class, $this->name_field)
    ->assertHasNoErrors();

    expect(\Antidote\LaravelForm\Models\Field::count())->toBe(0);
    expect(\Antidote\LaravelForm\Models\Field::withTrashed()->count())->toBe(1);
});

it('will filter deleted fields', function () {

    //@toso is there a way to do this more fluently? I.e in a full chain of method calls?
    
    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager::class, [
        'ownerRecord' => $this->form,
        'pageClass' => \Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages\EditForm::class
    ])
    ->assertCanSeeTableRecords(collect([$this->name_field]));

    \Antidote\LaravelForm\Models\Field::first()->delete();
    $this->name_field->refresh();

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager::class, [
        'ownerRecord' => $this->form,
        'pageClass' => \Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages\EditForm::class
    ])
    ->assertCanNotSeeTableRecords(collect([$this->name_field]))
    ->filterTable('trashed')
    ->assertCanSeeTableRecords(collect([$this->name_field]));
});

it('will permanantly delete a field', function () {

    $this->markTestIncomplete('How to test ForceDeleteAction? Is this a bug?');
    //\Antidote\LaravelForm\Models\Field::first()->delete();
    $this->name_field->delete();
    dump($this->name_field);

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager::class, [
        'ownerRecord' => $this->form
    ])
    ->filterTable('trashed')
    ->assertCanSeeTableRecords(collect([$this->name_field]))
    ->assertTableActionExists('force_delete')
    ->callTableAction('force_delete', $this->name_field)
    ->assertHasNoTableActionErrors();

    expect(\Antidote\LaravelForm\Models\Field::withTrashed()->count())->toBe(0);



});

it('will show a warning when a field is permanentely deleted', function () {

    $this->markTestIncomplete('How to test ForceDeleteAction? Is this a bug?');
});

it('will remove data from enquiries where fields have been permanantely deleted', function () {

    $this->markTestIncomplete('How to test ForceDeleteAction? Is this a bug?');
});

