<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UserStatsWidget;
use App\Filament\Widgets\UserSignupChartWidget;
use App\Filament\Widgets\LatestUsersWidget;
use Filament\Pages\Dashboard;

class UserDashboard extends Dashboard
{
    // Set the route path
    protected static string $routePath = '/user-dashboard';
    
    // Set a proper title for the page
    protected static ?string $title = 'User Dashboard';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'User Dashboard';
    
    // Set proper navigation icon
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    // Place this dashboard under User Management in the navigation
    protected static ?string $navigationGroup = 'User Management';
    
    // Set the navigation sort order
    protected static ?int $navigationSort = 1;

    // Configure the dashboard layout
    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'md' => 2,
        ];
    }

    // Define which widgets appear on the dashboard
    public function getWidgets(): array
    {
        return [
            // User stats widget at the top
            UserStatsWidget::class,
            
            // User signup chart
            UserSignupChartWidget::class,
            
            // Latest users at the bottom
            LatestUsersWidget::class,
        ];
    }
}
