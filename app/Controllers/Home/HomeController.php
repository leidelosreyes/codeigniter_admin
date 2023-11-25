<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;


/**
 * 
 */
class HomeController extends BaseController
{



    public function index()
    {
       

    return view('home/v_landing_page');
    }
   
}
