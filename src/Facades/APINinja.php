<?php

namespace BataBoom\APINinja\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BataBoom\APINinja\APINinja
 */
class APINinja extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BataBoom\APINinja\APINinja::class;
    }
}
