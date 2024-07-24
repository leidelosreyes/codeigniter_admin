<?php

namespace App\Controllers\Vip;

use App\Controllers\BaseController;
use App\Models\UrlModel;
use App\Models\AdsModel;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

/**
 * 
 */
class ApiController extends BaseController
{
  
    public function VipShowDetails()
    {
        $username = $this->request->getPost('username');
        $url = "http://rbadminmqnew.drvini8.xyz/getuserdata/".$username;
        $client = \Config\Services::curlrequest();

        try {
            // Send the cURL request and handle the response
            $response = $client->get($url);

            return $this->response->setJSON(json_decode($response->getBody(), true));

        } catch (\Exception $e) {
            // Handle cURL exceptions
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }
   
}
