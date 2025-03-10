<?php

namespace App\Filament\Widgets\CustomPulse;

use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;

class SpanTwoPulseQueues extends PulseQueues
{
    // Make the queues widget span 2 columns
    protected int|string|array $columnSpan = 2;
}
