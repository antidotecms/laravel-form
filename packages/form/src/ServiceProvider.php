<?php

namespace Antidote\LaravelForm;

use Antidote\LaravelForm\Http\Livewire\Form;
use Illuminate\Database\Eloquent\Model;
use Livewire\Livewire;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/./../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/./../resources/views', 'laravel-form');

        Livewire::component('laravel-form::form', Form::class);

        Model::shouldBeStrict();
    }
}