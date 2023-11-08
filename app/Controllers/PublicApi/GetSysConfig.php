<?php
namespace App\Controllers\PublicApi;
use App\Controllers\BaseController;

use CodeIgniter\I18n\Time;
/**
 * 
 */
class GetSysConfig extends BaseController
{


    public function index( string $data = '')
    {
        //log api access attempts
        log_message( 'alert', 'GetSysConfig/index. data: '.$data.' . IP: '.getUserIP() );
        
        // manual whitelisting //

        // $whitelisted = [
        //     'https://site1.com/',
        //     'https://site2.com/'
        // ];

        // if( in_array( $_SERVER['HTTP_ORIGIN'], $whitelisted ) )
        // {
        //     $allow = $_SERVER['HTTP_ORIGIN'];
        //     $this->response->setHeader('Access-Control-Allow-Origin', $allow);
        // }

        // Allow everyone //
        $this->response->setHeader('Access-Control-Allow-Origin', '*');

        // atleast 3 characters //
        if( strlen($data) < 3 )
        {
            return $this->response->setJSON( ['error' => '1'] );
        }

        //note: no need to filter out symbols as the routes will only accept alphanum. anything else will result in 404.

        $SysConfigModel = model(SysConfigModel::class);

        $dataset = $SysConfigModel->get_data_params_like( ['name' => $data], 'after' );

        return $this->response->setJSON( $dataset );
    }
}