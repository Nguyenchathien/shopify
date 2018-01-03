<?php

namespace App\Http\Controllers;

class AppController extends Controller
{

    protected function sendRequest($data, $path, $method)
    {
        $data_string = json_encode($data);
        // dd($data_string);
        $url  = env('SHOPIFY_DOMAIN'). $path ;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);     
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "a786358691674f05f5b85ced9fff16e1:32b5acb980ce193f4a81fc406e6348cd");
        curl_setopt($curl, CURLOPT_USERPWD, env('SHOPIFY_USER').":".env('SHOPIFY_PASS'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                  
        $result = curl_exec($curl);
		
        return $result;
    }
    
}
