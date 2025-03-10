<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserSignupChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Signups';
    
    // Configure widget dimensions - half width on medium screens and up
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1, // Take up half the width on medium screens
    ];
    
    protected function getData(): array
    {
        // Fetch signups from the last 30 days
        $users = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();
        
        // Prepare data structure for the chart
        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $users->pluck('count')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#2196F3',
                ],
            ],
            'labels' => $users->pluck('date')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}
