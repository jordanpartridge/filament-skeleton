<?php

namespace App\Filament\Widgets\CustomPulse;

use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;

class FullWidthPulseCache extends PulseCache
{
    // Make the cache widget full width
    protected int|string|array $columnSpan = 'full';
}
