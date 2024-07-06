<?php

namespace yogigr\WpThemeApi;

use Illuminate\Support\ServiceProvider;

class WpThemeApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'wpthemeapi');

        $this->app->bind('wp-theme-api', function($app) {
            $token = config('wpthemeapi.envato_token');
            return new WpThemeApi($token);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('wpthemeapi.php'),
        ], 'config');
    }
}
