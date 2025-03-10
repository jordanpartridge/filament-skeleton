<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class SystemStatsWidget extends BaseWidget
{
    // Auto-refresh every 30 seconds
    protected static ?string $pollingInterval = '30s';
    
    // Make it span 3 columns in the grid
    protected int|string|array $columnSpan = 3;
    
    protected function getStats(): array
    {
        // Get database size (works for MySQL)
        $dbSize = Cache::remember('dashboard_db_size', 60, function () {
            try {
                $dbName = config('database.connections.mysql.database');
                $result = DB::select("SELECT SUM(data_length + index_length) / 1024 / 1024 as size 
                    FROM information_schema.TABLES 
                    WHERE table_schema = ?", [$dbName]);
                return number_format($result[0]->size ?? 0, 2);
            } catch (\Exception $e) {
                return 0;
            }
        });
        
        // Get PHP version
        $phpVersion = PHP_VERSION;
        
        // Get Laravel version
        $laravelVersion = app()->version();
        
        // Create custom HTML for icons
        $databaseIcon = new HtmlString('<i class="fa fa-database"></i>');
        $codeIcon = new HtmlString('<i class="fa fa-code"></i>');
        $gearIcon = new HtmlString('<i class="fa fa-gear"></i>');
        
        return [
            Stat::make('Database Size', $dbSize . ' MB')
                ->description('MySQL database size')
                ->color('warning')
                ->chart([5, 7, 10, 8, 15, 12, 18]),

            Stat::make('PHP Version', $phpVersion)
                ->description('Current PHP version')
                ->color('success')
                ->chart([7, 7.1, 7.2, 7.4, 8.0, 8.1, 8.2]),

            Stat::make('Laravel Version', $laravelVersion)
                ->description('Current framework version')
                ->color('primary')
                ->chart([8, 9, 10, 10.2, 10.4, 10.10, 11]),
        ];
    }
}
