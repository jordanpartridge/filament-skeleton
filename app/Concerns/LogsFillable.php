<?php

namespace App\Concerns;

use Spatie\Activitylog\LogOptions;

trait LogsFillable
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
