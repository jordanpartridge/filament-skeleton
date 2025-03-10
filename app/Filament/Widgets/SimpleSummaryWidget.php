<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SimpleSummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.simple-summary-widget';
    
    // Auto-refresh every 30 seconds
    protected static ?string $pollingInterval = '30s';
    
    // Make it span full width
    protected int|string|array $columnSpan = 'full';
    
    public function getSummaryData()
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
        
        return [
            'dbSize' => $dbSize,
            'phpVersion' => $phpVersion,
            'laravelVersion' => $laravelVersion,
        ];
    }
}
