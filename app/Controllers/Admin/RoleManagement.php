<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use Config\Services;

/**
 * 
 */
class RoleManagement extends BaseController
{
	/**
	 * 
	 */

	public function index()
	{
		// instantiate model class
		$PermissionModel = model(PermissionModel::class);

		$permission_list = $PermissionModel->get_data_params(['deleted_at' => null]);

		$dataset = [
			'pagetitle' => '角色管理 / Role Management',
			'permission_list' => $permission_list,
			'css' => [  ], // use to add css specific to page.
			'js' => [ '/assets/js/rolemanagement.js' ] // use to add js specific to page.
		];

		return view('admin/v_header' , $dataset)
			. view('admin/v_rolemanagement')
			. view('admin/v_footer');
	}

	public function datatable(){
		$postdata = $this->request->getPost();

		// instantiate model class
		$RolesModel = model(RolesModel::class);

		$orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

		$dataset = $RolesModel->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

		return $this->response->setJSON( $dataset );
	}

	public function save_data()
	{
		$postdata = $this->request->getPost();

		if( isset($postdata['permission_id']) ){
			$postdata['permission_id'] = implode(",", $postdata['permission_id']);
		} else {
			$postdata['permission_id'] = null;
		}

		if($postdata['action_type'] == 'add')
		{
			// set rules for add
			$rules = [
				'role_name' => [
					'label' => 'Role name', // setting a label to field for validation error response.
					'rules' => 'required|min_length[4]|is_unique[roles.role_name]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '请输入角色名称 / The Role name field is required.',
						'min_length' => '角色名称必须至少有4个字符的长度 / The Role name field must be at least 4 characters in length',
						'is_unique' => '角色名称已经存在 / Role name already exist.'
					]
				],
				'permission_id' => [
					'label' => 'Permission Id',
					'rules' => 'required',
					'errors' => [ // setting custom error response
						'required' => '请至少选择一个权限 / Please select atleast 1 permission.'
					]
				]
			];

		} else {
			//rules for edit
			$rules = [
				'role_name' => [
					'label' => 'Role name', // setting a label to field for validation error response.
					'rules' => 'required|min_length[4]|is_unique[roles.role_name,id,{action_type}]', // setting rules
					'errors' => [ // setting custom error response
						'required' => '请输入角色名称 / The Role name field is required.',
						'min_length' => '角色名称必须至少有4个字符的长度 / The Role name field must be at least 4 characters in length',
						'is_unique' => '角色名称已经存在 / Role name already exist.'
					]
				],
				'permission_id' => [
					'label' => 'Permission Id',
					'rules' => 'required',
					'errors' => [ // setting custom error response
						'required' => '请至少选择一个权限 / Please select atleast 1 permission.'
					]
				]
			];
		}

		if (! $this->validate($rules)) {
			return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
		}

		// save data
		$RolesModel = model(RolesModel::class);
		if($postdata['action_type'] == 'add')
		{
			$result = $RolesModel->insert_data($postdata);
			if($result['message'] == 'success'){
				log_message( 'alert', 'RoleManagement/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'New Role '.$postdata['role_name'].' with id '.$result['id'].' Successfully Registered.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
			}
		} else {
			//edit data
			$dataset = [
				'role_name' => $postdata['role_name'],
				'role_desc' => $postdata['role_desc'],
				'permission_id' => $postdata['permission_id']
			];
			
			$result = $RolesModel->update_data($postdata['action_type'], $dataset);

			if($result['message'] == 'success'){
				log_message( 'alert', 'RoleManagement/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
				return $this->response->setJSON([ 
					'status' => 1, 
					'id' => $result['id'],
					'toast' => 'Role '.$postdata['role_name'].' with id '.$result['id'].' Successfully Updated.'
				]);
			} else {
				return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
			}

		}

	}

	public function delete_data()
	{
		$postdata = $this->request->getPost();

		$RolesModel = model(RolesModel::class);
		$result = $RolesModel->delete_data($postdata['id']); // soft delete

		if($result['message'] == 'success'){
			log_message( 'alert', 'RoleManagement/delete_data . user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
			return $this->response->setJSON([ 
				'status' => 1, 
				'id' => $result['id'],
				'toast' => 'Role '.$postdata['role_name'].' with id '.$result['id'].' Deleted.'
			]);
		} else {
			return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
		}

	}

}