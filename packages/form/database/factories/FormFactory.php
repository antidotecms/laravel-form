<?php

namespace Antidote\LaravelForm\Database\Factories;

use Antidote\LaravelForm\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    protected $model = Form::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => 'Form',
            'to' => [],
            'cc' => [],
            'bcc' => []
        ];
    }

    public function withRecipients()
    {
        return $this->state([
            'to' => $this->generateEmails(rand(1,3)),
            'cc' => $this->generateEmails(rand(0,3)),
            'bcc' => $this->generateEmails(rand(0,3))
        ]);
    }

    public function withRecipient($type = 'to', $name = null, $email = null)
    {
        if(!in_array($type, ['to', 'cc', 'bcc']))
        {
            throw new \Exception('Invalid recipient type');
        }

        return $this->state([
            $type => [
                [
                    'name' => is_null($name) ? '' : $name,
                    'email' => is_null($email) ? '' : $email
                ]
            ]
        ]);
    }

    private function generateEmails($count): array
    {
        $emails = [];

        for($i = 0; $i <= $count; $i++)
        {
            $emails[] = [
                'name' => $this->faker->name,
                'email' => $this->faker->email
            ];
        }

        return $emails;
    }
}