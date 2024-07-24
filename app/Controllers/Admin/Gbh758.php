<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\Gbh758Model;
use Config\Services;

/**
 * 
 */
class Gbh758 extends BaseController
{
	/**
     *
     */
    public function index()
	{
		$dataset = [
			'pagetitle' => 'gbh758.com',
			'css' => [  ], // use to add css specific to page.
			'js' => [ '/assets/js/gbh758.js' ] // use to add js specific to page.
		];

		return view('admin/v_header' , $dataset)
			. view('admin/v_gbh758')
			. view('admin/v_footer');
	}

    public function datatable(){
		$postdata = $this->request->getPost();

		// instantiate model class
		$Gbh758Model = model(Gbh758Model::class);

		$orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

		$dataset = $Gbh758Model->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

		return $this->response->setJSON( $dataset );
	}
    
    public function save_data()
	{
		$postdata = $this->request->getPost();
        $validation = \Config\Services::validation();
		if($postdata['action_type'] == 'add')
		{
           
            $rules = [
                'item' => 'required',
                'value'=> 'required',
                'title'=> 'required'
            ];
            $messages = [
                'item' => [
                    'required' => '项目为必填项'
                ],
                'value' => [
                    'required' => '需要链接'
                ],
                'title' => [
                    'required' => '标题为必填项'
                ]
            ];
		} else {
            $rules = [
                'item' => 'required',
                'value'=> 'required',
                'title'=> 'required'
            ];
            $messages = [
                'item' => [
                    'required' => '项目为必填项'
                ],
                'value' => [
                    'required' => '需要链接'
                ],
                'title' => [
                    'required' => '标题为必填项'
                ]
            ];
		}
       

	
        $input = $this->validate($rules, $messages);

        if(!$input){
            return $this->response->setJSON( [ 'status' => 0, 'validation' => $validation->listErrors() ] );
        }

		// save data
		$Gbh758Model = model(Gbh758Model::class);

		if($postdata['action_type'] == 'add')
		{
			$result = $Gbh758Model->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'gbh758/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New gbh758 link'.$postdata['value'].' with id '.$result['id'].' Successfully Registered.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
			}
		} else {
			//edit data
			$dataset = [
				'item' => $postdata['item'],
				'value' => $postdata['value'],
				'title' => $postdata['title']
			];
			
			$result = $Gbh758Model->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'gbh758/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'gbh758 '.$postdata['value'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}

	}

	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$Gbh758Model = model(Gbh758Model::class);
		$result = $Gbh758Model->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'gbh758/delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'gbh758 '.' with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}

}