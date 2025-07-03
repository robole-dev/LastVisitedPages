![GitHub release](https://flat.badgen.net/github/release/robole-dev/LastVisitedPages)
![Supports Statamic 5 or later](https://flat.badgen.net/badge/Statamic/5.0+/FF269E?icon=php)

# Last Visited Pages

> A Statamic addon that stores the most recently visited pages of a visitor.

## Features

- Save the most recently visited pages of visitors in their session.
- Customizable limits for the number of saved pages.
- Multisite compatibility to save and filter pages by site or across sites.
- Flexible inclusion and exclusion of collections.
- Provides the {{ last_visited_pages }} tag to display the saved pages in templates.

Note: This addon will skip non-entry-like page types (e.g. `LocalizedTerm`).

## Installation

Install this addon via Composer:

``` bash
composer require robole/last-visited-pages
```

## Configuration

The addon includes several configuration options that allow you to tailor its behavior. To publish the configuration file, run:

```bash
php artisan vendor:publish --tag=last-visited-pages-config
```

### Available Configuration Options

The published configuration file allows you to adjust the following settings:

__Maximum Saved Pages__

- Key: __max_saved_pages__
- Default: 5
- Description: Defines how many of the most recently visited pages will be saved in the session. If site_sensitive is enabled, this number is applied per site.

__Site Sensitivity__

- Key: __site_sensitive__
- Default: true
- Description: (Only relevant for multi-site mode) If enabled, only pages from the same site as the current one will be saved and displayed by the {{ last_visited_pages }} tag.

__Collections__

- Keys: __include_collections__, __exclude_collections__
- Default:
    ```php
    'include_collections' => ['*'],
    'exclude_collections' => [],
    ```
- Description:
    Use `include_collections` to specify which collections should be tracked. Set to `['*']` to include all collections.
    Use `exclude_collections` to define collections that should be ignored from tracking.
    Example:
    ```php
    'include_collections' => ['blog', 'products'],
    'exclude_collections' => ['drafts'],
    ```

## Templating

To display the last visited pages of the current fronted user, you can use the `{{ last_visited_pages }}` tag anywhere in your template:

```antlers
{{ nocache }}
    {{ if {last_visited_pages:count} > 0 }}
        {{ last_visited_pages }}
            <a href="{{ url }}">    
                {{ title }}
            </a>
        {{ /last_visited_pages }}
    {{ /if }}
{{ /nocache }}
```

## Support

If you encounter any issues or have questions, please open an issue in the [GitHub repository](https://github.com/robole-dev/LastVisitedPages).

## License

This addon is open-source and available under the MIT license.
