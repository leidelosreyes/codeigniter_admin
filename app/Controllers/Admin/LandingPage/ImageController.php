<?php

namespace App\Controllers\Admin\LandingPage;

use App\Controllers\BaseController;
use App\Models\Image;
use CodeIgniter\I18n\Time;
// use App\Controllers\Admin\DbTableBackupDaily;

use Config\Services;

/**
 * 
 */
class ImageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        $dataset = [
            'pagetitle' => 'Images',
            'css' => ['/assets/bootstrap-datepicker/css/datepicker.css'], // use to add css specific to page.
            'js' => ['/assets/bootstrap-datepicker/js/bootstrap-datepicker.js', '/assets/js/image.js'] // use to add js specific to page.
        ];

        return view('admin/v_header', $dataset)
            . view('admin/landing_page/v_image')
            . view('admin/v_footer');
    }

    public function datatable()
    {
        $postdata = $this->request->getPost();
        // instantiate model class
        $ads = model(Image::class);
        $orderby =  $postdata['columns'][$postdata['order'][0]['column']]['data']; // get proper orderby string

        $dataset = $ads->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON($dataset);
    }

    public function save_data()
    {
        
        $imageModel = model(Image::class);
        $postdata = $this->request->getPost();
        // log_message('error',  $postdata['action_type']);
         if($postdata['action_type']== 'add')
         {
            $rules = [
                'images' => [
                    'rules' =>'ext_in[images,png,jpg,gif]',
                    'errors' => [ // setting custom error response
                        'required' => '圖片 / The Image field is required.',
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'validation' => $this->validator->listErrors()]);
            }
            
             $image = $this->request->getFile('images');
             $imageName = $image->getRandomName();
             $image->move(ROOTPATH . 'public/uploads', $imageName);
             $postdata['images'] = $imageName;
             log_message( 'alert', $imageName);
             $result = $imageModel->insert_data($postdata);
             if($result['message'] == 'success'){
                 log_message( 'alert', ' data: {post_vars} . IP: '.getUserIP() );
                 return $this->response->setJSON([ 
                     'status' => 1, 
                     'id' => $result['id'],
                     'toast' => 'New Image '.$postdata['images'].' Successfully Registered.'
                 ]);
             } else {
                 return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
             }
         } else {
             //edit data
             $image = $this->request->getFile('images');
             if($image){
                $imageName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads', $imageName);
                $postdata['images'] = $imageName;
                $dataset = [
                    'images' =>  $postdata['images'] = $imageName
                ];
             }
             else{
                $dataset = [
                   'updated_at' => Time::now()
                ];
             }
             
             $result = $imageModel->update_data($postdata['action_type'], $dataset);
 
             if($result['message'] == 'success'){
                 log_message( 'alert', 'Image/save_data edit. ads:IP: '.getUserIP() );
                 return $this->response->setJSON([ 
                     'status' => 1, 
                     'id' => $result['id'],
                     'toast' => 'image  Successfully Updated.'
                 ]);
             } else {
                 return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
             }
 
         }
 
    }
    public function delete_data()
    {
        $postdata = $this->request->getPost();

        $imageModel = model(Image::class);
        $result = $imageModel->delete_data($postdata['id']); // soft delete
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
