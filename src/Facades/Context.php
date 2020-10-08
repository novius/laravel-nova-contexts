<?php

namespace Novius\Gli\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GliApi
 *
 * @package Novius\Gli\Facades
 * @see GliApiManager
 */
class Context extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'context_manager';
    }
}
