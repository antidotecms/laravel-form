<?php

namespace Antidote\LaravelForm\Domain\Fields;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class TextField extends Field
{
    public static function getField(\Antidote\LaravelForm\Models\Field $field): Component
    {
        return TextInput::make('submitted_data.'.$field->name)
            ->email(isset($field->field_attributes['validate_as']) && $field->field_attributes['validate_as'] == 'email');
    }

    public static function getFieldOptions(): array
    {
        return [
            Radio::make('field_attributes.validate_as')
                ->options([
                    'text' => 'Text',
                    'email' => 'Email Address'
                ])
            ->default('text')
        ];
    }
}