<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        phpinfo();
        
        /*
        $dataset = [
            'pagetitle' => 'Home',
            'css' => [  ], // use to add css specific to page.
            'js' => [ '/assets/js/home.js' ] // use to add js specific to page.
        ];
        
        return view('v_home' , $dataset);*/
    }
}
