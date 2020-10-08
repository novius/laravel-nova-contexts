<?php

namespace Novius\LaravelNovaContexts\Fields;

use Laravel\Nova\Fields\Select;

class ContextField extends Select
{
    public function options($useless)
    {
        return $this;
    }

    public function meta()
    {
        return $this->addContextOptions()->meta;
    }

    protected function addContextOptions()
    {
        $options = collect(app()->get('context_manager')->contexts())
            ->pluck('public_name', 'context_key');

        return $this->withMeta([
            'options' => collect($options ?? [])->map(function ($label, $value) {
                return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
            })->values()->all(),
            'value' => $this->value ?? (app()->get('context_manager')->currentContext()),
        ]);
    }
}
