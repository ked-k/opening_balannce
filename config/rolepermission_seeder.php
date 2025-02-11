<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => env('LARATRUST_CREATE_USERS', false),

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => env('LARATRUST_TRUNCATE_TABLES', false),

    /**
     * Control if all the laratrust pivot tables should be truncated before running the seeder.
     */
    'truncate_pivot_tables' => env('LARATRUST_TRUNCATE_PIVOT_TABLES', false),

    /**
     * Control if default roles other than Admin should be created after seeding.
     */
    'seed_default_roles' => env('LARATRUST_SEED_DEFAULT_ROLES', false),

    'roles_structure' => [
        'Admin' => [
            'User Management' => [
                'access_user_management_module',

                'create_user',
                'view_user',
                'update_user',
                'delete_user',

                'create_role',
                'view_role',
                'update_role',
                'delete_role',
                'view_permission',
                'update_permission',
                'assign_role',
                'assign_permission',

                'view_login_activity',
                'view_activity_trail',
                'generate_user_management_reports',

                'view_all_meter_audits',
                'create_meter_audit',
                'receive_meter',
                'issue_meter',
                'access_key_centre',
                'request_for_key',
                'appprove_key_request',
                'view_reports',
                'access_settings',
            ],

        ],
    ],

    //Configure Default Roles and Permissions
    'default_roles' => [
        'Management_user' => [
            'view_all_meter_audits',
            'create_meter_audit',
            'receive_meter',
            'issue_meter',
            'access_key_centre',
            'request_for_key',
            'appprove_key_request',
            'view_reports',
            'access_settings',
            'create_user',
        ],
        'official_user' => [
            'view_all_meter_audits',
            'receive_meter',
            'issue_meter',
        ],
        'field_user' => [
            'create_meter_audit',
            'access_key_centre',
            'request_for_key',
        ],
    ],

];
