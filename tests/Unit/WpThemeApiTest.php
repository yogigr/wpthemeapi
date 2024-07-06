<?php

namespace yogigr\WpThemeApi\Tests;

class WpThemeApiTest extends TestCase
{
    public function testGetToken()
    {
        $this->assertEquals(config('wpthemeapi.envato_token'), "");
    }
}