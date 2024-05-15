<?php

namespace BizyTech\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class AuthorizationService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Bizytech\Auth\Services\AuthorizationService::class;
    }
}
