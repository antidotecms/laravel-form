<?php

namespace Antidote\LaravelForm\Tests;

use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Orchestra\Testbench\Http\Middleware\VerifyCsrfToken;

class PanelServiceProvider extends \Filament\PanelProvider
{

    public function panel(\Filament\Panel $panel): \Filament\Panel
    {
        return $panel
            ->id('forms')
            ->path('forms')
            ->default()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            //->authGuard('web')
            ->resources([
                \Antidote\LaravelFormFilament\Filament\Resources\FormResource::class,
                \Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource::class
            ]);
    }
}