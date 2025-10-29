<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Maximum saved pages
    |--------------------------------------------------------------------------
    |
    | Define how many most recently visited pages should be saved in session.
    | In case 'site_sensitive' is true, this number will be applied per site.
    |
    */

    'max_saved_pages' => 5,

    /*
    |--------------------------------------------------------------------------
    | Site sensitive
    |--------------------------------------------------------------------------
    |
    | If true, only pages from the same site will be saved in session and
    | returned by the {{ last_visited_pages }} tag.
    |
    */

    'site_sensitive' => true,

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    | To include all collections use:
    |
    |     'include_collections' => ['*'],
    |
    |     'exclude_collections' => [],
    |
    */

    'include_collections' => ['*'],

    'exclude_collections' => [],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    | Define which templates should be excluded from tracking.
    |
    */
    'exclude_templates' => [],
];
