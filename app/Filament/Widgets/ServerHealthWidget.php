<?php

namespace App\Filament\Widgets;

use App\Helpers\SystemHelper;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class ServerHealthWidget extends BaseWidget
{
    // Auto-refresh every 15 seconds
    protected static ?string $pollingInterval = '15s';
    
    // Make it span all 4 columns
    protected int|string|array $columnSpan = 4;
    
    protected function getStats(): array
    {
        // Check if shell_exec is available
        $shellExecAvailable = function_exists('shell_exec') && !in_array('shell_exec', explode(',', ini_get('disable_functions')));
        
        if (!$shellExecAvailable) {
            Log::warning('ServerHealthWidget: shell_exec function is not available. Using default values for server metrics.');
        }
        
        // Get disk space
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskUsedPercentage = round(($diskUsed / $diskTotal) * 100);
        
        // Get memory usage (if available)
        $memoryUsage = $this->getMemoryUsage();
        
        // Get CPU usage (if available)
        $cpuUsage = $this->getCpuUsage();
        
        // Get server uptime
        $uptime = $this->getServerUptime();
        
        // Get PHP process count
        $phpProcesses = $this->getPhpProcessCount();
        
        return [
            // Disk usage stat
            Stat::make('Disk Usage', $diskUsedPercentage . '%')
                ->description(SystemHelper::formatBytes($diskUsed) . ' of ' . SystemHelper::formatBytes($diskTotal))
                ->descriptionIcon('fas-hdd')
                ->color($diskUsedPercentage > 80 ? 'danger' : ($diskUsedPercentage > 60 ? 'warning' : 'success'))
                ->chart([
                    max(0, $diskUsedPercentage - 20), 
                    max(0, $diskUsedPercentage - 15), 
                    max(0, $diskUsedPercentage - 10), 
                    max(0, $diskUsedPercentage - 5), 
                    $diskUsedPercentage
                ]),
                
            // Memory usage stat
            Stat::make('Memory Usage', $memoryUsage['percentage'] . '%')
                ->description($memoryUsage['used'] . ' of ' . $memoryUsage['total'])
                ->descriptionIcon('fas-memory')
                ->color($memoryUsage['percentage'] > 80 ? 'danger' : ($memoryUsage['percentage'] > 60 ? 'warning' : 'success'))
                ->chart([
                    max(0, $memoryUsage['percentage'] - 20), 
                    max(0, $memoryUsage['percentage'] - 15),
                    max(0, $memoryUsage['percentage'] - 10), 
                    max(0, $memoryUsage['percentage'] - 5), 
                    $memoryUsage['percentage']
                ]),

            // CPU load stat
            Stat::make('CPU Load', $cpuUsage . '%')
                ->description('System average')
                ->descriptionIcon('fas-microchip')
                ->color($cpuUsage > 80 ? 'danger' : ($cpuUsage > 60 ? 'warning' : 'success'))
                ->chart([
                    max(0, $cpuUsage - 20),
                    max(0, $cpuUsage - 15), 
                    max(0, $cpuUsage - 10), 
                    max(0, $cpuUsage - 5), 
                    $cpuUsage
                ]),
                
            // Server uptime with PHP processes
            Stat::make('Server Uptime', $uptime['formatted'])
                ->description('PHP Processes: ' . $phpProcesses)
                ->descriptionIcon('fas-clock')
                ->color('primary'),
        ];
    }
    
    /**
     * Get memory usage information
     */
    private function getMemoryUsage(): array
    {
        // Default values
        $result = [
            'total' => 'N/A',
            'used' => 'N/A',
            'percentage' => 50, // Default to 50% for visualization
        ];
        
        // Try to get real values (works on Linux)
        if (function_exists('shell_exec')) {
            try {
                $free = shell_exec('free -m');
                if ($free !== null) {
                    $lines = explode("\n", $free);
                    $memory = explode(" ", preg_replace('/\s+/', ' ', $lines[1]));
                    
                    // Extract memory values
                    $total = intval($memory[1]);
                    $used = intval($memory[2]);
                    $percentage = round(($used / $total) * 100);
                    
                    $result = [
                        'total' => SystemHelper::formatBytes($total * 1024 * 1024),
                        'used' => SystemHelper::formatBytes($used * 1024 * 1024),
                        'percentage' => $percentage,
                    ];
                }
            } catch (\Exception $e) {
                Log::warning('Unable to get memory usage: ' . $e->getMessage());
            }
        }
        
        return $result;
    }
    
    /**
     * Get CPU usage information
     */
    private function getCpuUsage(): int
    {
        // Default value
        $cpuUsage = 35; // Default to 35% for visualization
        
        // Try to get real values (works on Linux)
        if (function_exists('shell_exec')) {
            try {
                $load = sys_getloadavg();
                $cpuCores = intval(shell_exec('nproc'));
                if ($load && $cpuCores > 0) {
                    // Calculate CPU usage percentage based on load average and number of cores
                    $cpuUsage = round(($load[0] / $cpuCores) * 100);
                    $cpuUsage = min(100, $cpuUsage); // Cap at 100%
                }
            } catch (\Exception $e) {
                Log::warning('Unable to get CPU usage: ' . $e->getMessage());
            }
        }
        
        return $cpuUsage;
    }
    
    /**
     * Get server uptime information
     */
    private function getServerUptime(): array
    {
        // Default values
        $result = [
            'seconds' => 0,
            'formatted' => 'Unknown',
            'started' => 'Unknown start time',
        ];
        
        // Try to get real values (works on Linux)
        if (function_exists('shell_exec')) {
            try {
                $uptime = shell_exec('uptime -s');
                $uptimeP = shell_exec('uptime -p');
                
                if ($uptime !== null) {
                    $startTime = strtotime(trim($uptime));
                    $now = time();
                    $uptimeSeconds = $now - $startTime;
                    
                    $formatted = trim(str_replace('up ', '', $uptimeP ?? ''));
                    if (empty($formatted)) {
                        // Format manually if uptime -p didn't work
                        $days = floor($uptimeSeconds / 86400);
                        $hours = floor(($uptimeSeconds % 86400) / 3600);
                        $minutes = floor(($uptimeSeconds % 3600) / 60);
                        
                        $formatted = '';
                        if ($days > 0) $formatted .= "$days days, ";
                        if ($hours > 0) $formatted .= "$hours hours, ";
                        $formatted .= "$minutes minutes";
                    }
                    
                    $result = [
                        'seconds' => $uptimeSeconds,
                        'formatted' => $formatted,
                        'started' => date('Y-m-d H:i', $startTime),
                    ];
                }
            } catch (\Exception $e) {
                Log::warning('Unable to get server uptime: ' . $e->getMessage());
            }
        }
        
        return $result;
    }
    
    /**
     * Get PHP process count
     */
    private function getPhpProcessCount(): int
    {
        // Default value
        $count = 3; // Default for visualization
        
        // Try to get real values (works on Linux)
        if (function_exists('shell_exec')) {
            try {
                $processCount = shell_exec('ps aux | grep php | grep -v grep | wc -l');
                if ($processCount !== null) {
                    $count = intval(trim($processCount));
                }
            } catch (\Exception $e) {
                Log::warning('Unable to get PHP process count: ' . $e->getMessage());
            }
        }
        
        return $count;
    }
}
