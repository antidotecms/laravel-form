<?php

namespace Antidote\LaravelForm\Domain\Fields;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class TextAreaField extends Field
{
    public static function getField(\Antidote\LaravelForm\Models\Field $field): Component
    {
        return Textarea::make('submitted_data.'.$field->name);
    }
}