<?php

return [
    'models' => [
        'namespace' => 'Thtg88\\MmCms\\Models\\',
    ],
    'modules' => [
        'namespace' => 'Thtg88\\MmCms'
    ],
    'roles' => [
        'developer_role_name' => env('MMCMS_ROLES_DEVELOPER_NAME', 'dev'),
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
    'pagination' => [
        'columns' => ['*'],
        'page_name' => env('MMCMS_PAGINATION_PAGE_NAME', 'page'),
        'page_size' => env('MMCMS_PAGINATION_PAGE_SIZE', 10),
    ],
];
