<?php

namespace Antidote\LaravelForm\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RequiredCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return $model->field_attributes['required'] ?? false;
    }

    public function set($model, $key, $value, $attributes)
    {

    }
}