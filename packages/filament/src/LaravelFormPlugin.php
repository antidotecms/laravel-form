<?php

namespace Antidote\LaravelFormFilament;

use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class LaravelFormPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'laravel-form';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FormResource::class,
                EnquiryResource::class
            ]);
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}