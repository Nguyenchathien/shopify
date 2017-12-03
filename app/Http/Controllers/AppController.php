<?php

namespace App\Http\Controllers;

class AppController extends Controller
{

    protected function checkAuthenticationShopify()
    {
        $api_key = env('SHOPIFY_API_KEY')?env('SHOPIFY_API_KEY'):'';
        $api_password = env('SHOPIFY_API_PASSWORD')?env('SHOPIFY_API_PASSWORD'):'';

        if(empty($api_key) || empty($api_password)) {
            return false;
        }

        return true;
    }
    
}
