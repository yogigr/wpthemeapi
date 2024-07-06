<?php

namespace yogigr\WpThemeApi\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;
use yogigr\WpThemeApi\WpThemeApiServiceProvider;

class TestCase extends TestbenchTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            WpThemeApiServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
