<?php

namespace Antidote\LaravelForm\Domain\Fields;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TextAreaField extends Field
{
    public static function getField(\Antidote\LaravelForm\Models\Field $field): Component
    {
        return Textarea::make('submitted_data.'.$field->name)
            ->rows($field->field_attributes['rows'] ?? 5);
    }

    public static function getFieldOptions(): array
    {
        return [
            TextInput::make('field_attributes.rows')
                ->numeric()
                ->step(1)
                ->default(5)
        ];
    }
}