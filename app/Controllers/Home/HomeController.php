<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;
use Config\Services;

/**
 * 
 */
class HomeController extends BaseController
{


    public function index()
    {
        
    
        
         return view('home/v_desktop');

       
    }

    public function index_mobile()
    {
        $url = base_url()."/getsysconfig/mob";
        $client = \Config\Services::curlrequest();
        try {
            // Send the cURL request and handle the response
            $response = $client->get($url);

            $body = $this->object_to_array(json_decode($response->getBody()));
            return view('home/v_mobile',['items' => $body]);

        } catch (\Exception $e) {
            // Handle cURL exceptions
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }
    private function object_to_array($d)
    {
        if (is_object($d))
            $d = get_object_vars($d);

        return is_array($d) ? array_map(__METHOD__, $d) : $d;
    }
}
