<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UserStatsWidget;
use App\Filament\Widgets\UserSignupChartWidget; 
use App\Filament\Widgets\LatestUsersWidget;
use Filament\Pages\Dashboard;

/**
 * User Dashboard Page
 * 
 * Provides a dedicated dashboard for user management features
 * including user statistics, signup trends, and a list of recently added users.
 */
class UserDashboard extends Dashboard
{
    // Set the route path
    protected static string $routePath = '/user-dashboard';
    
    // Set a proper title for the page
    protected static ?string $title = 'User Management';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'User Dashboard';
    
    // Place this dashboard under User Management in the navigation
    protected static ?string $navigationGroup = 'User Management';
    
    // Set the navigation sort order
    protected static ?int $navigationSort = 1;

    /**
     * Configure the dashboard layout with responsive columns
     * 
     * @return array|int
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'lg' => 3,
        ];
    }

    /**
     * Define which widgets appear on the dashboard
     * 
     * @return array
     */
    public function getWidgets(): array
    {
        return [
            // User stats widget at the top
            UserStatsWidget::class,
            
            // Add user signup chart if it exists
            UserSignupChartWidget::class,
            
            // Latest users at the bottom
            LatestUsersWidget::class,
        ];
    }
}
