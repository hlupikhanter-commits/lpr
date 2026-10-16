<?php

return [
    'student' => env('LAB_STUDENT', 'Не указан'),
    'slug' => env('LAB_SLUG', 'unknown'),
    'group' => env('LAB_GROUP', ''),
    'number' => (int) env('LAB_N', 0),
    'code' => env('LAB_CODE', '—'),
];
