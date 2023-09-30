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

    $this->enquiry = \Antidote\LaravelForm\Models\Enquiry::factory()
        ->fromForm($this->form)
        ->withData($this->name_field->name, 'a name')
        ->create();
});

it('will display the details of the enquiry', function() {

    $field_name = \Illuminate\Support\Str::headline($this->name_field->name);
    $description = "<table>\n<tr>\n<td>\n$field_name: a name\n</td>\n</tr>\n</table>";

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\ListEnquiries::class)
        ->assertCanSeeTableRecords(collect([$this->enquiry]))
        ->assertTableColumnExists('Details')
        ->assertTableColumnFormattedStateSet('Details', $this->form->name, $this->enquiry)
        ->assertTableColumnHasDescription('Details', $description, $this->enquiry);
});

it('will display data from fields that have been soft deleted', function () {

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\EditEnquiry::class, [
        'record' => $this->enquiry->id
    ])
    ->assertFormFieldExists('submitted_data.name');

    $this->name_field->delete();
    expect($this->name_field->deleted_at)->not()->toBeNull();

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\EditEnquiry::class, [
        'record' => $this->enquiry->id
    ])
    ->assertFormFieldExists('submitted_data.name');
});

test('data from deleted fields will be appropriately flagged', function () {

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\EditEnquiry::class, [
        'record' => $this->enquiry->id
    ])
    ->assertFormFieldExists('submitted_data.name', function(\Filament\Forms\Components\TextInput $field) {
        return $field->getHelperText() == "";
    });

    $this->name_field->delete();
    expect($this->name_field->deleted_at)->not()->toBeNull();

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\EditEnquiry::class, [
        'record' => $this->enquiry->id
    ])
        ->assertFormFieldExists('submitted_data.name', function(\Filament\Forms\Components\TextInput $field) {
            return $field->getHelperText() == "This field has been deleted from the form";
        });
});