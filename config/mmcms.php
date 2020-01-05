<?php

return [
    'events' => [
        'namespace' => 'Thtg88\\MmCms\\Events\\',
    ],
    'listeners' => [
        'namespace' => 'Thtg88\\MmCms\\Listeners\\',
    ],
    'models' => [
        'namespace' => 'Thtg88\\MmCms\\Models\\',
    ],
    'modules' => [
        'namespace' => 'Thtg88\\MmCms'
    ],
    'roles' => [
        'administrator_role_name' => env('MMCMS_ROLES_ADMINISTRATOR_NAME', 'admin'),
        'developer_role_name' => env('MMCMS_ROLES_DEVELOPER_NAME', 'dev'),
        'user_role_name' => env('MMCMS_ROLES_USER_NAME', 'user'),
    ],
    'passport' => [
        'oauth_url' => env('MMCMS_OAUTH_URL', 'http://localhost'),
        'personal_client_id' => env('MMCMS_PERSONAL_CLIENT_ID'),
        'personal_client_secret' => env('MMCMS_PERSONAL_CLIENT_SECRET'),
        'password_client_id' => env('MMCMS_PASSWORD_CLIENT_ID'),
        'password_client_secret' => env('MMCMS_PASSWORD_CLIENT_SECRET'),
    ],
    'journal' => [
        'mode' => env('MMCMS_JOURNAL_MODE', true),
    ],
    'recaptcha' => [
        'mode' => env('MMCMS_RECAPTCHA_MODE', true),
    ],
    'pagination' => [
        'columns' => ['*'],
        'page_name' => env('MMCMS_PAGINATION_PAGE_NAME', 'page'),
        'page_size' => env('MMCMS_PAGINATION_PAGE_SIZE', 10),
    ],
];
