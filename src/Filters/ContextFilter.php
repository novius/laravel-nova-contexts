<?php

namespace Novius\LaravelNovaContexts\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ContextFilter extends Filter
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
        $this->name = trans('laravel-nova-contexts::contexts.context_filter_label');
    }

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where(with(new $this->model)->contextFieldName(), $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return collect(app()->get('context_manager')
            ->contexts())
            ->pluck('context_key', 'public_name');
    }

    /**
     * Set the default options for the filter.
     *
     * @return array|mixed
     */
    public function default()
    {
        return app()->get('context_manager')->currentContext();
    }
}
