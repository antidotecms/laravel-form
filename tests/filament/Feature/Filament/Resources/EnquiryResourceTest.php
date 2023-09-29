<?php

it('will display the details of the enquiry', function() {

    $form = \Antidote\LaravelForm\Models\Form::factory()
        ->withRecipients()
        ->create();

    $name_field = \Antidote\LaravelForm\Models\Field::factory()
        ->asTextField()
        ->withForm($form)
        ->create([
            'name' => 'Name',
            'is_display_field' => true
        ]);

    $enquiry = \Antidote\LaravelForm\Models\Enquiry::factory()
        ->fromForm($form)
        ->withData($name_field->name, 'a name')
        ->create();

    $field_name = \Illuminate\Support\Str::headline($name_field->name);
    $description = "<table>\n<tr>\n<td>\n$field_name: a name\n</td>\n</tr>\n</table>";

    \Pest\Livewire\livewire(\Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages\ListEnquiries::class)
        ->assertCanSeeTableRecords(collect([$enquiry]))
        ->assertTableColumnExists('Details')
        ->assertTableColumnFormattedStateSet('Details', $form->name, $enquiry)
        ->assertTableColumnHasDescription('Details', $description, $enquiry);
});