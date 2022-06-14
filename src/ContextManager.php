<?php

namespace Novius\LaravelNovaContexts;

use Illuminate\Support\Arr;
use Novius\Gli\Exceptions\ContextNotFoundException;

class ContextManager
{
    public const CONTEXT_KEY_ALL = 'all';

    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function currentContext(): string
    {
        return session()->get($this->sessionKey(), '');
    }

    /**
     * @param bool $includeAll : include "ALL" context data ?
     * @return array
     */
    public function contexts(bool $includeAll = false): array
    {
        $currentContext = $this->currentContext();
        $contexts = collect((array) Arr::get($this->config, 'contexts', []))
            ->filter(function ($value) {
                return !empty($value['context_key']) && !empty($value['public_name_trans_key']);
            })
            ->map(function ($value) use ($currentContext) {
                $value['current'] = ($currentContext === Arr::get($value, 'context_key', ''));
                $value['public_name'] = trans('laravel-nova-contexts::contexts.context_public_name_'.$value['public_name_trans_key']);

                return $value;
            });

        if ($includeAll) {
            $contexts->prepend($this->contextAllData($currentContext));
        }

        return $contexts->toArray();
    }

    /**
     *
     */
    public function clearCurrentContext()
    {
        session()->forget($this->sessionKey());
    }

    /**
     * @param string $context
     * @throws ContextNotFoundException
     */
    public function setCurrentContext(string $context)
    {
        $contexts = collect($this->contexts());
        $selectedContext = $contexts->firstWhere('context_key', $context);

        if (empty($selectedContext)) {
            throw new ContextNotFoundException('Unable to set current context : not found in configuration.');
        }

        session()->put($this->sessionKey(), $context);
    }

    /**
     * @param string $currentContext
     * @return array
     */
    protected function contextAllData(string $currentContext): array
    {
        return [
            'context_key' => self::CONTEXT_KEY_ALL,
            'public_name' => trans('laravel-nova-contexts::contexts.context_all_public_name'),
            'current' => empty($currentContext),
        ];
    }

    /**
     * @return string
     */
    protected function sessionKey(): string
    {
        return Arr::get($this->config, 'session_key', '');
    }
}
