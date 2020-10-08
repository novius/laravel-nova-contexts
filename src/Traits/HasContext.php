<?php

namespace Novius\LaravelNovaContexts\Traits;

trait HasContext
{
    public function scopeContext($query, $context)
    {
        return $query->where($this->contextFieldName(), $context);
    }

    /**
     * @return string
     */
    public function contextFieldName(): string
    {
        return 'context';
    }
}
