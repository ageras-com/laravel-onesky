<?php

return [
    'default_project_id' => null,
    'base_locale'        => 'en',
    'translations_path' => 'resources/lang',

    'api_key' => getenv('ONESKY_API_KEY'),
    'secret' => getenv('ONESKY_SECRET'),
];
