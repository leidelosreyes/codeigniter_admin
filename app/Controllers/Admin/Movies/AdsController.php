<?php

namespace App\Controllers\Admin\Movies;

use App\Controllers\BaseController;
use App\Models\AdsModel;
// use App\Controllers\Admin\DbTableBackupDaily;

use Config\Services;

/**
 * 
 */
class AdsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        $dataset = [
            'pagetitle' => 'Ads',
            'css' => ['/assets/bootstrap-datepicker/css/datepicker.css'], // use to add css specific to page.
            'js' => ['/assets/bootstrap-datepicker/js/bootstrap-datepicker.js', '/assets/js/ads.js'] // use to add js specific to page.
        ];

        return view('admin/v_header', $dataset)
            . view('admin/movie/v_ads')
            . view('admin/v_footer');
    }

    public function datatable()
    {
        $postdata = $this->request->getPost();
        // instantiate model class
        $ads = model(AdsModel::class);
        $orderby =  $postdata['columns'][$postdata['order'][0]['column']]['data']; // get proper orderby string

        $dataset = $ads->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON($dataset);
    }

    public function save_data()
    {
        $AdsModel = model(AdsModel::class);
        $postdata = $this->request->getPost();
    
         if($postdata['action_type']== 'add')
         {
             $image = $this->request->getFile('images');
             $imageName = $image->getRandomName();
             $image->move(ROOTPATH . 'public/uploads', $imageName);
             $postdata['images'] = $imageName;
             $result = $AdsModel->insert_data($postdata);
             if($result['message'] == 'success'){
                 log_message( 'alert', ' data: {post_vars} . IP: '.getUserIP() );
                 return $this->response->setJSON([ 
                     'status' => 1, 
                     'id' => $result['id'],
                     'toast' => 'New Link '.$postdata['link'].' Successfully Registered.'
                 ]);
             } else {
                 return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
             }
         } else {
             //edit data
             $dataset = [
                 'link' => $postdata['link'],
                 'description' => $postdata['description'],
             ];
             $result = $AdsModel->update_data($postdata['action_type'], $dataset);
 
             if($result['message'] == 'success'){
                 log_message( 'alert', 'Ads/save_data edit. ads:IP: '.getUserIP() );
                 return $this->response->setJSON([ 
                     'status' => 1, 
                     'id' => $result['id'],
                     'toast' => 'User '.$postdata['link'].' Successfully Updated.'
                 ]);
             } else {
                 return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
             }
 
         }
 
    }
    public function delete_data()
    {
        $postdata = $this->request->getPost();

        $AdsModel = model(AdsModel::class);
        $result = $AdsModel->delete_data($postdata['id']); // soft delete
        if($result['message'] == 'success'){
            log_message( 'alert', 'delete_data. user: IP: '.getUserIP() );
            return $this->response->setJSON([ 
                'status' => 1, 
                'id' => $result['id'],
                'toast' => 'Ads '.$postdata['id'].' Deleted.'
            ]);
        } else {
            return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
        }

    }
}
