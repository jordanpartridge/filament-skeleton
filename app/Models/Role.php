<?php

namespace App\Models;

use App\Concerns\LogsFillable;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends \Spatie\Permission\Models\Role
{
    use LogsActivity;
    use LogsFillable;


}
