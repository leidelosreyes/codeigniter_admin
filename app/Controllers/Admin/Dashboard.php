<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

/**
 * 
 */
class Dashboard extends BaseController
{

    public function index()
    {
        
        $dataset = [
            'pagetitle' => 'Dashboard',
            'css' => [ ], // use to add css specific to page.
            'js' => [ '/assets/js/dasboard.js' ] // use to add js specific to page.
        ];

        return view('admin/v_header' , $dataset)
            . view('admin/v_dashboard')
            . view('admin/v_footer');
    }

    
}