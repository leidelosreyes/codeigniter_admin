<?php

namespace App\Controllers\Admin\LandingPage;

use App\Controllers\BaseController;
use App\Models\LinkModel;
// use App\Controllers\Admin\DbTableBackupDaily;

use Config\Services;

/**
 * 
 */
class LinkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        $dataset = [
            'pagetitle' => 'Links',
            'css' => ['/assets/bootstrap-datepicker/css/datepicker.css'], // use to add css specific to page.
            'js' => ['/assets/bootstrap-datepicker/js/bootstrap-datepicker.js', '/assets/js/links.js'] // use to add js specific to page.
        ];

        return view('admin/v_header', $dataset)
            . view('admin/landing_page/v_link')
            . view('admin/v_footer');
    }

    public function datatable()
    {
        $postdata = $this->request->getPost();

        // instantiate model class
        $url = model(LinkModel::class);
        $orderby =  $postdata['columns'][$postdata['order'][0]['column']]['data']; // get proper orderby string

        $dataset = $url->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON($dataset);
    }

    public function save_data()
    {
        $postdata = $this->request->getPost();
        $rules = [
            'links' => [
                'links' => 'required',
                'errors' => [ // setting custom error response
                    'required' => '鏈接字段是必需的。',
                ]
            ],
            'key' => [
                'links' => 'required',
                'errors' => [ // setting custom error response
                    'required' => '鏈接字段是必需的。',
                ]
            ],
        ];
       
		if (! $this->validate($rules)) {
			return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
		}

		// save data
		$LinkModel = model(LinkModel::class);
		if($postdata['action_type'] == 'add')
		{
            log_message( 'alert', $postdata['links']);
			$result = $LinkModel->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New Links '.$postdata['links'].' with id '.$result['id'].' Successfully Registered.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
			}
		} else {
			//edit data
			$dataset = [
				'links' => $postdata['links'],
				'key' => $postdata['key'],
			];
			
			$result = $LinkModel->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'Role '.$postdata['links'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}
    }
    
	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$LinkModel = model(LinkModel::class);
		$result = $LinkModel->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}
}
