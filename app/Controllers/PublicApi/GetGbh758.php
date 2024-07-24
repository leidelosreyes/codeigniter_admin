<?php
namespace App\Controllers\PublicApi;
use App\Controllers\BaseController;
use App\Models\Gbh758Model;
use CodeIgniter\I18n\Time;
/**
 * 
 */
class GetGbh758 extends BaseController
{


    public function index()
    {
       
        // Allow everyone //
        $this->response->setHeader('Access-Control-Allow-Origin', '*');

        // atleast 3 characters //
       
        //note: no need to filter out symbols as the routes will only accept alphanum. anything else will result in 404.

        $Gbh758Model = model(Gbh758Model::class);

        $dataset = $Gbh758Model->findAll();
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