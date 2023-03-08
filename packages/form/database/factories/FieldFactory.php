<?php

namespace Antidote\LaravelForm\Database\Factories;

use Antidote\LaravelForm\Domain\Fields\TextField;
use Antidote\LaravelForm\Models\Field;
use Antidote\LaravelForm\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    protected $model = Field::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word
        ];
    }

    public function withForm(Form $form)
    {
        return $this->state([
            'form_id' => $form->id
        ]);
    }

    public function withAttribute($key, $value)
    {
        return $this->state([
            'field_attributes' => [
                $key =>  $value
            ]
        ]);
    }

    public function asTextField()
    {
        return $this->state([
            'field_type' => TextField::class
        ]);
    }
}
