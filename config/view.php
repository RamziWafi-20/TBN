<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Paths where your Blade templates are stored.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where the compiled Blade templates will be
    | stored. We explicitly use storage_path() so Laravel always gets
    | a valid absolute path on Windows/XAMPP.
    |
    */

    'compiled' => storage_path('framework/views'),

    /*
    |--------------------------------------------------------------------------
    | Relative Hashes
    |--------------------------------------------------------------------------
    |
    | Determine whether compiled view hashes should use relative paths.
    |
    */

    'relative_hash' => false,

    /*
    |--------------------------------------------------------------------------
    | View Cache
    |--------------------------------------------------------------------------
    |
    | Determine whether Blade should cache compiled views.
    |
    */

    'cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Compiled Extension
    |--------------------------------------------------------------------------
    |
    | The file extension used for compiled Blade templates.
    |
    */

    'compiled_extension' => 'php',

    /*
    |--------------------------------------------------------------------------
    | Check Cache Timestamps
    |--------------------------------------------------------------------------
    |
    | Determine whether Laravel should check the timestamps of Blade
    | templates before recompiling them.
    |
    */

    'check_cache_timestamps' => true,

];