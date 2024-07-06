<?php

namespace yogigr\WpThemeApi;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class WpThemeApi
{
    private $token;
    private $client;

    public function __construct($token)
    {
        $this->token = $token;
        $this->client = new Client([
            'base_uri' => 'https://api.envato.com/'
        ]);
    }

    private function request($endpoint, $query = [])
    {
        $response = $this->client->get($endpoint, [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'query' => $query
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        }

        throw new \Exception('Error fetching data from API');
    }

    public function categories(string $path = "wordpress/"): Collection
    {
        $data = $this->request('v1/market/categories:themeforest.json');
        $filteredCategories = collect($data['categories'])
            ->filter(function ($category) use ($path) {
                return strpos($category['path'], $path) !== false;
            })
            ->values(); // Menghapus kunci numerik dan hanya mempertahankan nilai

        return $filteredCategories;
    }

    public function items(
        string $category = "wordpress",
        string $sortBy = 'sales',
        string $sortDir = 'desc',
        int $perPage = 10,
        int $page = 1
    ): Collection {
        $raw = $this->request(
            endpoint: 'v1/discovery/search/search/item',
            query: [
                'site' => 'themeforest.net',
                'category' => $category,
                'tags' => 'simple',
                'sort_by' => $sortBy,
                'sort_direction' => $sortDir,
                'page_size' => $perPage,
                'page' => $page
            ]
        );

        $themes = collect($raw['matches'])->map(function ($item) {
            return $this->transformItem($item);
        });

        return collect([
            'links' => $raw['links'],
            'themes' => $themes
        ]);
    }

    protected function transformItem(array $item): array
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'classification' => $item['classification'],
            'price_cents' => $item['price_cents'],
            'number_of_sales' => $item['number_of_sales'],
            'published_at' => $item['published_at'],
            'updated_at' => $item['updated_at'],
            'rating' => $item['rating'],
            'previews' => [
                'url' => $item['previews']['live_site']['url'],
                'image' => $item['previews']['icon_with_landscape_preview']['landscape_url']
            ],
            'key_features' => $item['key_features'],
            'discounts' => $item['discounts']
        ];
    }
}
