<?php

namespace App\Providers;

use App;
use ShopifyApi\Manager;
use ShopifyApi\Models\Product;
use ShopifyApi\Providers\ShopifyServiceProvider as BaseServiceProvider;

/**
 * Class ShopifyServiceProvider
 */
class ShopifyServiceProvider extends BaseServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        /** @var Manager $shopify */
        $shopify = app('shopify');

        $shopify->setApiCache(Product::class, function($client, $params = null) {

            // No caching for collections.
            if (is_array($params)) {
                // Returning falsy will result in the default api behavior.
                return null;
            }
            
            $key = "shopify_product_".((string) $params);
            
            // Assuming you Cache::put($key, $product->getData()); elsewhere
            // If the cache is empty, the resource will be fetched from the api
            // as normal.
            $data = Cache::get($key);
            
            return $data ? new Product($client, $data) : null;
        });
    }
}
