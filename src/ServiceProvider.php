<?php

namespace Robole\LastVisitedPages;

use Robole\LastVisitedPages\Http\Middleware\LastVisitedPagesMiddleware;
use Robole\LastVisitedPages\Tags\LastVisitedPages;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        LastVisitedPages::class,
    ];

    protected $middlewareGroups = [
        'statamic.web' => [
            LastVisitedPagesMiddleware::class,
        ],
    ];
}
