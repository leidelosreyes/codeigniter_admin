<?php
namespace App\Controllers\PublicApi;
use App\Controllers\BaseController;
use App\Models\Gbh012Model;
use CodeIgniter\I18n\Time;
/**
 * 
 */
class GetGbh012 extends BaseController
{


    public function index()
    {
       
        // Allow everyone //
        $this->response->setHeader('Access-Control-Allow-Origin', '*');

        // atleast 3 characters //
       
        //note: no need to filter out symbols as the routes will only accept alphanum. anything else will result in 404.

        $Gbh012Model = model(Gbh012Model::class);

        $dataset = $Gbh012Model->findAll();
        foreach ($dataset as &$item) {
            unset($item['id'],$item['created_at'],$item['deleted_at'],$item['updated_at']);
        }

        return $this->response->setJSON( [
            'errno' => 0,
            'error' => null,
            'data'=> [$dataset] 
            ] );
    }
}