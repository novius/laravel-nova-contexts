# Laravel Nova Contexts

This package allows you to manage resource contexts.

It provides :

* Default context choice during back-office navigation (on nova card).
* Context filter bases on default context.
* Context field for resources.

## Requirements

* PHP >= 8.0
* Laravel Nova >= 4.0

> **NOTE**: These instructions are for Laravel Nova >= 4.0. If you are using prior version, please
> see the [previous version's docs](https://github.com/novius/laravel-nova-contexts/tree/1.x).


## Installation

```sh
composer require novius/laravel-nova-contexts
```

## Configuration

Some options that you can override are available.

```sh
php artisan vendor:publish --provider="Novius\LaravelNovaContexts\LaravelNovaContextsServiceProvider" --tag="config"
```

## Context selector

A card is available to navigate between contexts. You can easily add it to custom resource index.

```php
<?php

namespace App\Models;

use Laravel\Nova;
use Novius\LaravelNovaContexts\LaravelNovaContexts;

class Page extends Resource
{
    // Some resources definitions...
    
    public function cards(Request $request)
    {
        return [
            (new LaravelNovaContexts())->dynamicHeight(),
        ];
    }
}

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
