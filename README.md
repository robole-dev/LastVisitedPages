<div align="center">
    <img src="icon.svg">
    <h1>Last Visited Pages</h1>
    <blockquote>
        <p dir="auto">Statamic addon that stores the most recently visited pages of a visitor.</p>
    </blockquote>
</div>

![GitHub release](https://flat.badgen.net/github/release/robole-dev/LastVisitedPages)
![Supports Statamic 5 or later](https://flat.badgen.net/badge/Statamic/5.0+/FF269E?icon=php)

## Features

- Save the most recently visited pages of visitors in their session
- Customizable limits for the number of saved pages
- Multisite compatibility to save and filter pages by site or across sites
- Flexible inclusion and exclusion of collections
- Provides the `{{ last_visited_pages }}` tag to display the saved pages in templates

Note: This addon will skip non-entry-like page types (e.g. `LocalizedTerm`).

## Installation

Install this addon via Composer:

```bash
composer require robole/last-visited-pages
```

## Configuration

The addon includes several configuration options that allow you to tailor its behavior. To publish the configuration file, run:

```bash
php artisan vendor:publish --tag=last-visited-pages-config
```

### Available Configuration Options

The published configuration file allows you to adjust the following settings:

**Maximum Saved Pages**

- Key: **max_saved_pages**
- Default: 5
- Description: Defines how many of the most recently visited pages will be saved in the session. If site_sensitive is enabled, this number is applied per site.

**Site Sensitivity**

- Key: **site_sensitive**
- Default: true
- Description: (Only relevant for multi-site mode) If enabled, only pages from the same site as the current one will be saved and displayed by the {{ last_visited_pages }} tag.

**Collections**

- Keys: **include_collections**, **exclude_collections**
- Default:
  ```php
  'include_collections' => ['*'],
  'exclude_collections' => [],
  ```
- Description:
  Use `include_collections` to specify which collections should be tracked. Set to `['*']` to include all collections.
  Use `exclude_collections` to define collections that should be ignored from tracking.
- Example:
  ```php
  'include_collections' => ['blog', 'products'],
  'exclude_collections' => ['drafts'],
  ```

**Templates**

- Key: **exclude_templates**
- Default:
  ```php
  'exclude_templates' => [],
  ```
- Description:
  Use `exclude_templates` to define templates that should be ignored from tracking. 
- Example:
  ```php
  'exclude_templates' => ['service', 'article'],
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
