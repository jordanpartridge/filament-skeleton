<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SecuritySummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.security-summary-widget';
    
    // Auto-refresh every 30 seconds
    protected static ?string $pollingInterval = '30s';
    
    // Make it span full width
    protected int|string|array $columnSpan = 'full';
    
    public function getSecurityData()
    {
        // Simulated security data
        return [
            'failedLogins' => rand(0, 5),
            'accountLockouts' => rand(0, 3),
            'securityStatus' => [
                'status' => rand(0, 10) > 3 ? 'ok' : 'warning',
                'message' => rand(0, 10) > 3 ? 'All systems secure' : 'Debug mode enabled'
            ],
            'lastCheck' => now()->subMinutes(rand(5, 30))->format('H:i'),
            'recentEvents' => [
                [
                    'type' => 'login',
                    'user' => 'admin@example.com',
                    'time' => now()->subMinutes(15)->format('H:i'),
                    'status' => 'success'
                ],
                [
                    'type' => 'permission',
                    'user' => 'user@example.com',
                    'time' => now()->subHours(2)->format('H:i'),
                    'status' => 'denied'
                ],
                [
                    'type' => 'login',
                    'user' => 'guest@example.com',
                    'time' => now()->subHours(3)->format('H:i'),
                    'status' => 'failed'
                ],
            ]
        ];
    }
}
