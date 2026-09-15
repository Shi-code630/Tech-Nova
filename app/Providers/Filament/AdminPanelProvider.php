<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->authGuard('admin')
            ->login()
            ->registration()
            ->profile()
            ->brandName('Tech Nova Admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )
            ->navigationGroups([
                NavigationGroup::make()->label('Customer Management')->collapsible(),
                NavigationGroup::make()->label('Product Management')->collapsible(),
                NavigationGroup::make()->label('Sales Management')->collapsible(),
                NavigationGroup::make()->label('Marketing')->collapsible(),
                NavigationGroup::make()->label('Customer Activity')->collapsible(),
                NavigationGroup::make()->label('Shipping & Delivery')->collapsible(),
                NavigationGroup::make()->label('Administration')->collapsible(),
                NavigationGroup::make()->label('Settings')->collapsible(),
                NavigationGroup::make()->label('Support & Helpdesk')->collapsible(),
                NavigationGroup::make()->label('Integrations')->collapsible(),
                NavigationGroup::make()->label('System Logs')->collapsible(),
                NavigationGroup::make()->label('User Management')->collapsible(),
                NavigationGroup::make()->label('Content Management')->collapsible(),
                NavigationGroup::make()->label('Reports & Analytics')->collapsible(),
            ])
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
            ]);
    }
}
