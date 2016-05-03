<?php

return [
    'base_locale'        => 'en',
    'file_format'        => 'PHP_SHORT_ARRAY',
    'translations_path'  => resource_path('lang'),
    'default_project_id' => null,

    'api_key' => getenv('ONESKY_API_KEY'),
    'secret'  => getenv('ONESKY_SECRET'),
];
