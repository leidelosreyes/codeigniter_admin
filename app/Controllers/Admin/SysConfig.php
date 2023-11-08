<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use App\Models\SysConfigModel;
use Config\Services;

/**
 * 
 */
class SysConfig extends BaseController
{
	/**
     *
     */
    public function index()
	{
		$dataset = [
			'pagetitle' => '系统配置 / System Configuration',
			'css' => [  ], // use to add css specific to page.
			'js' => [ '/assets/js/sysconfig.js' ] // use to add js specific to page.
		];

		return view('admin/v_header' , $dataset)
			. view('admin/v_sysconfig')
			. view('admin/v_footer');
	}

    public function datatable(){
		$postdata = $this->request->getPost();

		// instantiate model class
		$SysConfigModel = model(SysConfigModel::class);

		$orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

		$dataset = $SysConfigModel->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

		return $this->response->setJSON( $dataset );
	}
    
    public function save_data()
	{
		$postdata = $this->request->getPost();

		if($postdata['action_type'] == 'add')
		{
			// set rules for add
			$rules = [
				'name' => [
					'label' => 'Name', // setting a label to field for validation error response.
					'rules' => 'required|min_length[4]|is_unique[sysconfig.name]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '系统配置 / The Name field is required.',
						'min_length' => '名称必须至少有4个字符的长度 / The Name field must be at least 4 characters in length',
						'is_unique' => '名称已经存在。 / Name already exist.'
					]
				]
			];

		} else {
			//rules for edit
			$rules = [
				'name' => [
					'label' => 'Name', // setting a label to field for validation error response.
					'rules' => 'required|min_length[4]|is_unique[sysconfig.name,id,{action_type}]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '系统配置 / The Name field is required.',
						'min_length' => '名称必须至少有4个字符的长度 / The Name field must be at least 4 characters in length',
						'is_unique' => '名称已经存在。 / Name already exist.'
					]
				]
			];
		}

		if (! $this->validate($rules)) {
			return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
		}

		// save data
		$SysConfigModel = model(SysConfigModel::class);

		if($postdata['action_type'] == 'add')
		{
			$result = $SysConfigModel->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'SysConfig/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New Sys Config '.$postdata['name'].' with id '.$result['id'].' Successfully Registered.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
			}
		} else {
			//edit data
			$dataset = [
				'name' => $postdata['name'],
				'sys_desc' => $postdata['sys_desc'],
				'sys_value' => $postdata['sys_value']
			];
			
			$result = $SysConfigModel->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'SysConfig/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'Sys Config '.$postdata['name'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}

	}

	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$SysConfigModel = model(SysConfigModel::class);
		$result = $SysConfigModel->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'SysConfig/delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'Sys Config '.$postdata['name'].' with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}

}