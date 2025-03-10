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
        // Get database size with cross-database support
        $dbSize = Cache::remember('dashboard_db_size', 60, function () {
            try {
                $connection = config('database.default');
                $dbName = config('database.connections.' . $connection . '.database');
                
                if ($connection === 'mysql') {
                    // MySQL-specific query
                    $result = DB::select("SELECT SUM(data_length + index_length) / 1024 / 1024 as size 
                        FROM information_schema.TABLES 
                        WHERE table_schema = ?", [$dbName]);
                    return number_format($result[0]->size ?? 0, 2);
                } elseif ($connection === 'sqlite') {
                    // SQLite approach - get file size or 0 for in-memory
                    $databasePath = config('database.connections.sqlite.database');
                    if ($databasePath && $databasePath !== ':memory:' && file_exists($databasePath)) {
                        $size = filesize($databasePath) / 1024 / 1024; // Convert to MB
                        return number_format($size, 2);
                    }
                    return number_format(0, 2);
                } elseif ($connection === 'pgsql') {
                    // PostgreSQL-specific approach
                    $result = DB::select("
                        SELECT pg_database_size(current_database()) / 1024 / 1024 as size
                    ");
                    return number_format($result[0]->size ?? 0, 2);
                } else {
                    // Default for other database types
                    return number_format(0, 2);
                }
            } catch (\Exception $e) {
                // Log error for debugging (optional)
                // \Illuminate\Support\Facades\Log::error('Database size calculation error: ' . $e->getMessage());
                return number_format(0, 2);
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
                ->description('Database size')
                ->descriptionIcon('heroicon-m-database')
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
