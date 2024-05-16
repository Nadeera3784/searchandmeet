<?php

return [
    'google' => [
        'auth_config' => base_path() . '/creds/searchmeetings-b1fc6446aeec.json',

        'scopes' => [
            \Google_Service_Indexing::INDEXING,
        ],
    ],
];
