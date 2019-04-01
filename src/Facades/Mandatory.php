<?php

namespace Plum\Form\Facades;

use Illuminate\Support\Facades\Facade;

class Mandatory extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mandatory';
    }
}
