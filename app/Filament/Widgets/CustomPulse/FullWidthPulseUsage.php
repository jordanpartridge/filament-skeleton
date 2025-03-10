<?php

namespace App\Filament\Widgets\CustomPulse;

use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;

class FullWidthPulseUsage extends PulseUsage
{
    // Make the usage widget full width
    protected int|string|array $columnSpan = 'full';
}
