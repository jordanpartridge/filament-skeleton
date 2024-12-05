<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('New Users Today', User::whereDate('created_at', today())->count())
                ->description('Users who joined today')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success')
                ->chart([3, 2, 4, 3, 4, 2, 3]),

            Stat::make('Average Users per Month', number_format(User::count() / max(1, now()->month)))
                ->description('Monthly average for ' . date('Y'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info')
                ->chart([2, 3, 4, 3, 4, 2, 3]),
        ];
    }
}
