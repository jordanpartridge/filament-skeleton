<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SecurityWidget extends BaseWidget
{
    // Auto-refresh every hour
    protected static ?string $pollingInterval = '3600s';
    
    // Make it half width on medium screens
    protected int|string|array $columnSpan = [
        'default' => 'full',
        'md' => 1, // Half width on medium screens
    ];
    
    protected function getStats(): array
    {
        // Get failed login attempts (example)
        $failedLogins = $this->getFailedLogins();
        
        // Get account lockouts (example)
        $accountLockouts = $this->getAccountLockouts();
        
        // Get PHP security status
        $securityStatus = $this->getSecurityStatus();
        
        return [
            Stat::make('Failed Logins', $failedLogins['count'])
                ->description($failedLogins['period'])
                ->descriptionIcon('heroicon-m-shield-exclamation')
                ->color($failedLogins['count'] > 10 ? 'danger' : ($failedLogins['count'] > 5 ? 'warning' : 'success'))
                ->chart($failedLogins['chart']),
                
            Stat::make('Account Lockouts', $accountLockouts['count'])
                ->description($accountLockouts['period'])
                ->descriptionIcon('heroicon-m-lock-closed')
                ->color($accountLockouts['count'] > 0 ? 'danger' : 'success')
                ->chart($accountLockouts['chart']),

            Stat::make('Security Status', $securityStatus['status'])
                ->description($securityStatus['description'])
                ->descriptionIcon($securityStatus['icon'])
                ->color($securityStatus['color']),
        ];
    }
    
    /**
     * Get failed login attempts
     */
    private function getFailedLogins(): array
    {
        // In a real application, you'd query your authentication logs
        // This is just a simulation
        
        // Example query if you're using Laravel's authentication log:
        // $count = DB::table('authentication_log')
        //    ->where('login_successful', false)
        //    ->where('login_at', '>=', now()->subDay())
        //    ->count();
        
        // For demonstration:
        $count = rand(0, 15);
        
        // Generate random chart data for visualization
        $chartData = [
            max(0, $count - 8 + rand(-2, 2)),
            max(0, $count - 6 + rand(-2, 2)),
            max(0, $count - 4 + rand(-2, 2)),
            max(0, $count - 2 + rand(-2, 2)),
            $count
        ];
        
        return [
            'count' => $count,
            'period' => 'Last 24 hours',
            'chart' => $chartData,
        ];
    }
    
    /**
     * Get account lockouts
     */
    private function getAccountLockouts(): array
    {
        // In a real application, you'd query your authentication logs
        // This is just a simulation
        
        // Example query if you have a lockout tracking system:
        // $count = DB::table('lockouts')
        //    ->where('created_at', '>=', now()->subWeek())
        //    ->count();
        
        // For demonstration:
        $count = rand(0, 3);
        
        // Generate chart data for visualization
        $chartData = [0, 0, 0, 0, 0, 0, 0];
        for ($i = 0; $i < $count; $i++) {
            $day = rand(0, 6);
            $chartData[$day]++;
        }
        
        return [
            'count' => $count,
            'period' => 'Last 7 days',
            'chart' => $chartData,
        ];
    }
    
    /**
     * Get security status of the application
     */
    private function getSecurityStatus(): array
    {
        // Default values
        $result = [
            'status' => 'Good',
            'description' => 'No issues detected',
            'icon' => 'heroicon-m-check-circle',
            'color' => 'success',
        ];
        
        // Check various security indicators
        $checks = [
            'app_debug' => config('app.debug'),
            'https' => request()->secure(),
            'environment' => app()->environment() === 'production',
        ];
        
        // Simple logic to determine status
        if ($checks['app_debug'] === true) {
            $result = [
                'status' => 'Warning',
                'description' => 'Debug mode enabled',
                'icon' => 'heroicon-m-exclamation-triangle',
                'color' => 'warning',
            ];
        }
        
        if (!$checks['https'] && $checks['environment']) {
            $result = [
                'status' => 'Danger',
                'description' => 'HTTPS not enabled',
                'icon' => 'heroicon-m-x-circle',
                'color' => 'danger',
            ];
        }
        
        return $result;
    }
}
