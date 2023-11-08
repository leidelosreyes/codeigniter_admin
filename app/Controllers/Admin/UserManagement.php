<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use Config\Services;

include_once VENDORPATH.'sonata-project/google-authenticator/src/FixedBitNotation.php';
include_once VENDORPATH.'sonata-project/google-authenticator/src/GoogleAuthenticatorInterface.php';
include_once VENDORPATH.'sonata-project/google-authenticator/src/GoogleAuthenticator.php';
include_once VENDORPATH.'sonata-project/google-authenticator/src/GoogleQrUrl.php';

/**
 * 
 */
class UserManagement extends BaseController
{
	/**
	 * 
	 */
	
    public function index()
    {
		$RolesModel = model(RolesModel::class);

        $roles_list = $RolesModel->get_data_params(['deleted_at' => null]);
        
        $dataset = [
            'pagetitle' => '用户管理 / User Management',
            'roles_list' => $roles_list,
            'css' => [  ], // use to add css specific to page.
            'js' => [ '/assets/js/usermanagement.js' ] // use to add js specific to page.
        ];

        return view('admin/v_header' , $dataset)
            . view('admin/v_usermanagement')
            . view('admin/v_footer');
        
    }

    public function datatable(){
        $postdata = $this->request->getPost();

        // instantiate model class
		$UsersModel = model(UsersModel::class);

        $orderby =  $postdata['columns'][ $postdata['order'][0]['column'] ]['data']; // get proper orderby string

        $dataset = $UsersModel->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON( $dataset );
    }

    public function getGAuth()
    {
        //load google authenticator class
		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

        $secret = $g->generateSecret();
        $gimg = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate('AuthKey', $secret, getenv('appName'));
        return $this->response->setJSON([
            'gsecret' => $secret,
            'gimg' => $gimg,
            'toast' => 'New Google Authentication Code Generated.'
        ]);
    }

    public function getGAuthImg()
    {
        $postdata = $this->request->getPost();
        //load google authenticator class
		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

        $gimg = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate('AuthKey', $postdata['secret'], getenv('appName'));
        return $this->response->setJSON([
            'gimg' => $gimg
        ]);
    }

    public function save_data()
    {
        $postdata = $this->request->getPost();

        if($postdata['action_type'] == 'add')
        {
            // set rules for add
            $rules = [
                'username' => [
                    'label' => 'Username', // setting a label to field for validation error response.
                    'rules' => 'required|alpha_numeric|min_length[6]|is_unique[users.username]', // setting rules
                    'errors' => [ // setting custom error response
                        'required' => '请输入用户名 / The Username field is required.',
                        'alpha_numeric' => '用户名字段只能包含字母数字字符 / The Username field may only contain alphanumeric characters.',
                        'min_length' => '用户名字段必须至少有6个字符的长度 / The Username field must be at least 6 characters in length.',
                        'is_unique' => '用户名已使用 / Username is already in use.'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|alpha_numeric_punct|min_length[10]',
                    'errors' => [
                        'required' => '请输入密码 / The Password field is required.',
                        'alpha_numeric_punct' => '密码只能包含字母数字字符、空格和 ~ ! # $ % & * - _ + = | :.字符。 / The Password field may contain only alphanumeric characters, spaces, and ~ ! # $ % & * - _ + = | : . characters.',
                        'min_length' => '密码字段必须至少有10个字符的长度。 / The Password field must be at least 10 characters in length.'
                    ]
                ],
                'passconf' => [
                    'label' => 'Password Confirmation',
                    'rules' => 'required|alpha_numeric_punct|matches[password]',
                    'errors' => [ // setting custom error response
                        'required' => '请输入密码 / The Password Confirmation field is required.',
                        'alpha_numeric_punct' => '密码只能包含字母数字字符、空格和 ~ ! # $ % & * - _ + = | :.字符。 / The Password field may contain only alphanumeric characters, spaces, and ~ ! # $ % & * - _ + = | : . characters.',
                        'matches' => '密码确认与密码不匹配 / The Password Confirmation field does not match the Password field.'
                    ]
                ],
                'gsecret' => [
                    'label' => 'Google Auth Key',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '请填写谷歌认证码 / Google Auth Key required.'
                    ]
                ],
                'role_id' => [
                    'label' => 'User Role',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '请填写用户角色 / The User Role field is required.'
                    ]
                ],
                'email'    => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [ // setting custom error response
                        'required' => '请输入电子邮件 / The Email field is required.',
                        'valid_email' => '请提供一个有效的电子邮件。 / The Email field is not a valid Email.',
                        'is_unique' => '电子邮件已使用 / Email is already in use.'
                    ]
                ]
            ];

        } else {
            //rules for edit
            $rules = [
                'username' => [
                    'label' => 'Username', // setting a label to field for validation error response.
                    'rules' => 'required|alpha_numeric|min_length[6]|is_unique[users.username,id,{action_type}]', // setting rules
                    'errors' => [ // setting custom error response
                        'required' => '请输入用户名 / The Username field is required.',
                        'alpha_numeric' => '用户名字段只能包含字母数字字符 / The Username field may only contain alphanumeric characters.',
                        'min_length' => '用户名字段必须至少有6个字符的长度 / The Username field must be at least 6 characters in length.',
                        'is_unique' => '用户名已使用 / Username is already in use.'
                    ]
                ],
                'email'    => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email,id,{action_type}]',
                    'errors' => [ // setting custom error response
                        'required' => '请输入电子邮件 / The Email field is required.',
                        'valid_email' => '请提供一个有效的电子邮件。 / The Email field is not a valid Email.',
                        'is_unique' => '电子邮件已使用 / Email is already in use.'
                    ]
                ],
                'role_id' => [
                    'label' => 'User Role',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '请填写用户角色 / The User Role field is required.'
                    ]
                ],    
            ];
            //add rules IF password field is filled
            if($postdata['password'] != ''){
                $rules['password'] = [
                    'label' => 'Password',
                    'rules' => 'required|alpha_numeric_punct|min_length[10]',
                    'errors' => [
                        'required' => '请输入密码 / The Password field is required.',
                        'alpha_numeric_punct' => '密码只能包含字母数字字符、空格和 ~ ! # $ % & * - _ + = | :.字符。 / The Password field may contain only alphanumeric characters, spaces, and ~ ! # $ % & * - _ + = | : . characters.',
                        'min_length' => '密码字段必须至少有10个字符的长度。 / The Password field must be at least 10 characters in length.'
                    ]
                ];
                $rules['passconf'] = [
                    'label' => 'Password Confirmation',
                    'rules' => 'required|alpha_numeric_punct|matches[password]',
                    'errors' => [ // setting custom error response
                        'required' => '请输入密码 / The Password Confirmation field is required.',
                        'alpha_numeric_punct' => '密码只能包含字母数字字符、空格和 ~ ! # $ % & * - _ + = | :.字符。 / The Password field may contain only alphanumeric characters, spaces, and ~ ! # $ % & * - _ + = | : . characters.',
                        'matches' => '密码确认与密码不匹配 / The Password Confirmation field does not match the Password field.'
                    ]
                ];
            }
        }

        if (! $this->validate($rules)) {
            return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
        }

        // save data
        $UsersModel = model(UsersModel::class);
        if($postdata['action_type'] == 'add')
        {
            //one-way hash of password
            $postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
            $result = $UsersModel->insert_data($postdata);
            if($result['message'] == 'success'){
                log_message( 'alert', 'UserManagement/save_data add. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
                return $this->response->setJSON([ 
                    'status' => 1, 
                    'id' => $result['id'],
                    'toast' => 'New User '.$postdata['username'].' with user id '.$result['id'].' Successfully Registered.'
                ]);
            } else {
                return $this->response->setJSON( [ 'status' => 0, 'validation' => '保存数据时发生了错误。 / An error has occured in saving data.' ] );
            }
        } else {
            //edit data
            $dataset = [
                'username' => $postdata['username'],
                'email' => $postdata['email'],
                'gsecret' => $postdata['gsecret'],
                'role_id' => $postdata['role_id'],
            ];
            if($postdata['password'] != '')
            {
                $dataset['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
            }
            $result = $UsersModel->update_data($postdata['action_type'], $dataset);

            if($result['message'] == 'success'){
                log_message( 'alert', 'UserManagement/save_data edit. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
                return $this->response->setJSON([ 
                    'status' => 1, 
                    'id' => $result['id'],
                    'toast' => 'User '.$postdata['username'].' with user id '.$result['id'].' Successfully Updated.'
                ]);
            } else {
                return $this->response->setJSON( [ 'status' => 0, 'validation' => '在更新数据时发生了一个错误。 / An error has occured in updating data.' ] );
            }

        }

    }

    public function delete_data()
    {
        $postdata = $this->request->getPost();

        $UsersModel = model(UsersModel::class);
        $result = $UsersModel->delete_data($postdata['id']); // soft delete

        if($result['message'] == 'success'){
            log_message( 'alert', 'UserManagement/delete_data. user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
            return $this->response->setJSON([ 
                'status' => 1, 
                'id' => $result['id'],
                'toast' => 'User '.$postdata['username'].' with user id '.$result['id'].' Deleted.'
            ]);
        } else {
            return $this->response->setJSON( [ 'status' => 0, 'message' => '删除数据时发生了错误。 / An error has occured in deleting data.' ] );
        }

    }
}
