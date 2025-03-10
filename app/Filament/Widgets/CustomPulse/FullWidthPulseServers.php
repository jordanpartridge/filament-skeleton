<?php

namespace App\Filament\Widgets\CustomPulse;

use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;

class FullWidthPulseServers extends PulseServers
{
    // Make the servers widget full width
    protected int|string|array $columnSpan = 'full';
}
