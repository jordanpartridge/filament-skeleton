<?php

namespace App\Filament\Widgets\CustomPulse;

use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;

class SpanTwoPulseCache extends PulseCache
{
    // Make the cache widget span 2 columns
    protected int|string|array $columnSpan = 2;
}
