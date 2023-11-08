<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use Config\Services;

/**
 * 
 */
class PermissionManagement extends BaseController
{
	/**
	 * 
	 */
	
	public function index()
	{
		$dataset = [
			'pagetitle' => '权限管理 / Permission Management',
			'css' => [  ], // use to add css specific to page.
			'js' => [ '/assets/js/permissionmanagement.js' ] // use to add js specific to page.
		];

		return view('admin/v_header' , $dataset)
			. view('admin/v_permissionmanagement')
			. view('admin/v_footer');
	}

	public function datatable(){
		$postdata = $this->request->getPost();

		// instantiate model class
		$PermissionModel = model(PermissionModel::class);

		$orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

		$dataset = $PermissionModel->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

		return $this->response->setJSON( $dataset );
	}

	public function save_data()
	{
		$postdata = $this->request->getPost();

		if($postdata['action_type'] == 'add')
		{
			// set rules for add
			$rules = [
				'controller_method' => [
					'label' => 'Controller/Method', // setting a label to field for validation error response.
					'rules' => 'required|min_length[6]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '请输入控制器方法 / The Controller method field is required.',
						'min_length' => '控制器方法字段必须至少有6个字符的长度 / The Controller method field must be at least 6 characters in lenght.'
					]
				],
			];

		} else {
			//rules for edit
			$rules = [
				'controller_method' => [
					'label' => 'Controller/Method', // setting a label to field for validation error response.
					'rules' => 'required|min_length[6]|is_unique[permission.controller_method,id,{action_type}]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '请输入控制器方法 / The Controller method field is required.',
						'min_length' => '控制器方法字段必须至少有6个字符的长度 / The Controller method field must be at least 6 characters in lenght.',
						'is_unique' => '控制器方法已经存在 / Controller method already exist.'
					]
				],
			];
		}

		if (! $this->validate($rules)) {
			return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
		}

		// save data
		$PermissionModel = model(PermissionModel::class);
		if($postdata['action_type'] == 'add')
		{
			$result = $PermissionModel->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'PermissionManagement/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New Permission '.$postdata['controller_method'].' with id '.$result['id'].' Successfully Registered.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
			}
		} else {
			//edit data
			$dataset = [
				'controller_method' => $postdata['controller_method'],
				'perm_desc' => $postdata['perm_desc']
			];
			
			$result = $PermissionModel->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'PermissionManagement/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'Permission '.$postdata['controller_method'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}

	}

	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$PermissionModel = model(PermissionModel::class);
		$result = $PermissionModel->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'PermissionManagement/delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'Permission '.$postdata['controller_method'].' with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}

}
