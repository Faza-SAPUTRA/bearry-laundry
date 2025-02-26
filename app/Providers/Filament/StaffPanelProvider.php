<?php

namespace App\Providers\Filament;

use App\Filament\Resources\TransaksiResource\Widgets\TransaksiChart;
use App\Filament\Widgets\DashboardCharts;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('staff')
            ->path('staff')
            ->login()
            ->colors([
                'primary' => '#BE8C63', // Ganti dengan warna yang sesuai
                'secondary' => '#E4D1B9', // Ganti dengan warna yang sesuai
                'primary-light' => '#A97155', // Ganti dengan warna yang sesuai
                'diskon' => '#F59E0B',
                'green' => '#22C55E',
            ])
            ->font('Space Grotesk')
            ->brandLogo(fn() => view('filament.custom-brand'))
            ->brandLogoHeight('4rem')
            ->defaultThemeMode(ThemeMode::Light)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars',
                        rules: 'mimes:jpeg,png|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                    )
                    ->slug('edit-profile')
                    ->setTitle('Informasi Profil')
                    ->canAccess(fn() => auth()->user()->hasRole('Petugas'))
                    ->setNavigationLabel('Profil Saya')
                    ->setNavigationGroup('Manajemen Akun')
                    ->setIcon('heroicon-o-user')
                    ->setSort(-1)
                    ->shouldShowDeleteAccountForm(false),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications();
    }
}
