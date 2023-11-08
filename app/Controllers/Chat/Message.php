<?php

namespace App\Controllers\Chat;

use App\Controllers\BaseController;
use App\Models\MessageModel;
// use App\Controllers\Admin\DbTableBackupDaily;

use Config\Services;

/**
 * 
 */
class Message extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index()
    {
        $dataset = [
            'pagetitle' => 'Message',
            'css' => ['/assets/bootstrap-datepicker/css/datepicker.css'], // use to add css specific to page.
            'js' => ['/assets/bootstrap-datepicker/js/bootstrap-datepicker.js', '/assets/js/message.js'] // use to add js specific to page.
        ];

        return view('admin/v_header', $dataset)
            . view('message/v_message')
            . view('admin/v_footer');
    }

    /**
     * datatables for promo4gambling model
     */

    public function datatable()
    {
        $postdata = $this->request->getPost();

        // instantiate model class
        $message = model(MessageModel::class);
        $orderby =  $postdata['columns'][$postdata['order'][0]['column']]['data']; // get proper orderby string

        $dataset = $message->get_datatable_data($postdata['length'], $postdata['start'], $orderby, $postdata['order'][0]['dir'], $postdata['search']['value']);

        return $this->response->setJSON($dataset);
    }

  

    /**
     * save csv file
     */

    public function save_data_csv()
    {
        $rules = [
            'csv_file' => [
                'label' => 'Uploaded File',
                'rules' => [
                    'uploaded[csv_file]', // check IF data is uploaded
                    'ext_in[csv_file,csv]' // if file extension is csv
                ],
                'errors' => [
                    'uploaded' => '请上传一个有效的文件 / Uploaded File is not a valid uploaded file.',
                    'ext_in' => '请上传一个有效的文件扩展名的文件 / Uploaded File does not have a valid file extension.'
                ]
            ], 
            'message' => [
                'message' => 'required', // message requires
                'errors' => [ // setting custom error response
                    'required' => '请输入用户名 / The Message field is required.'
                ]
            ], 
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 0, 'validation' => $this->validator->listErrors()]);
        }

        $csv_file = $this->request->getFile('csv_file');
        $message_post =  $this->request->getPost('message');
        //return $this->response->setJSON(['status' => 1, 'result' =>  $message_post]);
        $dataset = array(); // container for csv data
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < $num; $c += 2) {
                    $dataset[] = array(
                        'mobile_number' => $data[$c],
                    );
                }
            }

            array_shift($dataset); // remove 1st row.
            fclose($handle);
        }
        if (!$csv_file->hasMoved()) {
            // save a copy of uploads
            $filepath = WRITEPATH . 'uploads/' . $csv_file->store();
        }

        //backup old record
        // $dbTableBackupDaily = new DbTableBackupDaily();
        // $databup = $dbTableBackupDaily->backupTables(['betlist_1', 'promo_1'], "Promo_4deposit");

        //load model
        $message = model(MessageModel::class);

        $message->truncate(); // truncate table before transaction;
        // return $this->response->setJSON( [ 'status' => 0, 'validation' => 'error' ] );
        $new = 0;
        $mobile_number = "";
        foreach ($dataset as $row) {
            $insert_data = $message->insert_data($row);
            $mobile_number = $dataset;
            $new += 1;
        }
        // loop mobile number and send message to whatsapp
       $this->sendMessages($mobile_number,$message_post);
            
          
        log_message('alert', 'MessageModel/save_data_csv batch insert message. user: ' . $_SESSION['username'] . ' data: ' . $new . ' entries inserted. IP: ' . getUserIP());
        // insert to database
        //process data
        return $this->response->setJSON(['status' => 1, 'result' => $new . ' entries inserted.']);
    }

    public function sendMessages($mobile_number,$message_post){
        $apiToken = $_ENV['WHATSAPP_API_TOKEN'];
        $apiIntance = $_ENV['WHATSAPP_API_INSTANCE'];
        $endpoint = "https://api.ultramsg.com/" . $apiIntance . "/messages/chat";
        $params=array(
            'token' => $apiToken,
            'to' =>    $mobile_number,
            'body' =>  $message_post
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $endpoint,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => http_build_query($params),
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
              // if ($err) {
            //   echo "cURL Error #:" . $err;
            // } else {
            //   echo $response;
            // }


    }
}
