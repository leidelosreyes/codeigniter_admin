<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

use Config\Services;

/**
 * 
 */
class MyProfile extends BaseController
{
	/**
	 * 
	 */
	
    public function index()
    {
        
        $UsersModel = model(UsersModel::class);
        $id = session()->get('userid'); 

        $userdata = $UsersModel->get_data( $id );

        $dataset = [
            'pagetitle' => '我的资料 / My Profile',
            'userdata' => $userdata,
            'css' => [  ], // use to add css specific to page.
            'js' => [ '/assets/js/myprofile.js' ] // use to add js specific to page.
        ];

        return view('admin/v_header' , $dataset)
            . view('admin/v_myprofile')
            . view('admin/v_footer');
    }

    public function save_data()
    {
        $postdata = $this->request->getPost();

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
            ]
        ];
        //add rules IF password field is filled
        if($postdata['password'] != ''){
            $rules['password'] = [
                'label' => 'Password',
                'rules' => 'required|alpha_numeric_punct|min_length[10]',
                'errors' => [ // setting custom error response
                    'required' => '请输入密码 / The Password field is required.',
                    'alpha_numeric_punct' => '密码只能包含字母数字字符、空格和 ~ ! # $ % & * - _ + = | :.字符。 / The Password field may contain only alphanumeric characters, spaces, and ~ ! # $ % & * - _ + = | : . characters.',
                    'min_length' => 'The Password field must be at least 10 characters in length.'
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
        
        if (! $this->validate($rules)) {
            return $this->response->setJSON( [ 'status' => 0, 'validation' => $this->validator->listErrors() ] );
        }

        // save data
        $UsersModel = model(UsersModel::class);
        //edit data
        $dataset = [
            'email' => $postdata['email'],
            'gsecret' => $postdata['gsecret'],
        ];
        if($postdata['password'] != '')
        {
            $dataset['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
        }
        $result = $UsersModel->update_data($postdata['action_type'], $dataset);

        if($result['message'] == 'success'){
            log_message( 'alert', 'MyProfile/save_data user: '.$_SESSION['username'].' data: {post_vars} . IP: '.getUserIP() );
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