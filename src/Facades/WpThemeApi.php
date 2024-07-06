<?php

namespace yogigr\WpThemeApi\Facades;

use Illuminate\Support\Facades\Facade;

class WpThemeApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp-theme-api';
    }
}