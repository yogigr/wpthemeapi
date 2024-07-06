# wpthemeapi
A Laravel package for browsing WordPress themes using the Envato API. This package allows you to easily search, filter, and retrieve information about WordPress themes from Envato, streamlining the process of finding the perfect theme for your website.

## Installation

To install the `WpThemeApi` package, follow these steps:

1. **Require the Package via Composer**

   Run the following command in your Laravel project directory:

   ```bash
   composer require yogigr/wpthemeapi
   ```

2. **Publish the Configuration File**
   
   Publish the configuration file using the following command:

   ```bash
   php artisan vendor:publish --provider="yogigr\WpThemeApi\Providers\WpThemeApiServiceProvider"
   ```

3. **Set Up Environment Variables**

   Add your Envato API token to your .env file:

   ```env
    ENVATO_TOKEN=your-envato-api-token
    ```

## Usage

After installation, you can use the package via the provided Facade. Below are examples of how to fetch categories and items.

### Fetch Categories

To fetch WordPress themes categories:

```php
use yogigr\WpThemeApi\Facades\WpThemeApi;

$categories = WpThemeApi::categories();

foreach ($categories as $category) {
    echo $category['name'] . ' - ' . $category['path'] . PHP_EOL;
}
```

Parameters for \`categories\`

- \`string $path\` : The path filter for categories. Default is "wordpress/". Only categories that contain this path will be returned.

### Fetch Items

To fetch items:

```php
use yogigr\WpThemeApi\Facades\WpThemeApi;

$items = WpThemeApi::items();

foreach ($items['themes'] as $item) {
    echo $item['name'] . ' - ' . $item['price_cents'] / 100 . ' USD' . PHP_EOL;
}
```

Parameters for \`items\`

- \`string $category\`: The category of items to fetch. Default is "wordpress".
- \`string $sortBy\`: The attribute to sort the items by. Sort by one of the following: "relevance", "rating", "sales", "price", "date", "updated", "category", "name", "trending", "featured_until". Default is "sales".
- \`string $sortDir\`: The direction to sort the items ("asc" for ascending, "desc" for descending). Default is "desc".
- \`int $perPage\`: The number of items to fetch per page. Default is 10.
- \`int $page\`: The page number to fetch. Default is 1.