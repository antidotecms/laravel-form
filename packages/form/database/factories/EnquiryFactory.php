<?php

namespace Antidote\LaravelForm\Database\Factories;

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnquiryFactory extends Factory
{
    protected $model = Enquiry::class;

    public function definition(): array
    {
        return [
            
        ];
    }

    public function fromForm(Form $form)
    {
        return $this->state([
            'form_id' => $form->id
        ]);
    }

    public function withData($key, $value)
    {
        return $this->state([
            'data' => [
                $key =>  $value
            ]
        ]);
    }
}
