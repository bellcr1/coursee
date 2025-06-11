<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // وقت التجربة ينجم يكون '*'
    'allowed_headers' => ['*'],
    'supports_credentials' => false, // لازم false مع token only
];
