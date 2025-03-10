<?php

namespace App\Filament\Pages;

use App\Models\User;
use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\ActionSize;

class PulseDashboard extends Dashboard
{
    use HasFiltersAction;

    // Set the route path
    protected static string $routePath = '/pulse';
    
    // Set a proper title for the page
    protected static ?string $title = 'Application Performance';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'Performance';
    
    // Set proper navigation icon
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function canAccess(): bool
    {
        $user = request()->user();
        return $user->hasPermissionTo('view pulse');
    }

    // Improve the column layout for better responsiveness
    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 6,
            'lg' => 12,
            'xl' => 12,
            '2xl' => 12,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('1h')
                    ->label('Last Hour')
                    ->action(fn() => $this->redirect(route('filament.admin.pages.pulse-dashboard'))),
                Action::make('24h')
                    ->label('Last 24 Hours')
                    ->action(fn() => $this->redirect(route('filament.admin.pages.pulse-dashboard', ['period' => '24_hours']))),
                Action::make('7d')
                    ->label('Last 7 Days')
                    ->action(fn() => $this->redirect(route('filament.admin.pages.pulse-dashboard', ['period' => '7_days']))),
            ])
                ->label(__('Time Filter'))
                ->icon('heroicon-m-funnel')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }

    public function getWidgets(): array
    {
        return [
            // Server statistics at the top (full width)
            PulseServers::class,
            
            // Three column layout for main metrics
            PulseUsage::class,
            PulseCache::class,
            PulseQueues::class,
            
            // Exceptions and Slow Queries (larger widgets)
            PulseExceptions::class,
            PulseSlowQueries::class,
            
            // Remaining widgets at the bottom
            PulseSlowRequests::class,
            PulseSlowOutGoingRequests::class,
        ];
    }
}
