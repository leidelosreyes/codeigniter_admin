<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\Gbhvip399Model;
use Config\Services;

/**
 * 
 */
class GbhVip399 extends BaseController
{
	/**
     *
     */
    public function index()
	{
		$dataset = [
			'pagetitle' => 'gbhvip399.com',
			'css' => [  ], // use to add css specific to page.
			'js' => [ '/assets/js/gbhvip399.js' ] // use to add js specific to page.
		];

		return view('admin/v_header' , $dataset)
			. view('admin/v_gbhvip399')
			. view('admin/v_footer');
	}

    public function datatable(){
		$postdata = $this->request->getPost();

		// instantiate model class
		$gbhvip399Model = model(Gbhvip399Model::class);

		$orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

		$dataset = $gbhvip399Model->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

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
		$gbhvip399Model = model(Gbhvip399Model::class);

		if($postdata['action_type'] == 'add')
		{
			$result = $gbhvip399Model->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'gbhvip399/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New gbhvip399 link'.$postdata['value'].' with id '.$result['id'].' Successfully Registered.'
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
			
			$result = $gbhvip399Model->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'gbhvip399/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'gbhvip399 '.$postdata['value'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}

	}

	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$gbhvip399Model = model(Gbhvip399Model::class);
		$result = $gbhvip399Model->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'gbhvip399/delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'gbhvip399 '.' with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}

}