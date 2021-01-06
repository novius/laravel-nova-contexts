# Laravel Nova Contexts

This package allows you to manage resource contexts.

It provides :

* Default context choice during back-office navigation (on nova header).
* Context filter bases on default context.
* Context field for resources.

## Requirements

* PHP >= 7.4
* Laravel Framework >= 7.0

## Installation

```sh
composer require novius/laravel-nova-contexts
```

Add `LaravelNovaContexts` tool to `NovaServiceProvider`: 

```php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Novius\LaravelNovaContexts\LaravelNovaContexts;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    // ...
    
    public function tools()
    {
        return [
            new LaravelNovaContexts(),
        ];
    }
}

```

Override Nova Layout view to add context selector like bellow :

```blade
{{-- resources/views/vendor/nova/layout.blade.php --}}

@if (count(\Laravel\Nova\Nova::globallySearchableResources(request())) > 0)
    <global-search dusk="global-search-component"></global-search>
@endif

<laravel-nova-context-selector></laravel-nova-context-selector>

<dropdown class="ml-auto h-9 flex items-center dropdown-right">
    @include('nova::partials.user')
</dropdown>
```

## Configuration

Some options that you can override are available.

```sh
php artisan vendor:publish --provider="Novius\LaravelNovaContexts\LaravelNovaContextsServiceProvider" --tag="config"
```

## Models configuration

To make a model "contextable", just use `HasContext` trait.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Novius\LaravelNovaContexts\Traits\HasContext;

class Page extends Model
{
    use HasContext;

    /**
     * @return string
     */
    public function contextFieldName(): string
    {
        return 'locale';
    }
}
```

## Nova resource field configuration

You can add context field to your Nova resource's fields:

```php
public function fields(Request $request)
{
    return [
        // ...
        
        ContextField::make('locale'),
        
        // ...
    ];
}
```

## Nova resource filter configuration

You can add context filter to your Nova resource's filters :

```php
/**
 * Get the filters available for the resource.
 *
 * @param \Illuminate\Http\Request $request
 * @return array
 */
public function filters(Request $request)
{
    return [
        new ContextFilter($this->model()),
    ];
}
```

## Lint

Run php-cs with:

```sh
composer run-script lint
```

## Contributing

Contributions are welcome!

Leave an issue on Github, or create a Pull Request.

## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
