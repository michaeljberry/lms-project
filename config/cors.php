<?php

$stateful = array_filter(array_map('trim', explode(',', env('SANCTUM_STATEFUL_DOMAINS', ''))));

if ($session = env('SESSION_DOMAIN')) {
    $stateful[] = ltrim($session, '.');
}

$origins = [env('APP_URL', 'http://localhost')];

foreach ($stateful as $domain) {
    $origins[] = 'http://' . $domain;
    $origins[] = 'https://' . $domain;
}

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => array_values(array_unique($origins)),
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
