<?php

namespace Antidote\LaravelForm\Domain\Fields;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

class SelectField extends Field
{
    public static function getField(\Antidote\LaravelForm\Models\Field $field): Component
    {
        $options = $field->options;

        if($field->field_attributes['use_value_for_submission'])
        {
            $options = collect($field->options)->mapWithKeys(function($value) {
                return [$value => $value];
            })->toArray();
        }

        return Select::make('submitted_data.'.$field->name)
            ->options($options);
    }

    public static function getFieldOptions(): array
    {
        return [
            Checkbox::make('field_attributes.use_value_for_submission'),
            KeyValue::make('field_attributes.options')
                //@todo needs work - possibly put in Alpine.data to be shared or rolled into Filament as an option
                ->extraAlpineAttributes([
                    'x-init' => '
                        $watch("rows", function(value)
                        {
                            if(value && value.length) {
                                value.forEach(function(item, index) {
                                    if(!item.key) {
                                        if(item.value) {
                                            item.key = "option1"
                                        } else {
                                            if(index > 1)
                                            {
                                                item.key = $data.rows[index-1].key.replace(/(\d*)$/, (_, t) => (+t + 1).toString().padStart(t.length, 0));
                                            }
                                        }
                                    }
                                })
                            }
                        })'
                ])
        ];
    }
}