<?php

namespace yogigr\WpThemeApi\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use yogigr\WpThemeApi\Facades\WpThemeApi;

class WpThemeApiTest extends TestCase
{
    public function testGetToken()
    {
        $this->assertEquals(config('wpthemeapi.envato_token'), env('ENVATO_TOKEN'));
    }

    public function testGetCategories()
    {
        // Mock the HTTP response
        Http::fake([
            'https://api.envato.com/v1/market/categories:themeforest.json' => Http::response([
                'categories' => [
                    ['path' => 'wordpress/themes'],
                    ['path' => 'wordpress/plugins'],
                    ['path' => 'joomla/themes']
                ]
            ], 200)
        ]);

        $categories = WpThemeApi::categories();
        $this->assertInstanceOf(Collection::class, $categories);
        $this->assertTrue($categories->isNotEmpty());
    }

    public function testGetItems()
    {
        // Mock the HTTP response
        Http::fake([
            'https://api.envato.com/v1/discovery/search/search/item' => Http::response([
                'matches' => [
                    [
                        'id' => 1,
                        'name' => 'Theme 1',
                        'classification' => 'wordpress',
                        'price_cents' => 2000,
                        'number_of_sales' => 100,
                        'published_at' => '2021-01-01T00:00:00Z',
                        'updated_at' => '2021-01-02T00:00:00Z',
                        'rating' => 4.5,
                        'previews' => [
                            'live_site' => ['url' => 'http://example.com'],
                            'icon_with_landscape_preview' => ['landscape_url' => 'http://example.com/image.jpg']
                        ],
                        'key_features' => ['Feature 1', 'Feature 2'],
                        'discounts' => ['Discount 1', 'Discount 2']
                    ],
                    // Tambahkan data lain jika diperlukan
                ],
                'links' => [
                    'next' => 'http://example.com/next',
                    'prev' => 'http://example.com/prev'
                ]
            ], 200)
        ]);

        $items = WpThemeApi::items();
        $this->assertInstanceOf(Collection::class, $items);
        $this->assertTrue($items->has('links'));
        $this->assertTrue($items->has('themes'));
        $this->assertInstanceOf(Collection::class, $items['themes']);
        $this->assertTrue($items['themes']->isNotEmpty());
    }
}
