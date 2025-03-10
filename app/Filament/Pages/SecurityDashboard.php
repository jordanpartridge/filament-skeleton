<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SecuritySummaryWidget;
use Filament\Pages\Dashboard;

class SecurityDashboard extends Dashboard
{
    // Set the route path
    protected static string $routePath = '/security-dashboard';
    
    // Set a proper title for the page
    protected static ?string $title = 'Security Dashboard';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'Security';
    
    // Place this dashboard under System Monitoring in the navigation
    protected static ?string $navigationGroup = 'System Monitoring';
    
    // Set the navigation sort order
    protected static ?int $navigationSort = 3;

    // Configure the dashboard layout
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
        ];
    }

    // Define which widgets appear on the dashboard
    public function getWidgets(): array
    {
        return [
            // Security metrics
            SecuritySummaryWidget::class,
        ];
    }
}
