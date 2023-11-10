<?php

namespace App\Controllers\Admin\Movies;

use App\Controllers\BaseController;
use App\Models\UrlModel;
// use App\Controllers\Admin\DbTableBackupDaily;

use Config\Services;

/**
 * 
 */
class UrlController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        $dataset = [
            'pagetitle' => '基本網址',
            'css' => ['/assets/bootstrap-datepicker/css/datepicker.css'], // use to add css specific to page.
            'js' => ['/assets/bootstrap-datepicker/js/bootstrap-datepicker.js', '/assets/js/url.js'] // use to add js specific to page.
        ];

        return view('admin/v_header', $dataset)
            . view('admin/movie/v_url')
            . view('admin/v_footer');
    }

    public function datatable()
    {
        $postdata = $this->request->getPost();

        // instantiate model class
        $url = model(UrlModel::class);
        $orderby =  $postdata['columns'][$postdata['order'][0]['column']]['data']; // get proper orderby string

        $dataset = $url->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON($dataset);
    }

    public function save_data()
    {
        $postdata = $this->request->getPost();
        $rules = [
            'url' => [
                'url' => 'required',
                'errors' => [ // setting custom error response
                    'required' => '鏈接字段是必需的。',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 0, 'validation' => $this->validator->listErrors()]);
        }
        $UrlModel = model(UrlModel::class);
        //edit data
        $dataset = [
            'base_url' => $postdata['url']
        ];

        $result = $UrlModel->update_data($postdata['id'], $dataset);
        if ($result['message'] == 'success') {
            return $this->response->setJSON([
                'status' => 1,
                'id' => $result['id'],
                'toast' => 'Url' . $postdata['url'].' Successfully Updated.'
            ]);
        } else {
            return $this->response->setJSON(['status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.']);
        }
    }
}
