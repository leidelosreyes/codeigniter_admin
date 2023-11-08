<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use Config\Services;

include_once VENDORPATH . 'sonata-project/google-authenticator/src/FixedBitNotation.php';
include_once VENDORPATH . 'sonata-project/google-authenticator/src/GoogleAuthenticatorInterface.php';
include_once VENDORPATH . 'sonata-project/google-authenticator/src/GoogleAuthenticator.php';
include_once VENDORPATH . 'sonata-project/google-authenticator/src/GoogleQrUrl.php';

class Login extends BaseController
{
    /**
     * Load required helpers for TestRegistration
     */
    protected $helpers = ['form'];

    public function index()
    {
        
        // if request is not post method. assume it is get and show form.
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('v_login');
        }
        $postdata = $this->request->getPost();
       
        // if request is POST method. set rules for validation.
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|alpha_numeric|min_length[6]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|alpha_numeric_punct'
            ],
            'gsecret' => [
                'label' => 'Google Auth Key',
                'rules' => 'required|numeric|min_length[6]'
            ]
        ];
        // Run validation using declared rules. If rule array is empty, validation by default will return false. If validation fails, show form with prepopulated data, show error.
        if (!$this->validate($rules)) {
            log_message( 'alert', 'login fail. user: '.$postdata['username'].' pass: '.$postdata['password'].'. IP: '.getUserIP() );
            return $this->response->setJSON(['status' => 0, 'message' => 'Login Failed 2.']);
        }
       
        // instantiate model class
        $UsersModel = model(UsersModel::class);

        //load google authenticator
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

        $result = $UsersModel->get_data_params(['username' => $postdata['username']]);

        //return of get_data_params is multi-dimensional array
        if ( count($result) == 1 && password_verify($postdata['password'], $result[0]['password']) && $g->checkCode($result[0]['gsecret'], $postdata['gsecret']) ) {
            $RolesModel = model(RolesModel::class);

            $role_data = $RolesModel->get_data_params( ['id' => $result[0]['role_id']] );
            $permission_list_id = explode(",", $role_data[0]['permission_id']);

            $PermissionModel = model(PermissionModel::class);
            $permission_list = $PermissionModel->get_data($permission_list_id);

            $permission_set = [];
            foreach ($permission_list as $row) {
                $permission_set[] = $row['controller_method'];
            }

            // login success. do your session, set permission/roles if any, then do a redirect on the jquery call.
            $session_data = [
                'userid' => $result[0]['id'],
                'username' => $result[0]['username'],
                'email' => $result[0]['email'],
                'permission_set' => $permission_set,
                'logged_in' => true,
            ];

            log_message( 'alert', 'login success: '.$postdata['username'].'. IP: '.getUserIP() );

            $this->session->set($session_data);

            return $this->response->setJSON(['status' => 1, 'message' => 'Login Success.']);
        } else {
            //login fail
            log_message( 'alert', 'login fail. user: '.$postdata['username'].' pass: '.$postdata['password'].'. IP: '.getUserIP() );
            return $this->response->setJSON(['status' => 0, 'message' => 'Login Failed 1.']);
        }
    }

    public function logstatus()
    {
        if (session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 1, 'message' => 'Logged in']);
        } else {
            return $this->response->setJSON(['status' => 0, 'message' => 'Logged out']);
        }
    }

    public function logout()
    {
        $array_items = ['username', 'email', 'logged_in', 'userid', 'permission_set'];
        $this->session->remove($array_items);
        return redirect()->to('xoy75hZUKrBPCe2');
    }
}
