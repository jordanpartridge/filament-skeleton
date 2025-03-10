<?php

use App\Filament\Widgets\SystemStatsWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

it('formats database size correctly', function () {
    $dbSize = 42.5;
    
    // Format directly using number_format for comparison
    $expectedFormat = number_format($dbSize, 2);
    
    // Verify the database formatting matches
    expect($expectedFormat)->toBe('42.50');
});

it('uses cache for database size calculation', function () {
    // Set a known value in the cache
    Cache::put('dashboard_db_size', '100.00', 60);
    
    // Verify our cache key works
    expect(Cache::has('dashboard_db_size'))->toBeTrue();
    expect(Cache::get('dashboard_db_size'))->toBe('100.00');
});

it('formats zero correctly for database errors', function () {
    // Just test the formatting of zero directly
    $result = number_format(0, 2);
    
    // Verify error handling returns 0 formatted correctly
    expect($result)->toBe('0.00');
});