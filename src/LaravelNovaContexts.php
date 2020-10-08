<?php

namespace Novius\LaravelNovaContexts;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class LaravelNovaContexts extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('laravel-nova-contexts', __DIR__.'/../dist/js/tool.js');
        Nova::style('laravel-nova-contexts', __DIR__.'/../dist/css/tool.css');
    }
}
