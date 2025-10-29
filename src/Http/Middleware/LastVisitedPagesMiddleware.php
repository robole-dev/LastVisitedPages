<?php

namespace Robole\LastVisitedPages\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Statamic\Contracts\Entries\Entry as EntriesEntry;
use Statamic\Facades\Data;

class LastVisitedPagesMiddleware
{
    public const SESSION_KEY = 'last_visited_pages';

    public function handle(Request $request, Closure $next)
    {
        // Wait for statamic (in case of redirects or page errors)
        $response = $next($request);

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        $entry = Data::findByRequestUrl($request->url());

        if ($entry) {
            $this->processRequest($request, $entry);
        }

        return $response;
    }

    private function processRequest(Request $request, mixed $entry)
    {
        if (!$entry instanceof EntriesEntry) {
            return;
        }

        $config = $this->getConfig();
        $entryBlueprint = $entry->blueprint->handle;
        $entryTemplate = $entry->template();
        $entrySite = $entry->site()->handle;

        if ($this->shouldExcludeEntry($entryBlueprint, $entryTemplate, $config)) {
            return;
        }

        $lastVisitedPages = collect($request->session()->get(self::SESSION_KEY, []));
        $lastVisitedPagesBySite = $lastVisitedPages->filter(fn($page) => $page['site'] === $entrySite);

        $this->removeOldestPage($lastVisitedPages, $lastVisitedPagesBySite, $config);

        if (! $this->isPageAlreadyVisited($lastVisitedPages, $entry->id)) {
            $this->addPageToSession($lastVisitedPages, $entry, $entrySite);
        }

        $request->session()->put(self::SESSION_KEY, $lastVisitedPages->all());
    }

    private function getConfig()
    {
        return [
            'siteSensitive' => config('last-visited-pages.site_sensitive', true),
            'maxSavedPages' => config('last-visited-pages.max_saved_pages', 5),
            'includeCollections' => config('last-visited-pages.include_collections', ['*']),
            'excludeCollections' => config('last-visited-pages.exclude_collections', []),
            'excludeTemplates' => config('last-visited-pages.exclude_templates', []),
        ];
    }

    private function shouldExcludeEntry($entryBlueprint, $entryTemplate, $config)
    {
        if (! in_array('*', $config['includeCollections']) && ! in_array($entryBlueprint, $config['includeCollections'])) {
            return true;
        }

        if (in_array($entryBlueprint, $config['excludeCollections'])) {
            return true;
        }

        if (in_array($entryTemplate, $config['excludeTemplates'])) {
            return true;
        }

        return false;
    }

    private function removeOldestPage($lastVisitedPages, $lastVisitedPagesBySite, $config)
    {
        // Remove oldest last visited page (site sensitive)
        if ($config['siteSensitive'] && $lastVisitedPagesBySite->count() >= $config['maxSavedPages']) {
            $lastVisitedPageKey = $lastVisitedPages->search($lastVisitedPagesBySite->first());
            $lastVisitedPages->forget($lastVisitedPageKey);
        }

        // Remove oldest last visited page (not site sensitive)
        if (! $config['siteSensitive'] && $lastVisitedPages->count() >= $config['maxSavedPages']) {
            $lastVisitedPages->shift();
        }
    }

    private function isPageAlreadyVisited($lastVisitedPages, $entryId)
    {
        return $lastVisitedPages->first(fn($page) => $page['id'] === $entryId);
    }

    private function addPageToSession($lastVisitedPages, $entry, $entrySite)
    {
        $lastVisitedPages->push([
            'id' => $entry->id(),
            'site' => $entrySite,
            'date' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
