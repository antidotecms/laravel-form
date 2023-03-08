<?php

namespace Antidote\LaravelForm\Domain\Fields;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;

abstract class Field
{
    public static $useValueOnSubmission = false;

    public \Antidote\LaravelForm\Models\Field $field;

    public static function getFieldOptions() : array
    {
        return [];
    }

    public static function getCommonOptions(): array
    {
        return [
            Checkbox::make('field_attributes.required')
        ];
    }

    public static function getAllOptions(): array
    {
        return array_merge(
            static::getFieldOptions(),
            static::getCommonOptions()
        );
    }

    public static function getFilamentField(\Antidote\LaravelForm\Models\Field $field): Component
    {
           return static::applyCommonAttributes($field);
    }

    private static function applyCommonAttributes($field): Component
    {
        return static::getField($field)
            ->required($field->required ?? false)
            ->label($field->label);
    }
}