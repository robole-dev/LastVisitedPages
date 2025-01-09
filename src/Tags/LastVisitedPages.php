<?php

namespace Robole\LastVisitedPages\Tags;

use Robole\LastVisitedPages\Http\Middleware\LastVisitedPagesMiddleware;
use Statamic\Facades\Entry;
use Statamic\Tags\Tags;

class LastVisitedPages extends Tags
{
    public function index(): ?array
    {
        $site = $this->context->get('site')->handle;
        $siteSensitive = config('last-visited-pages.site_sensitive', true);

        $lastVisitedPages = collect(session(LastVisitedPagesMiddleware::SESSION_KEY, []));

        $lastVisitedPages = $lastVisitedPages
            ->filter(fn($lastVisitedPage) => $siteSensitive ? $lastVisitedPage['site'] === $site : true)
            ->map(fn($lastVisitedPage) => Entry::find($lastVisitedPage['id']));

        return $lastVisitedPages->all();
    }

    public function count(): int
    {
        $lastVisitedPages = $this->index() ?? [];

        return count($lastVisitedPages);
    }
}
