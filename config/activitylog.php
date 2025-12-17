<?php

return [
    'enabled' => env('ACTIVITY_LOG_ENABLED', true),
    'default_log_name' => 'default',
    'activity_model' => Spatie\Activitylog\Models\Activity::class,
];
