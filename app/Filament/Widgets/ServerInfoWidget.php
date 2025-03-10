<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ServerInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.server-info-widget';
    
    // Auto-refresh every 30 seconds
    protected static ?string $pollingInterval = '30s';
    
    // Use integer for column span to avoid errors
    protected int|string|array $columnSpan = 1;
    
    public function getServerInfo()
    {
        // Get disk space
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskUsedPercentage = round(($diskUsed / $diskTotal) * 100);
        
        // Get CPU usage (simulated)
        $cpuUsage = rand(20, 60);
        
        // Get memory usage (simulated)
        $memoryUsage = rand(40, 80);
        $memoryTotal = '4 GB';
        $memoryUsed = round(4 * ($memoryUsage / 100), 1) . ' GB';
        
        // Get server uptime (simulated)
        $uptime = '3 days, 4 hours';
        
        // Get PHP version
        $phpVersion = PHP_VERSION;
        
        // Get web server info
        $webServer = $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/2.4';
        
        // Get operating system (simulated or from PHP)
        $operatingSystem = php_uname('s') . ' ' . php_uname('r');
        
        // Get database information
        $dbInfo = $this->getDatabaseInfo();
        
        return [
            'diskUsage' => [
                'percentage' => $diskUsedPercentage,
                'used' => $this->formatBytes($diskUsed),
                'total' => $this->formatBytes($diskTotal)
            ],
            'cpuUsage' => $cpuUsage,
            'memoryUsage' => [
                'percentage' => $memoryUsage,
                'used' => $memoryUsed,
                'total' => $memoryTotal
            ],
            'uptime' => $uptime,
            'phpVersion' => $phpVersion,
            'webServer' => $webServer,
            'operatingSystem' => $operatingSystem,
            'database' => $dbInfo,
        ];
    }
    
    private function getDatabaseInfo()
    {
        // Database size (cached)
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
        
        // Get table count (cached)
        $tableCount = Cache::remember('dashboard_table_count', 60, function () {
            try {
                $result = DB::select('SHOW TABLES');
                return count($result);
            } catch (\Exception $e) {
                return 0;
            }
        });
        
        // Get database version (cached)
        $dbVersion = Cache::remember('dashboard_db_version', 3600, function () {
            try {
                $result = DB::select('SELECT VERSION() as version');
                return $result[0]->version ?? 'Unknown';
            } catch (\Exception $e) {
                return 'MySQL 8.0';
            }
        });
        
        // Simplify version if too detailed
        if (strlen($dbVersion) > 10) {
            $dbVersion = substr($dbVersion, 0, 10);
        }
        
        // Get connection count (simulated)
        $connections = rand(1, 5);
        
        return [
            'size' => $dbSize . ' MB',
            'tables' => $tableCount,
            'version' => $dbVersion,
            'connections' => $connections,
        ];
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
