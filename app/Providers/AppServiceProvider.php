<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Font Awesome icons for Filament
        FilamentIcon::register([
            // System dashboard icons
            'heroicon-m-data' => 'fas-database',
            'heroicon-m-code-bracket' => 'fas-code',
            'heroicon-m-cog' => 'fas-gear',
            
            // Dashboard navigation icons
            'heroicon-o-home' => 'fas-home',
            'heroicon-o-users' => 'fas-users',
            'heroicon-o-user' => 'fas-user',
            'heroicon-o-server' => 'fas-server',
            'heroicon-o-shield-exclamation' => 'fas-shield-alt',
            'heroicon-o-chart-bar' => 'fas-chart-bar',
            'heroicon-o-presentation-chart-line' => 'fas-tachometer-alt',
            
            // Widget and stat icons
            'heroicon-o-bell' => 'fas-bell',
            'heroicon-o-document' => 'fas-file',
            'heroicon-o-exclamation-circle' => 'fas-exclamation-circle',
            'heroicon-o-exclamation-triangle' => 'fas-exclamation-triangle',
            'heroicon-o-check-circle' => 'fas-check-circle',
            
            // Action icons
            'heroicon-s-plus' => 'fas-plus',
            'heroicon-s-pencil' => 'fas-pen',
            'heroicon-s-trash' => 'fas-trash',
            'heroicon-s-arrow-down' => 'fas-arrow-down',
            'heroicon-s-arrow-up' => 'fas-arrow-up',
        ]);
    }
}
