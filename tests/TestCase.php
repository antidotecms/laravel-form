<?php

namespace Antidote\LaravelForm\Tests;

use Antidote\LaravelForm\EventServiceProvider;
use Antidote\LaravelForm\ServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            ServiceProvider::class,
            EventServiceProvider::class,
            FormsServiceProvider::class,
            FilamentServiceProvider::class,
            TablesServiceProvider::class,
            SupportServiceProvider::class,
            NotificationsServiceProvider::class,
            \Antidote\LaravelFormFilament\ServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class
        ];
    }
}