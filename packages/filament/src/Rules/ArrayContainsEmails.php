<?php

namespace Antidote\LaravelFormFilament\Rules;

use Illuminate\Support\Facades\Validator;

class ArrayContainsEmails implements \Illuminate\Contracts\Validation\InvokableRule
{
    //@todo bake into filament - this is used to validate an array of emails via a TagsInput field
    public function __invoke($attribute, $value, $fail)
    {
        foreach($value as $val) {
            if(Validator::make(['email' => $val], [
                'email' => 'email'
            ])->fails()) {
                $fail("The '{$attribute}' '{$val}' is invalid",);
            }
        }
    }
}